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
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



            <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">



                            <table class="table">
                                <tbody>

                                   
                                    <?= $form->field($model, 'KRA')->textInput(['readonly' => true]) ?>

                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isSupervisor') == false )?$form->field($model, 'Perfomance_Level')->dropDownList($performancelevels,['prompt'=> 'Select Performance Level']):'' ?>

                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isSupervisor') == false )?$form->field($model, 'Perfomance_Comment')->textarea(['row'=> 3, 'maxlength' => 250]):'' ?>

                                    <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isSupervisor') == false )?$form->field($model, 'Employee_Comments')->textarea(['row'=> 3, 'maxlength' => 250]):'' ?>

                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Closed' && Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' && !Yii::$app->session->get('isSupervisor'))?$form->field($model, 'Appraisee_Self_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>

                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Closed' && Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level' && Yii::$app->session->get('isSupervisor'))?$form->field($model, 'Appraiser_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>

                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Closed' && Yii::$app->session->get('EY_Appraisal_Status') == 'Agreement_Level' && Yii::$app->session->get('isSupervisor'))?$form->field($model, 'Agreed_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):''?>

                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Closed' && Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level' && Yii::$app->session->get('isSupervisor'))?$form->field($model, 'Rating_Comments')->textInput():'' ?>

                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>











                                </tbody>
                            </table>



                    </div>

                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Evaluate', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

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
JS;

$this->registerJs($script);

