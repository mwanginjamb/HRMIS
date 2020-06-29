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
print_r($requirements);
exit;*/
?>

    <!--THE STEPS THING--->

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('..\applicantprofile\_steps') ?>
        </div>
    </div>

    <!--END THE STEPS THING--->


<div class="row">
    <div class="col-md-12">
        <?php
        if(Yii::$app->session->hasFlash('success')){
            print ' <div class="alert alert-success alert-dismissable">
                                 ';
            echo Yii::$app->session->getFlash('success');
            print '</div>';
        }else if(Yii::$app->session->hasFlash('error')){
            print ' <div class="alert alert-danger alert-dismissable">
                                 ';
            echo Yii::$app->session->getFlash('error');
            print '</div>';
        }
        ?>
    </div>
    <div class="col-md-12">
        <div class="card card-blue">
            <div class="card-header">

                <h3 class="card-title">Submit Application </h3>


            </div>
            <div class="card-body">

            <?php if(is_array($requirements)){ ?>

                <p>Upload a coverletter and a CV</p>
                <!--UPLOAD CV AND COVERLETTER -->

                <table class="table">
                <?php $form = ActiveForm::begin(['action' => Yii::$app->recruitment->absoluteUrl().'cv/upload'],['options' => ['enctype' => 'multipart/form-data']]) ?>

                    <tr>
                        <td>
                            <?= $form->field($cvmodel, 'imageFile')->fileInput() ?>
                        </td>
                        <td style="width:15%">
                            <button class="btn btn-outline-primary">Submit</button>
                        </td>

                <?php if(\Yii::$app->recruitment->hasCv()): ?>
                        <td style="width:15%">
                            <?= Html::a('View Document',['recruitment/download','path' => $cvmodel->getPath()],['class' => 'btn btn-outline-info']) ?>
                        </td>
                <?php endif; ?>

                    </tr>
                <?php ActiveForm::end() ?>
                </table>

            <table class="table">
                <?php $form = ActiveForm::begin(['action' => Yii::$app->recruitment->absoluteUrl().'coverletter/upload'],['options' => ['enctype' => 'multipart/form-data']]) ?>
                <tr>
                    <td>
                        <?= $form->field($covermodel, 'imageFile')->fileInput() ?>
                    </td>
                    <td style="width:15%">
                        <button class="btn btn-outline-primary">Submit</button>
                    </td>
                <?php if(\Yii::$app->recruitment->hasCoverletter()): ?>
                    <td style="width:15%">
                        <?= Html::a('View Document',['recruitment/download','path' => $covermodel->getPath()],['class' => 'btn btn-outline-info']) ?>
                    </td>
                <?php endif; ?>


                </tr>
                <?php ActiveForm::end() ?>

            </table>

                <!--END TESTIMONIAL UPLOAD-->


                <h4 class="alert alert-info">Kindly, Mark if you meet following qualifications.</h4>

                <table class="table table-hover table-bordered">
                    <thead>
                        <th>Profile No.</th>
                        <th>Applicant No.</th>
                        <th>Requirement Specification</th>
                        <th>Met</th>

                    </thead>
                    <tbody>
                        <?php
                            foreach($requirements as $req){
                                print '<tr>
                                        <td>'.$req->Profile_No.'</td>
                                        <td>'.$req->Job_Applicant_No.'</td>
                                        <td>'.$req->Requirement_Specification.'</td>
                                        <td>'.Html::checkbox('requirement',$req->Met,['rel'=> $req->Key,'rev' => $req->Line_No]).'</td>
                                    </tr>';
                            }
                        ?>
                    </tbody>



                </table>

                <?= Html::a('Complete Application',['applicantprofile/update','No' => Yii::$app->recruitment->getProfileID()],['class' => 'btn btn-success','style' => 'margin-top: 10px']);?>

            <?php }else{  ?>

                <table class="table" border="0">
                    <tr>
                        <td>
                            <!--<p>Briefly put down a letter of motivation (Less than 250 characters)</p>-->
                             <?php $form = ActiveForm::begin(); ?>
                                    <?php $form->field($model, 'Motivation')->textarea(['rows'=>4,'max-length' => 250]) ?>

                        </td>
                    </tr>
                    <tr>
                        <td>
                          
                           <?= Html::checkbox('confirm',false,['class' =>'confirm']) ?>


                            &nbsp;<i>I confirm that information given is true and verifiable.  </i>
                        </td>
                        <td>
                            <?= Html::submitButton('submit Application',['class' => 'submit btn btn-outline-success']) ?>
                        </td>
                        <?php ActiveForm::end(); ?>
                    </tr>
                </table>



    <?php } ?>





            </div><!--end application submition-->
        </div>





    </div>
</div>
<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS
     $(function(){
         $('.submit').hide();
        $('.confirm').click(function(){
            if($(this).is(':checked')){
                //alert('checked..');
                $('.submit').show();
            }else{
                $('.submit').hide();
            }
        });
        
        //Marking the checklist
        var absolute = $('input[name=absolute]').val();
        $('input[name=requirement]').on('click', function(e){
            //e.preventDefault();
            var key = $(this).attr('rel');
            var Line_No = $(this).attr('rev');
            $.post(absolute+'recruitment/requirementscheck',{"Key": key,"Line_No": Line_No }).done(function(msg){
                console.log(msg);
            });
            
            
            location.reload();
        });
    });
JS;

$this->registerJs($script);


