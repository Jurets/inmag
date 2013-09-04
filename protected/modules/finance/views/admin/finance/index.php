<style type="text/css">
.image-button-position-up img{     
     width: 14px;
     height: 14px;
     background-position: -192px -144px;
}
</style>
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
    $systemBalance = $system->balance;

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
            array(
                'name'=>'banned',
                'filter'=>array(1=>Yii::t('FinanceModule.admin', 'Да'), 0=>Yii::t('FinanceModule.admin', 'Нет')),
                'value'=>'$data->banned ? Yii::t("FinanceModule.admin", "Да") : Yii::t("FinanceModule.admin", "Нет")'
            ),
            array(
                'name'=>'role',
                'type'=>'raw',
                'filter'=>array(UserFinance::ROLE_CUSTOMER => Yii::t('FinanceModule.core', 'Заказчик'), UserFinance::ROLE_WORKER => Yii::t('FinanceModule.core', 'Исполнитель')),
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
                'value'=>'$data->roleName',
            ),
            array(
                'name'=>'balance',
                'type'=>'raw',
                'filter'=>false,
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
            array(
                'class'=>'CButtonColumn',
                'htmlOptions' => array('style' => 'width: 200px;'),
                'template'=>'{plus} {minus}',
                'buttons'=>array(
                    'plus'=>array(
                        //'visible' => '($data->role == UserFinance::ROLE_CUSTOMER) || (($data->role == UserFinance::ROLE_WORKER) && ('. $systemBalance . ' > 0))',
                        'visible' => '$data->role == UserFinance::ROLE_CUSTOMER ? true : ($data->role == UserFinance::ROLE_WORKER ? '. $systemBalance . ' > 0 : false)',
                        //'visible' => '$data->role == UserFinance::ROLE_WORKER && '. $systemBalance . ' > 0',
                        //'label'=>$data->role == UserFinance::ROLE_CUSTOMER ? Yii::t("FinanceModule.core", "Пополнить извне") : Yii::t("FinanceModule.core", "Пополнить из системы"),
                        'label'=>Yii::t("FinanceModule.core", "Пополнить"),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operationView/", array("operation"=>UserFinance::OPERATION_DEPOSIT, "user_id"=>$data->id))',
                    ),
                    'minus'=>array(
                        'visible' => '$data->balance > 0 && ($data->role == UserFinance::ROLE_CUSTOMER || $data->role == UserFinance::ROLE_WORKER)',
                        //'label'=>Yii::t('FinanceModule.core', 'Снятие'),
                        //'label'=>$data->role == UserFinance::ROLE_CUSTOMER ? Yii::t("FinanceModule.core", "Списать в систему") : Yii::t("FinanceModule.core", "Вывести"),
                        'label'=>Yii::t("FinanceModule.core", "Списать"),
                        //'imageUrl'=>Yii::app()->createUrl('/protected/modules/finance/assets/img/icons.png'),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operationView/", array("operation"=>UserFinance::OPERATION_WITHDRAW, "user_id"=>$data->id))',
                        //'options'=>array(
                        //    'class'=>'image-button-position-up',
                        //),
                    ),
                ),
            ),
        ),
    ));
    