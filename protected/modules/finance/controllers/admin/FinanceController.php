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
//        DebugBreak();
//		$model = new Rating('searchProduct');
//
//		if(!empty($_GET['Rating']))
//			$model->attributes = $_GET['Rating'];
//
//		$dataProvider = $model->searchProduct();
//		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');
//
//		$this->render('index', array(
//			'model'=>$model,
//			'dataProvider'=>$dataProvider
//		));
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
