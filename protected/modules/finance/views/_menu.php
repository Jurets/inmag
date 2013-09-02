<h3><?php echo Yii::t('FinanceModule.core', 'Меню') ?></h3>
<hr/>
<?php
    $this->widget('zii.widgets.CMenu', array(
        'activeCssClass'=>'active',
		'items'=>array(
			array(
				'label'=>Yii::t('FinanceModule.core', 'Пополнение счета заказчика'),
				'url'=>array('assignment/view'),
				'itemOptions'=>array('class'=>'item-assignments'),
			),
			array(
				'label'=>Yii::t('FinanceModule.core', 'Пополнение счета исполнителя'),
				'url'=>array('authItem/permissions'),
				'itemOptions'=>array('class'=>'item-permissions'),
			),
			array(
				'label'=>Yii::t('FinanceModule.core', 'Списание со счета заказчика'),
				'url'=>array('authItem/roles'),
				'itemOptions'=>array('class'=>'item-roles'),
			),
			array(
				'label'=>Yii::t('FinanceModule.core', 'Вывод средств исполнителя'),
				'url'=>array('authItem/tasks'),
				'itemOptions'=>array('class'=>'item-tasks'),
			),
		)
    ));

    if(isset($this->clips['sidebarHelpText']))
    {
        echo '<div class="hint" style="margin-top:25px;padding-right:5px;">'.$this->clips['sidebarHelpText'].'</div>'; 
    }
