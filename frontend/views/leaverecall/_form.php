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

                            <?= $form->field($model, 'Days_To_Recall')->textInput(['type' => 'number']) ?>










                            <?= $form->field($model, 'Comments')->textarea(['rows'=> 3, 'max-length'=>'250']) ?>
                            <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false); ?>




                    </div>
                    <div class="col-md-6">

                        <div class="row">

                        <div class="col-md-6">

                            <?= $form->field($model, 'Leave_No_To_Recall')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','readonly'=> 'true','disabled'=>true]) ?>

                            <?= $form->field($model, 'Leave_balance')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Reporting_Date')->textInput(['type' => 'date','readonly'=> true, 'disabled'=>true]) ?>
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
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
           
           window.location.href =url+'leaverecall/create/?Leave_No_To_Recall='+lv+'&Key='+ky;
        });
    });
JS;

$this->registerJs($script);

?>
