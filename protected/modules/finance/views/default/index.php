<? 
    $this->pageTitle=Yii::t('FinanceModule.core', 'Статистика');
?>

    <h1 class="has_background"><?php echo Yii::t('FinanceModule.core', 'Статистика'); ?></h1>
    
<?php
    
    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$dataProvider,
        'id'=>'operationsListGrid',
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns'=>array(
            array(
                'class'=>'SGridIdColumn',
                'name'=>'id',
                'filter'=>false,
            ),
            array(
                'name'=>'created',
                'filter'=>false,
            ),
            array(
                'name'=>'type',
                'type'=>'raw',
                'filter'=>false,
                //'value'=>'Operation::getOperationName($data->role, $data->type)',
                'value'=>'$data->operationName',
                //'filter'=>Operation::getRoleNames()
            ),
            array(
                'name'=>'amount',
                'type'=>'raw',
                'filter'=>false,
//                'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
            ),
        ),
    ));

    
?>
