<div>
    <br>
    <h3 style="text-align: center;"><?=$avg?></h3>
    <?
         if(!Yii::app()->user->isGuest){
             if(is_object($rating)){
                 $param1 = $rating->param1;
                 $param2 = $rating->param2;
                 $param3 = $rating->param3;
             }else{
                 $param1 =0;
                 $param2 =0;
                 $param3 =0;
             }
     ?>
    <div class="stars">
        <?php $this->widget('CStarRating',array(
            'name'=>'rating_param1',
            'id'=>'rating_param1',
            'allowEmpty'=>false,
            'readOnly'=>false,
            'minRating'=>1,
            'maxRating'=>5,
            'value'=>$param1,
            'callback'=>'js:function(){
                    var url = "/rating/ajax/rateProduct/'.$id.'";
                    var rating = $("input[name=rating_param1]:checked").val();
                    $("input[name=rating_param1]").rating("disable");
                    $.ajax({
                        url: url,
                        data:{param1:rating}
                    });
            }',
    )); ?>
    </div>
    <br>
    <div class="stars">
        <?php $this->widget('CStarRating',array(
            'name'=>'rating_param2',
            'id'=>'rating_param2',
            'allowEmpty'=>false,
            'readOnly'=>false,
            'minRating'=>1,
            'maxRating'=>5,
            'value'=>$param2,
            'callback'=>'js:function(){
                    var url = "/rating/ajax/rateProduct/'.$id.'";
                    var rating = $("input[name=rating_param2]:checked").val();
                    $("input[name=rating_param2]").rating("disable");
                    $.ajax({
                        url: url,
                        data:{param2:rating}
                    });
            }',
    )); ?>
    </div>
    <br>
    <div class="stars">
        <?php $this->widget('CStarRating',array(
            'name'=>'rating_param3',
            'id'=>'rating_param3',
            'allowEmpty'=>false,
            'readOnly'=>false,
            'minRating'=>1,
            'maxRating'=>5,
            'value'=>$param3,
            'callback'=>'js:function(){
                    var url = "/rating/ajax/rateProduct/'.$id.'";
                    var rating = $("input[name=rating_param3]:checked").val();
                    $("input[name=rating_param3]").rating("disable");
                    $.ajax({
                        url: url,
                        data:{param3:rating}
                    });
            }',
    )); ?>
    </div>
    <br>


    <?
         }
     ?>
</div>