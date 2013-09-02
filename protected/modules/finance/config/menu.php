<?php
/**
 * @var $this SSystemMenu
 */

Yii::import('finance.FinanceModule');
Yii::import('finance.models.*');

/**
 * Admin menu items for pages module
 */
return array(
	array(
		'label'    => Yii::t('FinanceModule.core', 'Финансы'),
		'url'      => array('/finance/admin/index'),
		'position' => 4,
        'items'=>array(
            array(
                'label'=>Yii::t('FinanceModule.core', 'Пополнение счета заказчика'),
                'url'=>Yii::app()->createUrl('/finance/admin/operations', array('opId'=>UserFinance::OPERATION_DEPOSIT)),
                'position'=>1
            ),
            array(
                'label'=>Yii::t('FinanceModule.core', 'Пополнение счета исполнителя'),
                'url'=>Yii::app()->createUrl('/finance/admin/operations', array('opId'=>UserFinance::OPERATION_DEPOSIT)),
                'position'=>3
            ),
            array(
                'label'=>Yii::t('FinanceModule.core', 'Списание со счета заказчика'),
                'url'=>Yii::app()->createUrl('/finance/admin/operations', array('opId'=>UserFinance::OPERATION_WITHDRAW)),
                'position'=>2
            ),
            array(
                'label'=>Yii::t('FinanceModule.core', 'Вывод средств исполнителя'),
                'url'=>Yii::app()->createUrl('/finance/admin/operations', array('opId'=>UserFinance::OPERATION_WITHDRAW)),
                'position'=>4
            ),
            array(
                'label'=>Yii::t('FinanceModule.admin', 'Статистика'),
                'url'=>Yii::app()->createUrl('/finance/admin/statistics'),
                'position'=>5
            ),                        
        ),
	),
);