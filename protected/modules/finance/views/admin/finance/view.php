<?php
	// User create/edit view

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'form'=>$form,
        'template'=>array('history_back','save'),
        'listAction'=>'operationView',
//		'deleteAction'=>$this->createUrl('/users/admin/default/delete', array('id'=>$model->id))
	));
    
    /*if ($model->role == UserFinance::ROLE_WORKER &&  
                ($operation == UserFinance::OPERATION_DEPOSIT ? Yii::t('FinanceModule.core', 'Пополнение счета исполнителя') : Yii::t('FinanceModule.core', 'Вывод денег со счета исполнителя')):
                ($operation == 2 ? Yii::t('FinanceModule.core', 'Пополнение счета заказчика') : Yii::t('FinanceModule.core', 'Списание со счета заказчика'));*/
    $operation = $form['operation']->model;
    $title = $operation->operationName;
	
	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('FinanceModule.core', 'Операции')=>$this->createUrl('index'),
		$title
	);

	$this->pageHeader = $title;
//	$this->sidebarContent = $this->renderPartial('_sidebar', array(
//		'model'=>$model,
//	), true);
?>

<div class="form wide padding-all">
	<?php echo $form; ?>
</div>

