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
        if (!$this->checkColumnExist('user', 'role'))
            $db->createCommand()->addColumn('user', 'role', 'TINYINT(1) UNSIGNED NOT NULL');
        if (!$this->checkColumnExist('user', 'balance'))
            $db->createCommand()->addColumn('user', 'balance', 'FLOAT(10, 2)');

      //new table for operations (transactions)
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
            
            //add system user account;
            if (!User::model()->exists('id = :id', array(':id'=>UserFinance::SYSTEM_ID))) {
                $db->createCommand('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"')->execute();
                $now = new CDbExpression('NOW()');
                $db->createCommand()->insert('user', array(
                    'id'=>UserFinance::SYSTEM_ID,
                    'username'=>'system',
                    'password'=>'',
                    'email'=>'',
                    'password'=>'',
                    'created_at'=>$now,
                    'last_login'=>$now,
                    'login_ip'=>'',
                    'recovery_key'=>'',
                    'recovery_password'=>'',
                    'login_ip'=>'',
                    //'role'=>0,
                ));
                $db->createCommand('SET SQL_MODE = ""')->execute();
            }
            //set all balances to 0;
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
        if ($this->checkColumnExist('user', 'role')) {
            throw New Exception(Yii::t('UsersModule.core', 'Колонка role таблицы user не удалена! Удалите её вручную'));
            //$db->createCommand()->dropColumn('user', 'role');
        }
        if ($this->checkColumnExist('user', 'balance')) {
            throw New Exception(Yii::t('UsersModule.core', 'Колонка balance таблицы user не удалена! Удалите её вручную'));
            //$db->createCommand()->dropColumn('user', 'balance');
        }
        //new table for operations (transactions)
        if ($this->checkTableExist('operation')) {
            throw New Exception(Yii::t('UsersModule.core', 'Таблица operation не удалена! Удалите её вручную'));
            //$db->createCommand()->dropTable('operation');
        }
    }
 
    //проверка: существует ли таблица
    // - если да - вернёт объект таблицы, нет - null
    private function checkTableExist($tableName) {
        $db = Yii::app()->db; 
        return ($table = $db->schema->getTable($tableName)) ? $table : null;
    }
    
    //проверка: существует ли таблица
    // - если да - вернёт объект таблицы, нет - null
    private function checkColumnExist($tableName, $columnName) {
        $column = ($table = $this->checkTableExist($tableName)) ? $table->getColumn($columnName) : null;
        return $column;
    }
}