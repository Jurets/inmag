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
            array('created, user_id, role, type, amount', 'required'),
			array('role, type', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('user_id', 'length', 'max'=>11),
			array('comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created, user_id, role, type, amount, comment, username', 'safe', 'on'=>'search'),
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
			'created' => Yii::t('FinanceModule.core', 'Created'),
			'user_id' => Yii::t('FinanceModule.core', 'User'),
			'role' => Yii::t('FinanceModule.core', 'Role'),
			'type' => Yii::t('FinanceModule.core', 'Type'),
			'amount' => Yii::t('FinanceModule.core', 'Amount'),
			'comment' => Yii::t('FinanceModule.core', 'Comment'),
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
		//$criteria->compare('user_id',$this->user_id);
        $criteria->compare('username',$this->username,true);
		$criteria->compare('t.role',$this->role);
		$criteria->compare('type',$this->type);
		$criteria->compare('amount',$this->amount);
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
        //$sort->defaultOrder = 't.created DESC';
        $sort->attributes=array(
            '*',
            'username' => array(
                'asc'   => 'user.username',
                'desc'  => 'user.username DESC',
            ),
        );
        return $sort;
    }
    
    public function getRoleName() 
    {
        switch ($this->role) {
            case UserFinance::ROLE_MODERATOR: $rolename = Yii::t('FinanceModule.core', 'Admin'); break;
            case UserFinance::ROLE_WORKER: $rolename = Yii::t('FinanceModule.core', 'Worker'); break;
            case UserFinance::ROLE_CUSTOMER: $rolename = Yii::t('FinanceModule.core', 'Customer'); break;
            default: $rolename = Yii::t('FinanceModule.core', 'Unknown');
        }
        return $rolename;
    }
    
    //
    public static function getOperationText($role, $type) 
    {
        if ($role == 3 && $type == 1)
            $opname = Yii::t('FinanceModule.core', 'Charge the worker account');
        else if ($role == 3 && $type == 2)
            $opname = Yii::t('FinanceModule.core', 'Debit the worker account');
        else if ($role == 4 && $type == 1)
            $opname = Yii::t('FinanceModule.core', 'Charge the customer account');
        else if ($role == 4 && $type == 2)
            $opname = Yii::t('FinanceModule.core', 'Debit the customer account');
        return $opname;
    }

    //
    public function getOperationName()
    {
        if ($this->role == 3 && $this->type == 1)
            $opname = Yii::t('FinanceModule.core', 'Charge the worker account');
        else if ($this->role == 3 && $this->type == 2)
            $opname = Yii::t('FinanceModule.core', 'Debit the worker account');
        else if ($this->role == 4 && $this->type == 1)
            $opname = Yii::t('FinanceModule.core', 'Charge the customer account');
        else if ($this->role == 4 && $this->type == 2)
            $opname = Yii::t('FinanceModule.core', 'Debit the customer account');
        return $opname;
    }
    
}