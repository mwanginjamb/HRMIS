<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Leave Application : <?= $leave->Application_No?></h3>



                <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                 <h4><i class="icon fa fa-check"></i>Saved!</h4>';
                                    echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                 <h4><i class="icon fa fa-check"></i>Error!</h4>';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }
                ?>
            </div>
            <div class="card-body">


                <?php
                    print '<pre>';
                    print_r($leave);
                ?>



            </div>
        </div>
    </div>
</div>
