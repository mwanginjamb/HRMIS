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


                                    <?= $form->field($model, 'KRA')->textInput(['readonly' => true]) ?>

                                    <?= (Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Perfomance_Level')->textInput():'' ?>

                                    <?= (Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Perfomance_Comment')->textInput(): '' ?>

                                    <?= (!Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Appraisee_Self_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>

                                    <?= (Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Appraiser_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>

                                    <?= (Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Agreed_Rating')->textInput():'' ?>

                                    <?= (Yii::$app->user->identity->isSupervisor())?$form->field($model, 'Rating_Comments')->textInput(['type' => 'number']):'' ?>

                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>











                                </tbody>
                            </table>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
