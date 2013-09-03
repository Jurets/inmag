<?php
Yii::import('application.modules.users.models.User');
Yii::import('application.modules.users.UsersModule');

class UserFinance extends User
{
    const SYSTEM_ID = 0;

    const ROLE_MODERATOR = 1;
    const ROLE_WORKER = 3;
    const ROLE_CUSTOMER = 4;
    
    const OPERATION_DEPOSIT = 1;   //пополнение счета 
    const OPERATION_WITHDRAW = 2;  //снятие со счета
    
    public $operation;
    
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('role, balance, id', 'numerical'),
            array('role, balance, operation', 'safe', 'on'=>'search'),
        ));
    }
    
    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'balance' => Yii::t('FinanceModule.core', 'Balance'),
            'role'    => Yii::t('FinanceModule.core', 'Role'),
        ));        
    }
    
    public static function getRoleText($id) 
    {
        switch ($id) {
            case self::ROLE_MODERATOR: $rolename = Yii::t('FinanceModule.core', 'Admin'); break;
            case self::ROLE_WORKER: $rolename = Yii::t('FinanceModule.core', 'Worker'); break;
            case self::ROLE_CUSTOMER: $rolename = Yii::t('FinanceModule.core', 'Customer'); break;
            default: $rolename = Yii::t('FinanceModule.core', 'Unknown');
        }
        return $rolename;
    }

    public function getRoleName() 
    {
        switch ($this->role) {
            case self::ROLE_MODERATOR: $rolename = Yii::t('FinanceModule.core', 'Admin'); break;
            case self::ROLE_WORKER: $rolename = Yii::t('FinanceModule.core', 'Worker'); break;
            case self::ROLE_CUSTOMER: $rolename = Yii::t('FinanceModule.core', 'Customer'); break;
            default: $rolename = Yii::t('FinanceModule.core', 'Unknown');
        }
        return $rolename;
    }
    
    public static function getRoleNames() 
    {
        return array(
            //Yii::t('FinanceModule.core', 'Admin'),
            3=>Yii::t('FinanceModule.core', 'Worker'),
            4=>Yii::t('FinanceModule.core', 'Customer'),
        );
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('created_at',$this->created_at, true);
        $criteria->compare('last_login',$this->last_login);
        $criteria->compare('banned',$this->banned);
        $criteria->compare('role',$this->role);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }    
}