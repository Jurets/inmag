<?php

/**
 * Display finance list
 *
 * @var $model Finance
 **/

$this->pageHeader = Yii::t('FinanceModule.core', 'Финансы. Статистика');

$this->breadcrumbs = array(
    'Home'=>$this->createUrl('/admin'),
    Yii::t('FinanceModule.core', 'Финансы')=>$this->createUrl('/admin/finance'),
    Yii::t('FinanceModule.core', 'Statistics'),
);
?>

<?
    $dateFilter = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name'=>'Operation[created]',
        'value'=>$model->created,
        'options'=>array(
            'dateFormat'=>'yy-mm-dd',
        ),
        'htmlOptions' => array(
            'id'=>'Operation_created',
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
                'value'=>'CHtml::link(CHtml::encode($data->user->username),array("update","id"=>$data->user_id))',
            ),
            array(
                'name'=>'role',
                'type'=>'raw',
                'value'=>'$data->roleName',
                'filter'=>UserFinance::getRoleNames()
            ),
            array(
                'name'=>'type',
                'type'=>'raw',
                'value'=>'$data->operationName',
                'filter'=>Operation::getOperationNames(),
            ),
            array(
                'name'=>'amount',
                'type'=>'raw',
            ),
            array(
                'name'=>'trans_id',
                'type'=>'raw',
            ),
            array(
                'name'=>'comment',
                'type'=>'raw',
            ),
        ),
    ));


    Yii::app()->clientScript->registerScript('re-install-date-picker', "
        function reinstallDatePicker(id, data) {
            $('#Operation_created').datepicker({dateFormat: 'yy-mm-dd'});
        }
    ");
    
?>
