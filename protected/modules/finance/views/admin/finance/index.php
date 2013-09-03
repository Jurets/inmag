<?php

/**
 * Display finance list
 *
 * @var $model Finance
 **/

$this->pageHeader = Yii::t('FinanceModule.core', 'Операции');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('FinanceModule.core', 'Операции'),
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
        'id'=>'usersListGrid',
        'filter'=>$model,
        'columns'=>array(
            array(
                'class'=>'SGridIdColumn',
                'name'=>'id',
            ),
            array(
                'name'=>'username',
                'type'=>'raw',
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
           'email',
            'discount',
            array(
                'name'=>'created_at',
            ),
            array(
                'name'=>'banned',
                'filter'=>array(1=>Yii::t('FinanceModule.admin', 'Да'), 0=>Yii::t('FinanceModule.admin', 'Нет')),
                'value'=>'$data->banned ? Yii::t("FinanceModule.admin", "Да") : Yii::t("FinanceModule.admin", "Нет")'
            ),
            array(
                'name'=>'last_login',
            ),
            array(
                'name'=>'username',
                'type'=>'raw',
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
            array(
                'name'=>'role',
                'type'=>'raw',
                'filter'=>array(UserFinance::ROLE_CUSTOMER => Yii::t('FinanceModule.core', 'Заказчик'), UserFinance::ROLE_WORKER => Yii::t('FinanceModule.core', 'Исполнитель')),
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
            array(
                'name'=>'balance',
                'type'=>'raw',
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
                'buttons'=>array(
                    'update'=>array(
                        'label'=>Yii::t('FinanceModule.core', 'Пополнение'),
//                        'url'=>Yii::app()->createUrl('finance/admin/finance/operations/', array('operation'=>UserFinance::OPERATION_DEPOSIT, 'user_id'=>2)),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operationView/", array("operation"=>UserFinance::OPERATION_DEPOSIT, "user_id"=>$data->id))',
                    ),
                    'delete'=>array(
                        'label'=>Yii::t('FinanceModule.core', 'Снятие'),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operationView/", array("operation"=>UserFinance::OPERATION_WITHDRAW, "user_id"=>$data->id))',
                    ),
                ),
            ),
        ),
    ));
    