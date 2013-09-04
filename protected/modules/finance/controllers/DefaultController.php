<?php

class DefaultController extends Controller
{
    /**
     * Check if user is authenticated
     * @return bool
     * @throws CHttpException
     */
    public function beforeAction($action)
    {
        if(Yii::app()->user->isGuest)
            throw new CHttpException(404, Yii::t('FinanceModule.core', 'Ошибка доступа.'));
        return true;
    }
    
    public function actionIndex()
    {
        $userId = Yii::app()->user->id;
        $model = new Operation('search');

        $dataProvider = $model->search();
        $dataProvider->criteria->condition = 'user_id = '.$userId;
        $dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');
        

        $this->render('index', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ));
    }
}
