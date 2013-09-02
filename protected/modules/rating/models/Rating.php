<?php

/**
 * This is the model class for table "rating".
 *
 * The followings are the available columns in table 'rating':
 * @property string $user_id
 * @property string $product_id
 * @property integer $param1
 * @property integer $param2
 * @property integer $param3
 */
class Rating extends CActiveRecord
{
    public $sum_params;
    public $avg_params;
    public $name;
    public $sumparam1;
    public $sumparam2;
    public $sumparam3;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rating the static model class
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
		return 'rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, product_id', 'required'),
			array('param1, param2, param3', 'numerical', 'integerOnly'=>true),
			array('user_id, product_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, user_id, product_id, param1, param2, param3', 'safe', 'on'=>'searchProduct'),
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
            'user'            => array(self::BELONGS_TO, 'User', 'user_id'),
            'product'         => array(self::BELONGS_TO, 'StoreProduct', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'product_id' => 'Product',
			'param1' => Yii::t('RatingModule.core', 'Param1'),
			'param2' => 'Param2',
            'param3' => 'Param3',
            'sumparam1' => Yii::t('RatingModule.core', 'Param1'),
            'sumparam2' => Yii::t('RatingModule.core', 'Param2'),
            'sumparam3' => Yii::t('RatingModule.core', 'Param3'),
            'sum_params' => Yii::t('RatingModule.core', 'Sum of Params'),
			'avg_params' => Yii::t('RatingModule.core', 'Avg of Params'),
            'name' => Yii::t('RatingModule.core', 'Name'),
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

        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('product_id',$this->product_id,true);
        $criteria->compare('param1',$this->param1);
        $criteria->compare('param2',$this->param2);
        $criteria->compare('param3',$this->param3);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchProduct()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('product_id',$this->product_id);
        $criteria->compare('name',$this->name, true);
        //$criteria->select = 'product_id, sum(param1) as param1, sum(param2) as param2, sum(param3) as param3, sum(param1 + param2 + param3) as sum_params, sum((param1 + param2 + param3) / 3) as avg_params';
        $criteria->select = 't.product_id, translate.name as prodname, sum(t.param1) as sumparam1, sum(t.param2) as sumparam2, sum(t.param3) as sumparam3, sum(t.param1 + t.param2 + t.param3) as sum_params, sum((t.param1 + t.param2 + t.param3) / 3) as avg_params';
        $criteria->with = array('product.translate');
        $criteria->group = 'product_id';
        /*if (isset($this->param1) && !empty($this->param3))
            $criteria->having = 'sum(param3) = ' . $this->param3;*/
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'       => Rating::getCSort(),
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
            'name' => array(
                'asc'   => 'translate.name',
                'desc'  => 'translate.name DESC',
            ),
            'sumparam1' => array(
                'asc'   => 'sumparam1',
                'desc'  => 'sumparam1 DESC',
            ),
            'sumparam2' => array(
                'asc'   => 'sumparam2',
                'desc'  => 'sumparam2 DESC',
            ),
            'sumparam3' => array(
                'asc'   => 'sumparam3',
                'desc'  => 'sumparam3 DESC',
            ),
            'sum_params' => array(
                'asc'   => 'sum_params',
                'desc'  => 'sum_params DESC',
            ),
            'avg_params' => array(
                'asc'   => 'avg_params',
                'desc'  => 'avg_params DESC',
            ),
        );
        return $sort;
    }

    
    public static function getRating($id){
        $userId = Yii::app()->user->id;
        if(isset($userId)){
            $rating = Rating::model()->findByAttributes(array('user_id' => $userId, 'product_id' => $id));
            return $rating;
        }else{
            return false;
        }
    }
    
    public static function getAverageRating($productId){
        $avg = Yii::app()->db->createCommand('SELECT AVG(param1 + param2 + param3) FROM rating
                                                WHERE product_id = :productId
                                                GROUP BY product_id')->queryScalar(array(':productId' => $productId));
        return $avg;
    }
 
}