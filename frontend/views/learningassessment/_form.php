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




                                    <?= $form->field($model, 'Training_Action')->textarea(['rows'=>2,'max-length' => 250]) ?>

                                    <?= $form->field($model, 'Due_Date')->textInput(['type' => 'date']) ?>

                                    <?= $form->field($model, 'Learning_Hours')->textInput(['type' => 'number']) ?>
                                    <?= $form->field($model, 'Status_Mid_Year')->textInput() ?>
                                    <?= $form->field($model, 'Status_End_Year')->textInput() ?>
                                    <?= $form->field($model, 'Comments')->textarea(['rows'=>2,'max-length' => 250]) ?>




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
