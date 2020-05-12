<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">New Leave Application</h3>
            </div>
            <div class="card-body">



                    <?php




                    $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-6">

                            <?= $form->field($model, 'Application_No')->textInput(['readonly'=> true]) ?>

                            <?= $form->field($model, 'Application_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'User_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Leave_Code')->dropDownList($leaveTypes,['prompt' => 'Select Leave Type']) ?>

                            <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date']) ?>

                            <?= $form->field($model, 'Total_No_Of_Days')->textInput(['type' => 'number']) ?>




                            <?= $form->field($model, 'End_Date')->textInput(['type' => 'date','readonly'=> true,'disabled'=>true]) ?>

                            <?= $form->field($model, 'Days_Applied')->textInput(['readonly'=> true]) ?>

                            <?= $form->field($model, 'Reliever')->dropDownList($relievers,['prompt' => 'Select Reliever']) ?>




                    </div>
                    <div class="col-md-6">

                        <div class="row">

                        <div class="col-md-6">



                            <?= $form->field($model, 'Leave_balance')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Reporting_Date')->textInput(['type' => 'date','readonly'=> true, 'disabled'=>true]) ?>



                        </div>

                        <div class="col-md-6">

                            <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false); ?>
                            <?= $form->field($model, 'Balance_After')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Leave_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Comments')->textInput(['max-length' => 250]) ?>
                            <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        </div>

                        </div>

                    </div>



                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Apply', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
 //Submit Rejection form and get results in json leave-total_no_of_days    
        $('#leave-total_no_of_days').on('change', function(e){
            e.preventDefault()
            const Leave_Code = $('#leave-leave_code').val();
            const Leave_Application_No = $('#leave-application_no').val();
            const Leave_Key = $('#leave-key').val();
            const Start_Date = $('#leave-start_date').val();
            const url = $('input[name="absolute"]').val()+'leave/setdays';
            $.post(url,{'Total_No_Of_Days': $(this).val(),'Leave_Code': Leave_Code,'Application_No': Leave_Application_No,'Key':Leave_Key,'Start_Date': Start_Date }).done(function(msg){
                   //populate empty form fields with new data
                    console.table(msg);
                    $('#leave-end_date').val(msg.End_Date);
                    $('#leave-reporting_date').val(msg.Reporting_Date);
                    $('#leave-days_applied').val(msg.Days_Applied);
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-balance_after').val(msg.Balance_After);
                },'json');
        });
JS;

$this->registerJs($script);
