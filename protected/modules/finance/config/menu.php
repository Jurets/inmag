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
		'position' => 4,
        'items'=>array(
            array(
                'label'=>Yii::t('FinanceModule.admin', 'Статистика'),
                'url'=>Yii::app()->createUrl('/finance/admin/statistics'),
                'position'=>5
            ),
            array(
                'label'=>Yii::t('FinanceModule.admin', 'Операции'),
                'url'=>Yii::app()->createUrl('/finance/admin/index'),
                'position'=>1
            ),                                    
        ),
	),
);