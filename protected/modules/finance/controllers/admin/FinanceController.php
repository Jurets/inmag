<?php

/**
 * Admin site finance
 */
class FinanceController extends SAdminController
{

	/**
	 * Display all site finance
	 */
	public function actionIndex()
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
    
    public function actionOperations()
    {
//        DebugBreak();
        $model = new UserFinance('search');
        $model->unsetAttributes();

        if (!empty($_GET['UserFinance']))
            $model->attributes = $_GET['UserFinance'];

        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');
        
//        Yii::import('application.modules.core.CoreModule');
//        $modelSystem = new SystemSettingsForm;
//        $form = new STabbedForm('_form', $model);
//        $form = new CTabView('_form', $model);
        $this->render('index', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
//            'form'=>$form,
        ));
    }
    
    public function actionOperationView()
    {
//        DebugBreak();
        $model = CActiveRecord::model('UserFinance')->findByPk($_GET['user_id']);

        if (!$model)
            throw new CHttpException(400, 'Bad request.');

        $form = new SAdminForm('application.modules.users.views.admin.default.userForm', $model);

        $form['userfinance']->model = $model;
        $form['profile']->model = $model->profile;

        if(Yii::app()->request->isPostRequest)
        {
            $model->attributes = $_POST['UserFinance'];
            $model->profile->attributes = $_POST['UserProfile'];

            $valid = $model->validate() && $model->profile->validate();

            if($valid)
            {
                $model->save();
                if(!$model->profile->user_id)
                    $model->profile->user_id=$model->id;
                $model->profile->save();

                $this->setFlashMessage(Yii::t('FinanceModule.core', 'Изменения успешно сохранены'));

                if (isset($_POST['REDIRECT']))
                    $this->smartRedirect($model);
                else
                    $this->redirect(array('index'));
            }
        }

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
    
    public function actionProcess() {
        $model = New Operation;
        $model->attributes = $_POST['Operation'];
        
        //begin validation
        if ($model->validate()) {
            //get model of user of operation
            $user = User::model()->findByPk($model->user_id);  
            //get model of system user
            $system = User::model()->findByPk(UserFinance::SYSTEM_ID);

            //define source of operation
            if ($model->role == 3 && $model->type == 1)  
                $source = $system;    
            else if ($model->role == 4 && $model->type == 2)
                $source = $user;
            else if ($model->role == 3 && $model->type == 2)
                $source = $user;
                
            //check source account amount
            if ($source->balance < $model->amount)
                $model->addError('balance', 'Баланса источника не хватает для выполнения операции');
        }
        
        //do operation in DB
        $transaction = Yii::app()->db->beginTransaction();
        try {       
            //process money transfer between accounts
            if ($model->role == 3 && $model->type == 1) {          //from system to worker (3)
                $system->balance -= $model->amount;
                $user->balance   += $model->amount;
            } else if ($model->role == 3 && $model->type == 2){    //from worker to outside (4)
                $user->balance   -= $model->amount;
            } else if ($model->role == 4 && $model->type == 1){    //from outside to customer (1)
                $user->balance   += $model->amount;
            } else if ($model->role == 4 && $model->type == 2){    //from customer to system (2)
                $user->balance   -= $model->amount;
                $system->balance += $model->amount;
            }
            
            //try to save operation to table
            if (!$model->save(false))
                throw New Exception('Ошибка при сохранении операции');

            $transaction->commit();           
        }
        catch(Exception $e){
            $transaction->rollback();
        }        
    }
}
