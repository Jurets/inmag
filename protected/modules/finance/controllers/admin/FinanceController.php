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

        //if(!empty($_GET['Operation']))
        //    $model->attributes = $_GET['Operation'];

        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

        $this->render('statistics', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ));
        $this->render('index');
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
        
    }
}
