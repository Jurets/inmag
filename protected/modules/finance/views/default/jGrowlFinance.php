<?php
//скрипт для проверки поступления/снятия денег со счета юзера и вывода уведомления
$script = "
    setInterval(function(){
        financeCheck();
    }, 30000);

    function financeCheck()
    {
        $.getJSON('/finance/ajax/financeCheck' , function(data){
            if(data.errors === false){
                for(var i in data.message){
                    $.jGrowl(data.message[i], {position:\"bottom-right\", life: 10000, corners: '0px', theme:'greentheme2', header:'<b>Новое уведомление</b>'});
                }
            }
        });
    }
";
Yii::app()->clientScript->registerScript('finance-check', $script, CClientScript::POS_READY);
$css = <<<BLOCK
.mytheme1{
    background: none repeat scroll 0 0 #FFDDDD !important;
    border: 1px solid #FFBBBB !important;
    font-size: 1em !important;
    margin: 0 0 20px !important;
    padding: 7px 7px 12px !important;
}
.mytheme1 div{
    color: red;
    font-size: 1em !important;
}
.mytheme2{
    background: none repeat scroll 0 0 #FFDDDD !important;
    border: 1px solid #FFBBBB !important;
    font-size: 1.2em !important;
    margin: 0 0 20px !important;
    padding: 7px 7px 12px !important;
    width: 300px !important;
}
.mytheme2 div{
    color: red;
    font-size: 1.2em !important;
}
.mytheme3{
    background: none repeat scroll 0 0 #FEE4BD !important;
    border: 1px solid #F8893F !important;
    font-size: 1em !important;
    margin: 0 0 20px !important;
    padding: 7px 7px 12px !important;
}
.mytheme3 div{
    color: #592003;
    font-size: 1em !important;
}
.mytheme4{
    background: none repeat scroll 0 0 #FBEC88 !important;
    border: 1px solid #FAD42E !important;
    font-size: 1em !important;
    margin: 0 0 20px !important;
    padding: 7px 7px 12px !important;
}
.mytheme4 div{
    color: #363636;
    font-size: 1em !important;
}
.greentheme1{
    background: none repeat scroll 0 0 #b2c34f !important;
    background-image: linear-gradient(to bottom, #c3d05f, #98af37)
    border: 1px solid #FAD42E !important;
    font-size: 1em !important;
    margin: 0 0 20px !important;
    padding: 7px 7px 12px !important;
}
.greentheme1 div{
    color: #ffffff;
    font-size: 1em !important;
}
.greentheme2{
    background: none repeat scroll 0 0 #ecf2ce !important;
    border: 1px solid #98af37 !important;
    font-size: 1em !important;
    margin: 0 0 20px !important;
    padding: 7px 7px 12px !important;
}
.greentheme2 div{
    color: #7a9029;
    font-size: 1em !important;
}   
BLOCK;
Yii::app()->clientScript->registerCss('jgrowl-notifications',$css);
?>