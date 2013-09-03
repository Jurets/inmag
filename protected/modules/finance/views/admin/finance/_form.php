<?php
//DebugBreak();
/**
 * User create/update form data 
 */
Yii::import('zii.widgets.jui.CJuiDatePicker');

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
                'role'=>array('type'=>'text','disabled'=>'disabled',/*'value'=>UserFinance::getRoleName($data->role)*/),
				'balance'=>array('type'=>'text','disabled'=>'disabled'),
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
            'title'=>'',
            'elements'=>array(
                'amount'=>array('type'=>'text'),
            ),
        ),
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
