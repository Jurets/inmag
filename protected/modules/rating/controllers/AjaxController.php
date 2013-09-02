<?php

/**
 * Handle ajax requests
 */
class AjaxController extends Controller 
{
    
    
    /**
     * Rate product
     * @param integer $id product id
     */
    public function actionRateProduct($id)
    {
        $request = Yii::app()->request;
        if($request->isAjaxRequest)
        {
            $userId = Yii::app()->user->id;

            $model = Rating::getRating($id);
            if($model === null)
            {
                $model = new Rating();
                $model->product_id = $id;
                $model->user_id = $userId;
            }

            if(isset($_GET['param1'])) $model->param1 = (int) $_GET['param1'];
            if(isset($_GET['param2'])) $model->param2 = (int) $_GET['param2'];
            if(isset($_GET['param3'])) $model->param3 = (int) $_GET['param3'];

            $model->save(false);
        }
    }
    
    public function filters()
    {
        return CMap::mergeArray(parent::filters(),array(
            'accessControl', // perform access control for CRUD operations
        ));
    }
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow authorized users to perform 'index' and 'view' actions
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}
?>
