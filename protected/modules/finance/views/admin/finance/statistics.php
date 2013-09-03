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
    $dateFilter = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name'=>'Operation[created]',
        'value'=>$model->created,
        'options'=>array(
            'dateFormat'=>'yy-mm-dd'/*.date('H:i:s')*/,
        ),
        'htmlOptions' => array(
            'id'=>'Operation_created',
            //'style'=>'background-image: url("../images/calendar.png");'
        ),
    ), true);
    
    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$dataProvider,
        'id'=>'operationsListGrid',
        'filter'=>$model,
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns'=>array(
            array(
                'class'=>'SGridIdColumn',
                'name'=>'id',
            ),
            array(
                'name'=>'created',
                'filter'=>$dateFilter,
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
                'filter'=>UserFinance::getRoleNames()
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


Yii::app()->clientScript->registerScript('re-install-date-picker', "
        function reinstallDatePicker(id, data) {
            $('#Operation_created').datepicker({dateFormat: 'yy-mm-dd'});
        }
    ");
    
?>
