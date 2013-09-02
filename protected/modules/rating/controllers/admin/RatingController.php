<?php

/**
 * Admin site comments
 */
class RatingController extends SAdminController
{

	/**
	 * Display all site comments
	 */
	public function actionIndex()
	{
		$model = new Rating('searchProduct');

		if(!empty($_GET['Rating']))
			$model->attributes = $_GET['Rating'];

		$dataProvider = $model->searchProduct();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider
		));
	}

	public function actionUpdateStatus()
	{
		$ids    = Yii::app()->request->getPost('ids');
		$status = Yii::app()->request->getPost('status');
		$models = Comment::model()->findAllByPk($ids);

		if(!array_key_exists($status, Comment::getStatuses()))
			throw new CHttpException(404, Yii::t('CommentsModule.admin', 'Ошибка проверки статуса.'));

		if(!empty($models))
		{
			foreach ($models as $comment)
			{
				$comment->status = $status;
				$comment->save();
			}
		}

		echo Yii::t('CommentsModule', 'Статус успешно изменен');
	}

	/**
	 * Delete comments
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = Comment::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $m)
					$m->delete();
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}
