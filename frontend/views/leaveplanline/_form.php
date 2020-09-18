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
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php




                    $form = ActiveForm::begin(); ?>
                <div class="row">




                            <table class="table">
                                <tbody>




                                    <?= $form->field($model, 'Line_No')->hiddenInput(['hidden' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_Code')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Leave_Code')->hiddenInput(['readonly' => true])->label(false) ?>
                            <div class="col-md-6">
                                    <?= $form->field($model, 'Plan_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date']) ?>

                                    <?= $form->field($model, 'End_Date')->textInput(['type' => 'date']) ?>
                            </div>

                            <div class="col-md-6">
                                    <?= $form->field($model, 'Days_Planned')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Holidays')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Weekend_Days')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Total_No_Of_Days')->textInput(['readonly' => true]) ?>
                            </div>


                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>











                                </tbody>
                            </table>








                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id'=>'submit']) ?>
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
 //Submit Rejection form and get results in json    
        $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });

         $('#leaveplanline-start_date').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#leaveplanline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'leaveplanline/setstartdate';
            $.post(url,{'Line_No': Line_No,'Start_Date': $(this).val()}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leaveplanline-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaveplanline-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#leaveplanline-days_planned').val(msg.Days_Planned);
                    $('#leaveplanline-holidays').val(msg.Holidays);
                    $('#leaveplanline-weekend_days').val(msg.Weekend_Days);
                    $('#leaveplanline-total_no_of_days').val(msg.Total_No_Of_Days);
                    
                },'json');
        });
         
         $('#leaveplanline-end_date').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#leaveplanline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'leaveplanline/setenddate';
            $.post(url,{'Line_No': Line_No,'End_Date': $(this).val()}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-leaveplanline-end_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaveplanline-end_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#leaveplanline-days_planned').val(msg.Days_Planned);
                    // $('#leaveplanline-start_date').val(msg.Start_Date);
                    $('#leaveplanline-holidays').val(msg.Holidays);
                    $('#leaveplanline-weekend_days').val(msg.Weekend_Days);
                    $('#leaveplanline-total_no_of_days').val(msg.Total_No_Of_Days);
                    
                },'json');
        });
         
         function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
JS;

$this->registerJs($script);
