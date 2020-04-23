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




                                    <?= $form->field($model, 'Appraisal_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Wekaness_Line_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Development_Plan')->textarea(['max-length' => 250, 'row' => 4,'placeholder' => 'Development Plan']) ?>


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
