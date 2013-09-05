<?php

/**
 * This is the model class for table "operation".
 *
 * The followings are the available columns in table 'operation':
 * @property string $id
 * @property string $created
 * @property string $user_id
 * @property integer $role
 * @property integer $type
 * @property double $amount
 * @property string $comment
 */
class Operation extends CActiveRecord
{
    public $username;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Operation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created', 'default', 'value'=>CTimestamp::formatDate('Y-m-d H:i:s')),
            array('created, user_id, role, type, amount, trans_id', 'required'),
			array('role, type', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('user_id', 'length', 'max'=>11),
			array('comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created, user_id, role, type, amount, comment, username, trans_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created' => Yii::t('FinanceModule.core', 'Дата Операции'),
			'user_id' => Yii::t('FinanceModule.core', 'Пользователь'),
			'role' => Yii::t('FinanceModule.core', 'Роль'),
			'type' => Yii::t('FinanceModule.core', 'Тип Операции'),
			'amount' => Yii::t('FinanceModule.core', 'Сумма'),
            'comment' => Yii::t('FinanceModule.core', 'Коментарий'),
			'trans_id' => Yii::t('FinanceModule.core', 'ID Транзакции'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        
        $criteria->with = array('user');
        
		$criteria->compare('id',$this->id);
		$criteria->compare('created',$this->created,true);
		
        $criteria->compare('username',$this->username,true);
		$criteria->compare('t.role',$this->role);
		$criteria->compare('type',$this->type);
		$criteria->compare('amount',$this->amount);
        $criteria->compare('trans_id',$this->trans_id,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'    => self::getCSort(),
		));
	}

    /**
     * @return CSort to use in gridview, listview, etc...
     */
    public static function getCSort()
    {
        $sort = new CSort;
        $sort->defaultOrder = array(
                'created'=>CSort::SORT_DESC,
            );
        $sort->attributes=array(
            '*',
            'username' => array(
                'asc'   => 'user.username',
                'desc'  => 'user.username DESC',
            ),
        );
        return $sort;
    }
    
    /**
    * Get role name by role id
    * 
    */
    public function getRoleName() 
    {
        switch ($this->role) {
            case UserFinance::ROLE_MODERATOR: $rolename = Yii::t('FinanceModule.core', 'Админ'); break;
            case UserFinance::ROLE_WORKER: $rolename = Yii::t('FinanceModule.core', 'Исполнитель'); break;
            case UserFinance::ROLE_CUSTOMER: $rolename = Yii::t('FinanceModule.core', 'Заказчик'); break;
            default: $rolename = Yii::t('FinanceModule.core', 'Неизвестен');
        }
        return $rolename;
    }
    

    /**
    * get operation name by operation type id
    * 
    */
    public function getOperationName()
    {
        if ($this->role == UserFinance::ROLE_WORKER && $this->type == UserFinance::OPERATION_DEPOSIT)
            $opname = Yii::t('FinanceModule.core', 'Пополнение счета исполнителя'); 
        else if ($this->role == UserFinance::ROLE_WORKER && $this->type == UserFinance::OPERATION_WITHDRAW)
            $opname = Yii::t('FinanceModule.core', 'Снятие со счета исполнителя');
        else if ($this->role == UserFinance::ROLE_CUSTOMER && $this->type == UserFinance::OPERATION_DEPOSIT)
            $opname = Yii::t('FinanceModule.core', 'Пополнение счета заказчика');
        else if ($this->role == UserFinance::ROLE_CUSTOMER && $this->type == UserFinance::OPERATION_WITHDRAW)
            $opname = Yii::t('FinanceModule.core', 'Снятие со счета заказчика');
        return $opname;
    }
 
 
    /**
    * get operation name by operation type id
    * 
    */
    public static function getOperationNames()
    {
        return array(
            UserFinance::OPERATION_DEPOSIT => Yii::t('FinanceModule.core', 'Пополнение'),
            UserFinance::OPERATION_WITHDRAW => Yii::t('FinanceModule.core', 'Снятие') 
        );
    }

}