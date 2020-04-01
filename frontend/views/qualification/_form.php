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
                    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row">
                    <div class="col-md-12">



                            <table class="table">
                                <tbody>

                                

                                <tr>
                                    <?= $form->field($model, 'Qualification_Code')->dropDownList($qlist, ['prompt' => 'Select Qualification..','required' => 1]) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Description')->textInput(['readonly' => 'true']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Institution_Company')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'application/*']) ?>
                                </tr>

                                <tr>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['value' => Yii::$app->recruitment->getProfileID(), 'readonly' => 'true'])->label(false) ?>
                                    <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
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

<?php

$script = <<<JS
    $(function(){
        $('#qualification-qualification_code').on('change', function(){
            var selected =  $('#qualification-qualification_code').find(':selected').text();
            $('#qualification-description').val(selected);
            
        });

        $('#qualification-qualification_code').select2();
    });
JS;

$this->registerJs($script);

?>


