<?php

$themes=Yii::app()->themeManager->themeNames;
$themes=array_combine($themes, $themes);

function titleRow($title)
{
    return '
    <div class="row">
        <label>&nbsp;</label>
        <h3>'.$title.'</h3>
    </div>
    ';
}

return array(
    'id'=>'userFinanceForm',
    'showErrorSummary'=>true,
    'enctype'=>'multipart/form-data',
    'elements'=>array(
        'main'=>array(),
        'tab2'=>array(),
    )
);