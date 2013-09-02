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
    
    public function afterInstall()
    {
        $db = Yii::app()->db;
        $db->createCommand()->addColumn('user', 'role', 'TINYINT(1)');
        $db->createCommand()->addColumn('user', 'balance', 'float(10,2)');
    } 
        
}