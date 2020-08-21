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
                <h3 class="card-title"><?= $this->title ?></h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
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
                </div>

                    <?php




                    $form = ActiveForm::begin(['action'=> ['leaverecall/create']]); ?>
                <div class="row">


                    <div class="col-md-6">

                            <?=
                            $form->field($model, 'Employee_No')->textInput(['readonly' => true])
                            ?>
                            <?= $form->field($model, 'Recall_No')->textInput(['readonly'=> 'true']) ?>

                            <?= ($model->Employee_No)?$form->field($model, 'Leave_No_To_Recall')->dropDownList($leaves,[
                                    'prompt' => 'Select Leave to Recall',
                                    'onchange' => '
                                                $.get("input[name=absolute]").val()+"leaverecall/create",{"Leave_No_To_Recall": $(this).find(":selected").val(), "Key": $("#leaverecall-key").val() },function(data){                                                
                                                }).done(function(msg){
                                                    location.reload();
                                                },"json");                                        
                                                '
                                    ,
                            ]): '' ?>

                            <?= $form->field($model, 'Days_To_Recall')->textInput(['type' => 'number','required' => true]) ?>










                            <?= $form->field($model, 'Comments')->textarea(['rows'=> 3, 'max-length'=>'250']) ?>
                            <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false); ?>




                    </div>
                    <div class="col-md-6">

                        <div class="row">

                        <div class="col-md-6">

                            <?= $form->field($model, 'Leave_No_To_Recall')->textInput(['readonly'=> true, 'disabled'=>true,'id'=> 'leave_no_to_recall']) ?>
                            <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','readonly'=> 'true','disabled'=>true]) ?>

                            <?= $form->field($model, 'Leave_balance')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Reporting_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Days_Applied')->textInput(['type' => 'number','readonly'=> 'true','disabled'=>true]) ?>



                        </div>

                        <div class="col-md-6">


                            <?= $form->field($model, 'Balance_After')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'End_Date')->textInput(['type' => 'date','readonly'=> 'true','disabled'=>true]) ?>
                            <?= $form->field($model, 'Leave_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Reliever')->textInput(['readonly'=> 'true','disabled'=>true]) ?>
                        </div>

                        </div>

                    </div>



                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
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
    $(function(){
        // $("#leaverecall-employee_no").select2();
        var url = $('input[name=absolute]').val();
        
        $("select#leaverecall-leave_no_to_recall").on('change', function(){
           var ky = $('#leaverecall-key').val();
           var lv = $(this).find(":selected").val();
           const Recall_No = $("#leaverecall-recall_no").val();
                      
                const payload = {
                    'Recall_No' : Recall_No,
                    'Leave_No_To_Recall': lv
                }
           
                $.post(url+'leaverecall/commitleavetorecall', payload).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leaverecall-leave_no_to_recall');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaverecall-leave_no_to_recall');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                       
                    }
                        $('#leave_no_to_recall').val(msg.Leave_No_To_Recall);
                        $('#leaverecall-balance_after').val(msg.Balance_After);
                        $('#leaverecall-leave_balance').val(msg.Leave_balance);
                        $('#leaverecall-start_date').val(msg.Start_Date);
                        $('#leaverecall-end_date').val(msg.End_Date);
                        $('#leaverecall-leave_status').val(msg.Leave_Status);
                        $('#leaverecall-days_applied').val(msg.Days_Applied);
                        $('#leaverecall-reliever').val(msg.Reliever);
                },'json');
                        
           //window.location.href =url+'leaverecall/create/?Leave_No_To_Recall='+lv+'&Key='+ky;
        });
        
                
        $("#leaverecall-days_to_recall").on('change', function(){
            const Recall_No = $("#leaverecall-recall_no").val();
            const Days_To_Recall = $(this).val();
            var payload = {
                Recall_No: Recall_No,
                Days_To_Recall: Days_To_Recall
            }
            
            $.post(url+'leaverecall/commitrecalldays', payload).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leaverecall-days_to_recall');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaverecall-days_to_recall');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                       
                    }
                        $('#leave_no_to_recall').val(msg.Leave_No_To_Recall);
                        $('#leaverecall-balance_after').val(msg.Balance_After);
                        $('#leaverecall-leave_balance').val(msg.Leave_balance);
                        $('#leaverecall-start_date').val(msg.Start_Date);
                        $('#leaverecall-end_date').val(msg.End_Date);
                        $('#leaverecall-leave_status').val(msg.Leave_Status);
                        $('#leaverecall-days_applied').val(msg.Days_Applied);
                        $('#leaverecall-reliever').val(msg.Reliever);
                },'json');
            
         
        });
    });
JS;

$this->registerJs($script);

?>
