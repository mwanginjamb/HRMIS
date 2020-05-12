<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - Performance Appraisal Report';
$this->params['breadcrumbs'][] = ['label' => 'Apprasal Mgt', 'url' => ['viewsubmitted','Employee_No'=> $_GET['employeeNo'],'Appraisal_No' => $_GET['appraisalNo']]];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal Report', 'url' => ['report','Employee_No'=> $_GET['employeeNo'],'Appraisal_No' => $_GET['appraisalNo']]];
?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Appraisal  Report</h3>

                </div>
                <div class="card-body">

                    <?php

                    if(isset($message)){
                        print '<p class="alert alert-info">'.$message.' . </p>';
                    }
                    if($report && !isset($message)){ ?>

                        <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>
                   <?php } ?>



                </div>
            </div>
        </div>
    </div>

<?php
$script  = <<<JS
   
JS;

$this->registerJs($script, yii\web\View::POS_READY);










