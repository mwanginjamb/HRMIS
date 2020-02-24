<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">New Leave Application</h3>
            </div>
            <div class="card-body">



                    <?php




                    $form = ActiveForm::begin(['action'=> ['leave/create']]); ?>
                <div class="row">
                    <div class="col-md-6">


                            <?= $form->field($model, 'Leave_Code')->dropDownList($leaveTypes,['prompt' => 'Select Leave Type']) ?>

                            <?= $form->field($model, 'Days_Applied')->textInput(['type' => 'number','readonly'=> 'true','disabled'=>true]) ?>

                            <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date']) ?>


                            <?= $form->field($model, 'End_Date')->textInput(['type' => 'date']) ?>

                            <?= $form->field($model, 'Reliever')->dropDownList($relievers,['prompt' => 'Select Reliever']) ?>




                    </div>
                    <div class="col-md-6">

                        <div class="row">

                        <div class="col-md-6">

                            <?= $form->field($model, 'Application_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Leave_balance')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Reporting_Date')->textInput(['type' => 'date','readonly'=> true, 'disabled'=>true]) ?>



                        </div>

                        <div class="col-md-6">

                            <?= $form->field($model, 'Key')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Balance_After')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Leave_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        </div>

                        </div>

                    </div>



                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
