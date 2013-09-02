<?php

/**
 * Routes for comments module
 */
return array(
	'/admin/rating'=>'/rating/admin/rating',
	'/admin/rating/<action>'=>'/rating/admin/rating/<action>',
    'rating/ajax/rateProduct/<id>'=>array('rating/ajax/rateProduct'),
);