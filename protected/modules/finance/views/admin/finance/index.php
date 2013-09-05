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

$this->pageHeader = Yii::t('FinanceModule.core', 'Финансы. Операции');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('FinanceModule.core', 'Финансы')=>$this->createUrl('/admin/finance'),
    Yii::t('FinanceModule.core', 'Операции'),
);

    $user = New UserFinance;
    //$systemBalance = $system->balance;
    
?>
<span><?php echo Yii::t('FinanceModule.core', 'Баланс системы:') ?> <strong><?php echo $user->systemBalance ?></strong></span>

<?
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
                'value'=>'$data->roleName',
            ),
            array(
                'name'=>'balance',
                'type'=>'raw',
            ),
            array(
                'class'=>'CButtonColumn',
                'htmlOptions' => array('style' => 'width: 200px;'),
                'template'=>'{cust_in} {cust_out} {work_in} {work_out}',
                'buttons'=>array(
                    'cust_in'=>array(
                        'visible' => '$data->role == UserFinance::ROLE_CUSTOMER',
                        'label'=>Yii::t("FinanceModule.core", "Пополнить"),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operation/", array("id"=>UserFinance::OPERATION_DEPOSIT, "user_id"=>$data->id))',
                    ),
                    'cust_out'=>array(
                        'visible' => '$data->role == UserFinance::ROLE_CUSTOMER && $data->balance > 0',
                        'label'=>Yii::t("FinanceModule.core", "Списать"),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operation/", array("id"=>UserFinance::OPERATION_WITHDRAW, "user_id"=>$data->id))',
                    ),
                    
                    'work_in'=>array(
                        'visible' => '$data->role == UserFinance::ROLE_WORKER && '. $user->systemBalance . ' > 0',
                        'label'=>Yii::t("FinanceModule.core", "Пополнить"),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operation/", array("id"=>UserFinance::OPERATION_DEPOSIT, "user_id"=>$data->id))',
                    ),
                    'work_out'=>array(
                        'visible' => '$data->role == UserFinance::ROLE_WORKER && $data->balance > 0',
                        'label'=>Yii::t("FinanceModule.core", "Вывести"),
                        'url'=>'Yii::app()->createUrl("finance/admin/finance/operation/", array("id"=>UserFinance::OPERATION_WITHDRAW, "user_id"=>$data->id))',
                    ),
                ),
            ),
        ),
    ));
    