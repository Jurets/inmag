<?php
Yii::import('application.modules.finance.models.Operation');
/**
 * Handle ajax requests
 */
class AjaxController extends Controller
{
    
    public function actionFinanceCheck()
    {//DebugBreak();
        $request = Yii::app()->request;
        if($request->isAjaxRequest)
        {
            $error = false;
            $messageArr = array();
            $userId = Yii::app()->user->id;
            $operation = Operation::getNewOperations($userId);
            if(!empty($operation)){
                $model = new Operation();
                foreach($operation as $val){
                    switch($val['type']){
                        case UserFinance::OPERATION_DEPOSIT:
                            $message = Yii::t('FinanceModule', 'Деньги поступили на счет.');
                            break;
                        case UserFinance::OPERATION_WITHDRAW:
                            $message = Yii::t('FinanceModule', 'Деньги выведены со счета.');
                            break;
                        default:
                            break;
                    }
                    $messageArr[] = $message.'<br>'.$val['amount'].' руб.<br>'.CHtml::link(Yii::t('FinanceModule', 'Посмотреть все операции'), array('/users/finance'));
                    Yii::app()->db->createCommand('UPDATE  operation SET is_msg_shown = 1 WHERE id = :id')->execute(array('id'=>$val['id']));
                }
            }else{
                $error = true;
            }
            
            
            echo CJSON::encode(array(
                'errors'=>$error,
                'message'=>$messageArr,
            ));
            exit;
        }
    }

}