<?php

/**
 * @var $this SSystemMenu
 */

Yii::import('rating.RatingModule');

/**
 * Admin menu items for pages module
 */
return array(
	array(
		'label'    => Yii::t('RatingModule.core', 'Рейтинг'),
		'url'      => array('/rating/admin/index'),
		'position' => 4,
		'itemOptions' => array(
			'class'       => 'hasRedCircle circle-comments',
		),
	),
);