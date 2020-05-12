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

                                <tr>
                                    <?= $form->field($model, 'First_Name')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Middle_Name')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Last_Name')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Instituition')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Position')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Email')->textInput(['type' => 'email']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Phone_No')->textInput(['max-length' => 10]) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly' => true])->label(false) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly' => true,'disabled' => true])->label(false) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Application_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                </tr>












                                </tbody>
                            </table>



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
