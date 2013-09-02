<?php

class RatingModule extends BaseModule
{
	/**
	 * @var string
	 */
	public $moduleName = 'rating';

	/**
	 * Init module
	 */
	public function init()
	{
		$this->setImport(array(
			'rating.models.Rating',
		));
	}
    
    public function afterInstall()
    {
        $db = Yii::app()->db;
        $db->createCommand()->createTable('rating', array(
                'user_id'    => 'INT(11) UNSIGNED NOT NULL',
                'product_id' => 'INT(11) UNSIGNED NOT NULL',
                'param1' => 'TINYINT(1)',
                'param2' => 'TINYINT(1)',
                'param3' => 'TINYINT(1)',
                'PRIMARY KEY (user_id, product_id)',
            ),
            'ENGINE=MYISAM CHARSET=utf8'
        );
    } 
        
}