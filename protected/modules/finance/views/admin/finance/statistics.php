<?php

/**
 * Display finance list
 *
 * @var $model Finance
 **/

//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/rating.index.js');

$this->pageHeader = Yii::t('FinanceModule.core', 'Statistics');

$this->breadcrumbs = array(
    'Home'=>$this->createUrl('/admin'),
    Yii::t('FinanceModule.core', 'Statistics'),
);
?>

<?
/*
$this->sidebarContent = $this->renderPartial('/_menu', null, true);

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('new'),
        'elements'=>array(
            'new'=>array(
                'link'=>$this->createUrl('create'),
                'title'=>Yii::t('FinanceModule.core', 'Создать пользователя'),
                'options'=>array(
                    'icons'=>array('primary'=>'ui-icon-person')
                )
            ),
        ),
    ));
*/
    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$dataProvider,
        'id'=>'operationsListGrid',
        'filter'=>$model,
        'columns'=>array(
            array(
                'class'=>'SGridIdColumn',
                'name'=>'id',
            ),
            array(
                'name'=>'created',
            ),
            array(
                'name'=>'username',
                'type'=>'raw',
                //'value' => 'Chtml::encode($data->user->username)',
                'value'=>'CHtml::link(CHtml::encode($data->user->username),array("update","id"=>$data->user_id))',
            ),
            array(
                'name'=>'role',
                'type'=>'raw',
                'value'=>'UserFinance::getRoleName($data->role)',
            ),
            array(
                'name'=>'type',
                'type'=>'raw',
                'value'=>'Operation::getOperationName($data->role, $data->type)',
            ),
            array(
                'name'=>'amount',
                'type'=>'raw',
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
        ),
    ));
    
?>
