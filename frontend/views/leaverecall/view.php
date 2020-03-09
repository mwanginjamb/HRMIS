<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Leave Application : <?= $model->Application_No?></h3>



                <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                                    echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }
                ?>
            </div>
            <div class="card-body">


               <?php $form = ActiveForm::begin(['action'=> ['leave/create']]); ?>


               <div class="row">
                   <div class=" row col-md-12">
                       <div class="col-md-6">

                           <?= $form->field($model, 'Recall_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <?= "<p><b>Employee Name </b>: ". Html::a(" $model->Employee_Name ",'')."</p>"; ?>
                           <?= $form->field($model, 'Leave_No_To_Recall')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Application_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'User_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= "<p><b>Leave Code </b>: ". Html::a(" $model->Leave_Code ",'')."</p>"; ?>
                           <?= $form->field($model, 'Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Days_Applied')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Days_To_Recall')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                       </div>
                       <div class="col-md-6">
                           <?= $form->field($model, 'Leave_balance')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Total_No_Of_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Holidays')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Weekend_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Balance_After')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Leave_Status')->hiddenInput(['readonly'=> true, 'disabled'=>true])->label(false) ?>
                           <?= $form->field($model, 'Comments')->textarea(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Supervisor_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= "<p><b>Reliver </b>: ". Html::a(" $model->Reliever ",'')."</p>"; ?>
                           <?= $form->field($model, 'Reporting_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Reliever_Name')->textInput() ?>
                           <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                       </div>
                   </div>
               </div>



               <?php ActiveForm::end(); ?>



            </div>
        </div>
    </div>
</div>
