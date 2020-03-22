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
                                    <?= $form->field($model, 'Language_Description')->dropDownList(['English' => 'English', 'French' => 'French', 'Portuguese' => 'Portuguese', 'other' => 'other'], ['prompt' => 'Select Language..']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Read')->checkbox() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Write')->checkbox() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Speak')->checkbox() ?>
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
