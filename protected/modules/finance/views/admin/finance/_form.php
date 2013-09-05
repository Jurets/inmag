<?php
//DebugBreak();
/**
 * User create/update form data 
 */
Yii::import('zii.widgets.jui.CJuiDatePicker');
$title = $this->model->role == UserFinance::ROLE_WORKER ? 
    ($this->model->operationType == UserFinance::OPERATION_DEPOSIT ? Yii::t('FinanceModule.core', 'Пополнить из системы') : Yii::t('FinanceModule.core', 'Снятие со счета исполнителя')) :
    ($this->model->operationType == UserFinance::OPERATION_DEPOSIT ? Yii::t('FinanceModule.core', 'Пополнение счета заказчика') : Yii::t('FinanceModule.core', 'Списать в систему'));

return array(
	'id'=>'userUpdateForm',
	'showErrorSummary'=>true,
	'elements'=>array(
		'UserFinance'=>array(
			'type'=>'form',
			'title'=>'',
			'elements'=>array(
                'id'=>array('type'=>'hidden'),
				'username'=>array(
					'type'=>'text',
                    'disabled'=>'disabled',
				),
                'roleName'=>array('type'=>'text','disabled'=>'disabled'),
                'balance'=>array('type'=>'text','disabled'=>'disabled'),
				'systemBalance'=>array('type'=>'text','disabled'=>'disabled'),                
			),
		),
        'operation'=>array(
            'type'=>'form',
            'title'=>$title,
            'elements'=>array(
                'user_id'=>array('type'=>'hidden'),
                'role'=>array('type'=>'hidden'),
                'type'=>array('type'=>'hidden'),
                'amount'=>array('type'=>'text'),
                'trans_id'=>array('type'=>'text'),
                'comment'=>array('type'=>'textarea'),
            ),
        ),
	),
);
