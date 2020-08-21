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
        <div class="card card-primary">
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

                            <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','min'=> date('Y-m-d')]) ?>

                            <?= $form->field($model, 'Total_No_Of_Days')->textInput(['type' => 'number']) ?>




                            <?= $form->field($model, 'End_Date')->textInput(['type' => 'date','readonly'=> true,'disabled'=>true]) ?>

                            <?= $form->field($model, 'Days_Applied')->textInput(['readonly'=> true, 'min' => 1]) ?>

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
                        <?= Html::submitButton('Apply', ['class' => 'btn btn-success','id'=>'submit']) ?>
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
        var url = $('input[name=absolute]').val();

        // Commit on Leave type selection
        
                
         $('select#leave-leave_code').on('change', function(e){
            e.preventDefault();
            console.log('Leave type selected..');
            const Leave_Code = $(this).find(":selected").val();
            const Leave_Application_No = $('#leave-application_no').val();
            const Leave_Key = $('#leave-key').val();
            
            const url = $('input[name="absolute"]').val()+'leave/setleavecode';
            $.post(url,{'Total_No_Of_Days': $(this).val(),'Leave_Code': Leave_Code,'Application_No': Leave_Application_No,'Key':Leave_Key }).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-leave_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;  
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-leave_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#leave-end_date').val(msg.End_Date);
                    $('#leave-reporting_date').val(msg.Reporting_Date);
                    $('#leave-days_applied').val(msg.Days_Applied);
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-balance_after').val(msg.Balance_After);
                },'json');
        });


        
        // Commit on Total no of days update
        $('#leave-total_no_of_days').on('change', function(e){
            e.preventDefault();
            console.log('Applying for leave..');
            const Leave_Code = $('#leave-leave_code').val();
            const Leave_Application_No = $('#leave-application_no').val();
            const Leave_Key = $('#leave-key').val();
            const Start_Date = $('#leave-start_date').val();
            const url = $('input[name="absolute"]').val()+'leave/setdays';
            $.post(url,{'Total_No_Of_Days': $(this).val(),'Leave_Code': Leave_Code,'Application_No': Leave_Application_No,'Key':Leave_Key,'Start_Date': Start_Date }).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-total_no_of_days');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg; 
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-total_no_of_days');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#leave-end_date').val(msg.End_Date);
                    $('#leave-reporting_date').val(msg.Reporting_Date);
                    $('#leave-days_applied').val(msg.Days_Applied);
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-balance_after').val(msg.Balance_After);
                },'json');
        });
        
        // Commit Leave Start Date
        
        $('#leave-start_date').on('change', function(e){
            e.preventDefault();
            console.log('Commit Start date');          
            const Leave_Application_No = $('#leave-application_no').val();
            const days = $('#leave-total_no_of_days').val();
            
            const url = $('input[name="absolute"]').val()+'leave/setstartdate';
            $.post(url,{'Application_No': Leave_Application_No,'Start_Date': $(this).val(), 'Total_No_Of_Days': +days}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#leave-end_date').val(msg.End_Date);
                    $('#leave-reporting_date').val(msg.Reporting_Date);
                    $('#leave-days_applied').val(msg.Days_Applied);
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-balance_after').val(msg.Balance_After);
                },'json');
        });


          // Commit on Reliever Update
         $("select#leave-reliever").on('change', function(){
           var ApplicationNo = $('#leave-application_no').val();
           var reliever = $(this).find(":selected").val();        
           
           console.log('Updating reliever');
           console.log(url+'leave/update/?ApplicationNo='+ApplicationNo+'&reliever='+reliever);
           window.location.href =url+'leave/update/?ApplicationNo='+ApplicationNo+'&reliever='+reliever;
        });
         
        function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }

JS;

$this->registerJs($script);
