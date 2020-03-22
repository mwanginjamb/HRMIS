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

    <!--THE STEPS THING--->

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('..\applicantprofile\_steps') ?>
        </div>
    </div>

    <!--END THE STEPS THING--->


<div class="row">
    <div class="col-md-12">
        <div class="card card-blue">
            <div class="card-header">

                <h3 class="card-title">Submit Application </h3>

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

                <table class="table" border="0">
                    <tr>
                        <td>
                            <p>Briefly put down a letter of motivation (Less than 250 characters)</p>
                             <?php $form = ActiveForm::begin(); ?>
                             <?= $form->field($model, 'motivation')->textarea(['rows'=>4,'max-length' => 250]) ?>
                             <?php ActiveForm::end(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          
                           <?= Html::checkbox('confirm',false,['class' =>'confirm']) ?>


                            &nbsp;<i>I confirm that information given is true and verifiable.  </i>
                        </td>
                        <td>
                            <?= Html::a('submit Application',['submit','requisitionNo' => '2'],['class' => 'submit btn btn-outline-success']) ?>
                        </td>
                    </tr>
                </table>





            </div><!--end application submition-->
        </div>





    </div>
</div>

<?php

$script = <<<JS
     $(function(){
         $('.submit').hide();
        $('.confirm').click(function(){
            if($(this).is(':checked')){
                //alert('checked..');
                $('.submit').show();
            }
        });
    });
JS;

$this->registerJs($script);


