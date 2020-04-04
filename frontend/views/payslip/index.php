<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - Payslip Report';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Payslip', 'url' => ['index']];
?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Payslip Report</h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="<?= Yii::$app->recruitment->absoluteUrl().'payslip/index'?>">
                                <?= \yii\helpers\Html::dropDownList('payperiods','',$pperiods,['prompt' =>'select PayPeriod','class' => 'form-control']) ?>

                                <div class="form-group" style="margin-top: 10px">
                                <?= \yii\helpers\Html::submitButton('Generate Payslip',['class' => 'btn btn-primary']); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--<iframe src="data:application/pdf;base64,<?/*= $content; */?>" height="950px" width="100%"></iframe>-->
                    <?php
                    if($report){ ?>

                        <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>
                   <?php } ?>



                </div>
            </div>
        </div>
    </div>

<?php
$script  = <<<JS
    $('select[name="payperiods"]').select2();
JS;

$this->registerJs($script, yii\web\View::POS_READY);










