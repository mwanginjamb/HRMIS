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



                <?php




                $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">



                        <table class="table">
                            <tbody>


                            <?= $form->field($model, 'Behaviour_Name')->textInput(['readonly' => true]) ?>

                            <?= (!Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Applicable')->checkbox(['value' => true,['enclosedByLabel' => true]]):'' ?>

                            <?= (!Yii::$app->user->identity->isSupervisor() && Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level')?$form->field($model, 'Current_Proficiency_Level')->dropDownList($proficiencylevels,['prompt' => 'Select Proficiency Level']):'' ?>

                            <?= (Yii::$app->user->identity->isSupervisor() && Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level')?$form->field($model, 'Expected_Proficiency_Level')->dropDownList($proficiencylevels,['prompt' => 'Select Proficiency Level']):'' ?>

                            <?= (!Yii::$app->user->identity->isSupervisor() && Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level')?$form->field($model, 'Self_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>

                            <?= (Yii::$app->user->identity->isSupervisor() && Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level')?$form->field($model, 'Appraiser_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Peer_1_Level')?$form->field($model, 'Peer_1')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Peer_2_Level')?$form->field($model, 'Peer_2')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= (Yii::$app->user->identity->isSupervisor() && Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level')?$form->field($model, 'Agreed_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= (Yii::$app->user->identity->isSupervisor() && Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level')?$form->field($model, 'Overall_Remarks')->textarea(['rows' => 4,'max-length'=> 250]):'' ?>

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
