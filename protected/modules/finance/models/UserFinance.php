<?php
Yii::import('application.modules.users.models.User');
Yii::import('application.modules.users.UsersModule');

class UserFinance extends User
{
    const ROLE_MODERATOR = 1;
    const ROLE_WORKER = 3;
    const ROLE_CUSTOMER = 4;
    
    const OPERATION_DEPOSIT = 1;   //пополнение счета 
    const OPERATION_WITHDRAW = 2;  //снятие со счета
    
    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('role, balance', 'safe', 'on'=>'search'),
        ));
    }
    
    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'balance' => Yii::t('FinanceModule.core', 'Balance'),
            'role'    => Yii::t('FinanceModule.core', 'Role'),
        ));        
    }
    
    public static function getRoleName($id) 
    {
        switch ($id) {
            case 1: $rolename = Yii::t('FinanceModule.core', 'Admin'); break;
            case 3: $rolename = Yii::t('FinanceModule.core', 'Worker'); break;
            case 4: $rolename = Yii::t('FinanceModule.core', 'Customer'); break;
            default: $rolename = Yii::t('FinanceModule.core', 'Unknown');
        }
        return $rolename;
    }
    
}