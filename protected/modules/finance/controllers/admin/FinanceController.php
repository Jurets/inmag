<?php

/**
 * Admin site finance
 */
class FinanceController extends SAdminController
{
    
    public function actionIndex()
    {
        $model = new UserFinance('search');
        $model->unsetAttributes();

        if (!empty($_GET['UserFinance']))
            $model->attributes = $_GET['UserFinance'];

        $dataProvider = $model->nosystem()->onlyfinance()->search();
        $dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');
        
        $system = User::model()->findByPk(UserFinance::SYSTEM_ID); //get system user
        
        $this->render('index', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
            'system'=>$system,
        ));
    }
    
    public function actionOperationView()
    {
        $type = Yii::app()->request->getParam('operation');
        $model = UserFinance::model()->findByPk($_GET['user_id']);
        $model->systemBalance = $model->getSystemBalance();
        $model->operationType = $type;
        if (!$model)
            throw new CHttpException(400, 'Bad request.');

        $operation = new Operation();

        if(Yii::app()->request->isPostRequest) {
            if ($this->process($operation)) {
                $this->setFlashMessage(Yii::t('UsersModule.core', 'Изменения успешно сохранены'));
                $this->redirect(array('index'));
            }
        } else {
            $operation->user_id = $model->id;
            $operation->role = $model->role;
            $operation->type = $type;
        }

        $form = new SAdminForm('application.modules.finance.views.admin.finance._form', $model);

        $form['UserFinance']->model = $model;
        $form['profile']->model = $model->profile;
        $form['operation']->model = $operation;

        $this->render('view', array(
            'model'=>$model,
            'form'=>$form,
        ));
    }
    
    /**
     * Display all site finance
     */
    public function actionStatistics()
    {
        $model = new Operation('search');

        if(!empty($_GET['Operation']))
            $model->attributes = $_GET['Operation'];

        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

        $this->render('statistics', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ));
    }
    
    public function process($model) {
        //$model = New Operation;
        $model->attributes = $_POST['Operation'];
        
        //begin validation
        if ($model->validate()) {
            //get model of user of operation
            $user = User::model()->findByPk($model->user_id);  
            //get model of system user
            $system = User::model()->findByPk(UserFinance::SYSTEM_ID);

            //define source of operation
            if ($model->role == UserFinance::ROLE_WORKER && $model->type == UserFinance::OPERATION_DEPOSIT)  
                $source = $system;    
            else if ($model->role == UserFinance::ROLE_CUSTOMER && $model->type == UserFinance::OPERATION_WITHDRAW)
                $source = $user;
            else if ($model->role == UserFinance::ROLE_WORKER && $model->type == UserFinance::OPERATION_WITHDRAW)
                $source = $user;
            
            //check source account amount
            if (is_object($source) /*&& $model->type == UserFinance::OPERATION_WITHDRAW*/ && $source->balance < $model->amount)
                $model->addError('amount', 'Баланса источника не хватает для выполнения операции');
        }
        
        if ($model->hasErrors())
           return false; 
        
        //do operation in DB
        $transaction = Yii::app()->db->beginTransaction();
        try {       
            //process money transfer between accounts
            if ($model->role == UserFinance::ROLE_WORKER && $model->type == UserFinance::OPERATION_DEPOSIT) {          //from system to worker (3)
                $system->balance -= $model->amount;
                $user->balance   += $model->amount;
            } else if ($model->role == UserFinance::ROLE_WORKER && $model->type == UserFinance::OPERATION_WITHDRAW){    //from worker to outside (4)
                $user->balance   -= $model->amount;
            } else if ($model->role == UserFinance::ROLE_CUSTOMER && $model->type == UserFinance::OPERATION_DEPOSIT){    //from outside to customer (1)
                $user->balance   += $model->amount;
            } else if ($model->role == UserFinance::ROLE_CUSTOMER && $model->type == UserFinance::OPERATION_WITHDRAW){    //from customer to system (2)
                $user->balance   -= $model->amount;
                $system->balance += $model->amount;
            }
            
            //try to save operation to table
            if (!$model->save(false))
                throw New Exception('Ошибка при сохранении операции');

            if (!$user->save(false))
                throw New Exception('Ошибка при изменении баланса пользователя');
            
            if (!$system->save(false))
                throw New Exception('Ошибка при изменении баланса системы');
                
            $transaction->commit();           
        }
        catch(Exception $e){
            $transaction->rollback();
            return false;
        }    
        
        return true;    
    }
}
