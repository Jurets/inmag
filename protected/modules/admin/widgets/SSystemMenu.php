<?php

/**
 * Renders admin top menu
 */
class SSystemMenu extends CWidget {

	private $_items;

	/**
	 * Set default items
	 */
	public function init()
	{
		// Minimum configuration
		$this->_items = array(
			'users'=>array(
				'label'=>Yii::t('AdminModule.admin', 'Система'),
				'position'=>1,
			),
			'catalog'=>array(
				'label'=>Yii::t('AdminModule.admin', 'Каталог'),
				'position'=>3,
			),
			'cms'=>array(
				'label'=>Yii::t('AdminModule.admin', 'Сайт'),
				'position'=>4,
			),
		);
	}

	/**
	 * Render menu
	 */
	public function run()
	{
		$found = $this->findMenuFiles();
		$items = CMap::mergeArray($this->_items, $found);
        $items = $this->checkPermission($items);         //ДОБАВЛЕНАЯ СТРОКА
		$this->processSorting($items);
		$this->widget('application.extensions.mbmenu.MbMenu', array('items'=>$items));
	}

	/**
	 * Sort menu items by position key.
	 * @param $items array menu items
	 */
	protected function processSorting(&$items)
	{
		uasort($items, "SSystemMenu::sortByPosition");
		foreach ($items as $key => $item)
		{
			if (isset($item['items']))
				$this->processSorting($items[$key]['items']);
		}
	}

	/**
	 * Find and load module menu files.
	 */
	protected function findMenuFiles()
	{
		$result = array();

		$installedModules = SystemModules::model()->findAll(array(
			'select'=>'name',
		));

		foreach($installedModules as $module)
		{
			$filePath = Yii::getPathOfAlias('application.modules.'.$module->name.'.config').DIRECTORY_SEPARATOR.'menu.php';
			if (file_exists($filePath))
				$result = CMap::mergeArray($result, require($filePath));
		}

		return $result;
	}

	/**
	 *  Sort an array
	 * @static
	 * @param  $a array
	 * @param  $b array
	 * @return int
	 */
	public static function sortByPosition($a, $b)
	{
		if (isset($a['position']) && isset($b['position']))
		{
			if ((int)$a['position'] === (int)$b['position'])
				return 0;
			return ((int)$a['position'] > (int)$b['position']) ? 1 : -1;
		}

		return 1;
	}
    //проверяет массив меню на недоступные данному юзеру пункты и удаляет их из меню
    public function checkPermission($items)
    {
        
        //проверка горизонтального меню
        foreach($items as $key => &$val)
        {
            $isAvailible = true;
                
                if(isset($val['url']) && is_string($val['url'])){
                    $isAvailible = $this->checkAccess($val['url']);
                }elseif(isset($val['url'][0]) && is_string($val['url'][0])){
                    $isAvailible = $this->checkAccess($val['url'][0]);
                }
                if(!$isAvailible)
                    unset($items[$key]['url']);

                
                if(isset($val['items']) && is_array($val['items']))
                {
                    foreach($val['items'] as $i => &$desc)
                    {
                        if(isset($desc['url']) && is_string($desc['url'])){
                            $isAvailible = $this->checkAccess($desc['url']);
                        }elseif(isset($desc['url'][0]) && is_string($desc['url'][0])){
                            $isAvailible = $this->checkAccess($desc['url'][0]);
                        }
                        if(!$isAvailible)
                            unset($items[$key]['items'][$i]);
                    }
                    if(!isset($items[$key]['url']) && empty($items[$key]['items']))
                        unset($items[$key]);
                }
                if(!isset($items[$key]['url']) && !isset($items[$key]['items']) && empty($items[$key]['items']))
                    unset($items[$key]);
        }
        return $items;
    }
    //проверка прав доступа юзера 
    protected function checkAccess($url)
    {
        $url = ucfirst(str_replace('admin/', '',  $url));
        if($url[0] === '/') $url = substr($url, 1);
        if($url[strlen($url) - 1] === '/') $url = substr($url, 0, -1);
        $arr = explode('/', $url);
        switch(count($arr)){
            case 1:
                $arr[] = 'Default';
            case 2:
                if(Yii::app()->user->checkAccess(implode('.', $arr))) return true;
                if(Yii::app()->user->checkAccess(implode('.', $arr).'.*')) return true;
                if(strnatcasecmp($arr[1], 'index'))
                    $arr[] = 'Index';
                break;
            case 3:
                $taskArr[] = $arr[0];
                $taskArr[] = $arr[1];
                $taskArr[] = '*';
                if(Yii::app()->user->checkAccess(implode('.', $taskArr))) return true;
            default:
                break;
        }
        $alias = implode('.', $arr);
        
        return Yii::app()->user->checkAccess($alias);
    }
}