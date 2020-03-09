<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/*print '<pre>';
print_r($model[0]); exit;*/

$model = $model[0];
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Job Vacancy : <?= $model->Job_Title?></h3>

                <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                                    echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }
                ?>
            </div>
            <div class="card-body">


               <?php $form = ActiveForm::begin(['action'=> ['leave/create']]); ?>


               <div class="row">
                   <div class=" row col-md-12">
                       <div class="col-md-6">
                           <!-- form start -->
                           <form class="form-horizontal">
                               <div class="card-body">
                                   <div class="form-group row">
                                       <label for="inputEmail3" class="col-sm-2 col-form-label">Job ID</label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" id="inputEmail3" value="<?= $model->Job_ID?>" readonly>
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-2 col-form-label">Job Title</label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" value="<?= $model->Job_Title ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label for="inputEmail3" class="col-sm-2 col-form-label">Job Purpose</label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" id="inputEmail3" value="<?= $model->Job_ID?>" readonly>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label for="inputEmail3" class="col-sm-2 col-form-label">Job Dimension</label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" id="inputEmail3" value="<?= $model->Job_ID?>" readonly>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-2 col-form-label">Position Reporting to</label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" value="<?= $model->Position_Reporting_to ?>" readonly>
                                       </div>
                                   </div>




                                   <!--<div class="form-group row">
                                       <div class="offset-sm-2 col-sm-10">
                                           <div class="form-check">
                                               <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                               <label class="form-check-label" for="exampleCheck2">Remember me</label>
                                           </div>
                                       </div>
                                   </div>-->
                               </div>
                               <!-- /.card-body -->

                               <!-- /.card-footer -->
                           </form>
                       </div>
                       <div class="col-md-6">

                           <div class="card-body">
                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">Global Dimension 1 Code</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= '' ?>" readonly>
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">Global Dimension 2 Code</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= '' ?>" readonly>
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">Grade</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= $model->Grade ?>" readonly>
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">Position Reporting to</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= $model->Position_Reporting_to ?>">
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">Status</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= $model->Status ?>">
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">No_of_Requirements</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= $model->No_of_Requirements ?>" readonly>
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="inputPassword3" class="col-sm-2 col-form-label">No of Responsibilities</label>
                               <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?= $model->No_of_Responsibilities ?>" readonly>
                               </div>
                           </div>

                           </div>


                       </div>
                   </div>
               </div>



               <?php ActiveForm::end(); ?>



            </div>
        </div>
    </div>
</div>
