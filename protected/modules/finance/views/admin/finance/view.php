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
    
/*    $title =    $model->role == 3 ? ($operation->type == 1 ? Yii::t('FinanceModule.core', 'Пополнить из системы') : Yii::t('FinanceModule.core', 'Снятие со счета исполнителя')) :
                                    ($operation->type == 1 ? Yii::t('FinanceModule.core', 'Пополнение счета заказчика') : Yii::t('FinanceModule.core', 'Списать в систему'));*/
	
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

