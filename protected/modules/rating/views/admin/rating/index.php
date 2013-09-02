<?php

/**
 * Display comments list
 *
 * @var $model Comment
 **/

//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/rating.index.js');

$this->pageHeader = Yii::t('RatingModule.core', 'Комментарии');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('RatingModule.core', 'Комментарии'),
);

$formatter = New CFormatter;

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider' => $dataProvider,
	'id'           => 'ratingListGrid',
	'filter'       => $model,
    'ajaxUpdate'    => true,
	'columns' => array(
		array(
			'class'=>'CCheckBoxColumn',
		),
		array(
			'class'=>'SGridIdColumn',
			'name'=>'product_id',
            'header'=>'ID',
		),
        array(
            'name'  => 'name',
            //'header' => 'Product',
            'type'  => 'raw',
            'value' => 'Chtml::encode($data->product->name)',
            //'filter' => CHtml::listData(StoreProduct::model()->findAll(array('order'=>'name')),'id', 'name'),
        ),
        array(
            'name'  => 'sumparam1',
            'type'  => 'raw',
            'filter' => false,
        ),
        array(
            'name'  => 'sumparam2',
            'type'  => 'raw',
            'filter' => false,
        ),
        array(
            'name'  => 'sumparam3',
            'type'  => 'raw',
            'filter' => false,
        ),
        array(
            'name'  => 'sum_params',
            'type'  => 'raw',
            'value' => '$data->sum_params',                                               
            'filter' => false,
        ),
        array(
			'name'  => 'avg_params',
			'type'  => 'raw',
			'value' => 'number_format(round($data->avg_params, 2, PHP_ROUND_HALF_UP), 2, ".", " ")',
            'filter' => false,
		),
	),
));
