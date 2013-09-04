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
    {//DebugBreak();
        $db = Yii::app()->db;
      //add new columns in table user
        //$table_user = $db->schema->getTable('user');  //firstly define existing of table
        //if (is_object($table_operation)) {
            //$columnNames = is_object($table_operation) ? $table_user->columnNames : array();
            //$rolecolumn = is_object($table_operation) ? $table_operation->getColumn('role') : null;
            //$balancecolumn = is_object($table_operation) ? $table_operation->getColumn('balance') : null;
        //} 
        {
            //if ($rolecolumn === null)
            if (!$this->checkColumnExist('user', 'role'))
                $db->createCommand()->addColumn('user', 'role', 'TINYINT(1) UNSIGNED NOT NULL');
            //if ($balancecolumn === null)
            if (!$this->checkColumnExist('user', 'balance'))
                $db->createCommand()->addColumn('user', 'balance', 'FLOAT(10, 2)');
        }

      //new table for operations (transactions)
        //$table_operation = $db->schema->getTable('operation');  //firstly define existing of table
        //if (is_object($table_operation)) {                      //if exist
        //    $db->createCommand()->dropTable('operation');       //drop table
        //    $table_operation = null;
        //}
        //if ($table_operation === null) {                        //then create new table
        if (!$this->checkTableExist('operation')) {                        //then create new table
            $db->createCommand()->createTable('operation', array(
                    'id'         => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    'created'    => 'DATETIME NOT NULL',
                    'user_id'    => 'INT(11) UNSIGNED NOT NULL',
                    'role'       => 'TINYINT(1) UNSIGNED NOT NULL',
                    'type'       => 'TINYINT(1) NOT NULL',
                    'amount'     => 'FLOAT(10, 2) NOT NULL',
                    'trans_id'   => 'VARCHAR(255)',
                    'comment'    => 'TEXT DEFAULT NULL',
                    'PRIMARY KEY (id)',
                ),
                'ENGINE=MYISAM CHARSET=utf8'
            );
            $db->createCommand()->update('user', array('balance'=>0));
        }
    } 
        
    /***
    * DB-operations during module removing
    * 
    */
    public function afterRemove()
    {
        $db = Yii::app()->db;
        //add new columns in table user
        if ($this->checkColumnExist('user', 'role'))
            $db->createCommand()->dropColumn('user', 'role');
        if ($this->checkColumnExist('user', 'role'))
            $db->createCommand()->dropColumn('user', 'balance');
        //new table for operations (transactions)
        if ($this->checkTableExist('operation'))
            $db->createCommand()->dropTable('operation');
    }
 
    //проверка: существует ли таблица
    // - если да - вернёт объект таблицы, нет - null
    private function checkTableExist($tableName) {
        $db = Yii::app()->db; 
        //DebugBreak();
        return ($table = $db->schema->getTable($tableName)) ? $table : null;
    }
    
    //проверка: существует ли таблица
    // - если да - вернёт объект таблицы, нет - null
    private function checkColumnExist($tableName, $columnName) {
        $column = ($table = $this->checkTableExist($tableName)) ? $table->getColumn($columnName) : null;
        return $column;
    }
}