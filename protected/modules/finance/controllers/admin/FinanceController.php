<?php

/**
 * Admin site finance
 */
class FinanceController extends SAdminController
{
    
    public function actionIndex()
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
        $model = UserFinance::model()->findByPk($_GET['user_id']);
        $operationModel = new Operation();
        $operation = $_GET['operation'];

        if (!$model)
            throw new CHttpException(400, 'Bad request.');

        $form = new SAdminForm('application.modules.finance.views.admin.finance._form', $model);

        $form['UserFinance']->model = $model;
        $form['profile']->model = $model->profile;
        $form['operation']->model = $operationModel;

        if(Yii::app()->request->isPostRequest)
        {
//            $model->attributes = $_POST['UserFinance'];
//            $model->profile->attributes = $_POST['UserProfile'];
//
//            $valid = $model->validate() && $model->profile->validate();
//
//            if($valid)
//            {
//                $model->save();
//                if(!$model->profile->user_id)
//                    $model->profile->user_id=$model->id;
//                $model->profile->save();
//
//                $this->setFlashMessage(Yii::t('FinanceModule.core', 'Изменения успешно сохранены'));
//
//                if (isset($_POST['REDIRECT']))
//                    $this->smartRedirect($model);
//                else
//                    $this->redirect(array('index'));
//            }
        }

        $this->render('view', array(
            'model'=>$model,
            'operationModel'=>$operationModel,
            'operation'=>$operation,
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
    
}
