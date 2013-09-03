<? 
    $this->pageTitle=Yii::t('FinanceModule.core', 'Статистика');
?>

    <h1 class="has_background"><?php echo Yii::t('FinanceModule.core', 'Статистика'); ?></h1>
    
<?php

    $this->renderPartial('application.modules.finance.views.admin.finance.statistics', array(
        'model'=>$model,
        'dataProvider'=>$dataProvider
    ));
?>
