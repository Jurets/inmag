<?php
	// User create/edit view

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'form'=>$form,
        'template'=>array('history_back','save'),
        'listAction'=>'operationView',
//		'deleteAction'=>$this->createUrl('/users/admin/default/delete', array('id'=>$model->id))
	));
    
    $operation = $form['operation']->model;
    $title = $operation->operationName;
    
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

