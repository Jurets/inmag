<?php
Yii::import('application.modules.users.models.User');
Yii::import('application.modules.users.UsersModule');

class UserFinance extends User
{
    const ROLE_MODERATOR = 1;
    const ROLE_CUSTOMER = 3;
    const ROLE_WORKER = 4;
    
    const OPERATION_DEPOSIT = 1;   //пополнение счета 
    const OPERATION_WITHDRAW = 2; //снятие со счета
    
    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('role, balance', 'safe', 'on'=>'search'),
        ));
    }
    
    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'balance'           => Yii::t('FinanceModule.core', 'Баланс'),
            'role'           => Yii::t('FinanceModule.core', 'Роль'),
        ));        
    }
    
}