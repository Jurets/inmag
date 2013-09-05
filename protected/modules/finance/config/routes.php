<?php

/**
 * Routes for comments module
 */
return array(
    '/admin/finance'=>'/finance/admin/finance',
	'/admin/finance/<action>'=>'/finance/admin/finance/<action>',
    '/users/finance'=>array('finance/default/index'),
);