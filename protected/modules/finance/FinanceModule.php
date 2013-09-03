<?php

class FinanceModule extends BaseModule
{
	/**
	 * @var string
	 */
	public $moduleName = 'finance';

	/**
	 * Init module
	 */
	public function init()
	{
		$this->setImport(array(
			'finance.models.*',
		));
	}
    
    /***
    * DB-operations during module installing
    * 
    */
    public function afterInstall()
    {
        $db = Yii::app()->db;
        //add new columns in table user
        $db->createCommand()->addColumn('user', 'role', 'TINYINT(1) UNSIGNED NOT NULL');
        $db->createCommand()->addColumn('user', 'balance', 'FLOAT(10, 2)');
        //new table for operations (transactions)
        $db->createCommand()->createTable('operation', array(
                'id'         => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                'created'    => 'DATETIME NOT NULL',
                'user_id'    => 'INT(11) UNSIGNED NOT NULL',
                'role'       => 'TINYINT(1) UNSIGNED NOT NULL',
                'type'       => 'TINYINT(1) NOT NULL',
                'amount'     => 'FLOAT(10, 2) NOT NULL',
                'comment'    => 'TEXT DEFAULT NULL',
                'PRIMARY KEY (id)',
            ),
            'ENGINE=MYISAM CHARSET=utf8'
        );
    } 
        
    /***
    * DB-operations during module removing
    * 
    */
    public function afterRemove()
    {
        $db = Yii::app()->db;
        //add new columns in table user
        $db->createCommand()->dropColumn('user', 'role');
        $db->createCommand()->dropColumn('user', 'balance');
        //new table for operations (transactions)
        $db->createCommand()->dropTable('operation');
    }
        
}