<?php
//DebugBreak();
/**
 * User create/update form data 
 */
Yii::import('zii.widgets.jui.CJuiDatePicker');
$title=$this->model->role == 3 ? ($this->model->operationType == 1 ? Yii::t('FinanceModule.core', 'Пополнить из системы') : Yii::t('FinanceModule.core', 'Снятие со счета исполнителя')) :
                                 ($this->model->operationType == 1 ? Yii::t('FinanceModule.core', 'Пополнение счета заказчика') : Yii::t('FinanceModule.core', 'Списать в систему'));

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
//                'email'=>array('type'=>'text',),
                //'role'=>array('type'=>'text','disabled'=>'disabled'/*, 'value'=>$model->roleName*/),
                'roleName'=>array('type'=>'text','disabled'=>'disabled'),
                //'role'=>array('type'=>'hidden'),
                'balance'=>array('type'=>'text','disabled'=>'disabled'),
				'systemBalance'=>array('type'=>'text','disabled'=>'disabled'),                
//                'deposit'=>array('type'=>'text'),
//				'created_at'=>array(
//					'type'=>'CJuiDatePicker',
//					'options'=>array(
//						'dateFormat'=>'yy-mm-dd '.date('H:i:s'),
//					),
//				),
//				'last_login'=>array(
//					'type'=>'CJuiDatePicker',
//					'options'=>array(
//						'dateFormat'=>'yy-mm-dd '.date('H:i:s'),
//					),
//				),
//				'login_ip'=>array('type'=>'text',),
//				'discount'=>array('type'=>'text',),
//				'new_password'=>array(
//					'type'=>'password',
//				),
//				'banned'=>array(
//					'type'=>'checkbox'
//				),               
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
//        'systemBalance'=>array(
//            'type'=>'form',
//            'title'=>'',
//            'elements'=>array(
//                'balance'=>array('type'=>'text'),
//            ),
//        ),        
//		'profile'=>array(
//			'type'=>'form',
//			'title'=>'Данные профиля',
//			'elements'=>array(
//				'full_name'=>array(
//					'type'=>'text',
//				),
//				'phone'=>array(
//					'type'=>'text',
//				),
//				'delivery_address'=>array(
//					'type'=>'textarea',
//				),
//			),
//		),
	),
);
