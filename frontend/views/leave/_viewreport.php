<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS Leave History Report';
?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Leave History Report</h3>

                </div>
                <div class="card-body">
                    <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>
                </div>
            </div>
        </div>
    </div>









