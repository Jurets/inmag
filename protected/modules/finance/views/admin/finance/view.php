<?php

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'form'=>$form,
        'template'=>array('history_back','save'),
        'listAction'=>'operationView',
	));
    
    $title = $model->role == UserFinance::ROLE_WORKER ? 
                ($operation == 1 ? Yii::t('FinanceModule.core', 'Пополнение счета исполнителя') : Yii::t('FinanceModule.core', 'Вывод средств исполнителя')):
                ($operation == 1 ? Yii::t('FinanceModule.core', 'Пополнение счета заказчика') : Yii::t('FinanceModule.core', 'Списание со счета заказчика'));
	

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('FinanceModule.core', 'Операции')=>$this->createUrl('index'),
		$title
	);

	$this->pageHeader = $title;
?>

<div class="form wide padding-all">
	<?php echo $form; ?>
</div>

