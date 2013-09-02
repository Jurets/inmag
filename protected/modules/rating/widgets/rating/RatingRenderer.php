<?php

class RatingRenderer extends CWidget
{
    public $id;
    
	public function run()
	{
        Yii::import('application.modules.rating.models.Rating');
        $avg = Rating::getAverageRating($this->id);
        $rating = Rating::getRating($this->id);
        $this->render('index', array(
            'id' => $this->id,     
            'rating' => $rating,
            'avg' => round($avg, 2),
        ));
	}
}
