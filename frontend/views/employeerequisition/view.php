<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'HRMIS - Employee Requisition Card';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"> Employee Requisition Card</h3>
            </div>
            <div class="card-body">
                <?php
                $form = ActiveForm::begin(['action'=> ['employeerequisition/create']]); ?>
                <div class="row">
                    <div class="col-md-6">


                        <?= $form->field($model, 'Requisition_No')->textInput(['readonly'=> 'true','disabled'=>true]) ?>

                        <?= $form->field($model, 'Requisition_Date')->textInput(['readonly'=> 'true','disabled'=>true]) ?>

                        <?= $form->field($model, 'Requestor')->textInput(['readonly'=> 'true','disabled'=>true]) ?>


                        <?= $form->field($model, 'Job_ID')->dropDownList($jobs, ['prompt' => 'Select Job','readonly'=> 'true','disabled'=>true]) ?>

                        <?= $form->field($model, 'Job_Description')->textInput(['readonly'=> 'true','disabled'=>true]) ?>

                        <?= $form->field($model, 'Job_Grade')->textInput(['readonly'=> 'true','disabled'=>true]) ?>

                        <?= $form->field($model, 'Reason_For_Request')->dropDownList($requestReasons,['prompt' => 'Select Requisition Type','readonly'=> 'true','disabled'=>true]) ?>






                    </div>
                    <div class=" col-md-6">

                        <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false); ?>
                        <?= $form->field($model, 'Employment_Type')->dropDownList($employmentTypes, ['prompt' => 'Select Employment Type','readonly'=> 'true','disabled'=>true]) ?>
                        <?= $form->field($model, 'Priority')->dropDownList($priority, ['prompt' => 'Select Requisition Priority','readonly'=> 'true','disabled'=>true]) ?>
                        <?= $form->field($model, 'Required_Positions')->textInput(['type' => 'number','readonly'=> 'true','disabled'=>true]) ?>
                        <?= $form->field($model, 'Requisition_Type')->dropDownList($requisitionType, ['prompt' => 'Select Requisition Type','readonly'=> 'true','disabled'=>true]) ?>
                        <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Completion_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                    </div>



                </div>


            </div>
        </div>
    </div>
</div>
<div class="row ">

    <div class="col-md-12">
        <div class="card card-blue">

            <div class="card-header">
                <h3 class="card-title">Additional Information</h3>
            </div>

            <div class="card-body">


                <div class="row">


                    <div class="col-md-6">
                        <?= $form->field($model, 'Any_Additional_Information')->textarea(['max-length'=> '250', 'rows'=> 4,'readonly'=> 'true','disabled'=>true]) ?>
                    </div>




                    <div class="col-md-6">
                        <?= $form->field($model, 'Reason_for_Request_Other')->textarea(['max-length'=> '250', 'rows'=> 4,'readonly'=> 'true','disabled'=>true]) ?>
                    </div>

                </div>






            </div>

        </div>
    </div>





</div>

<div class="row">

    <div class="form-group">
        <?php Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>