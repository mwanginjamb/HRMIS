<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:08 PM
 */






/* @var $this yii\web\View */

$this->title = 'Recruitment - Applicant Qualifications';
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
            <div class="card">
                <div class="card-body">
                    <?= \yii\helpers\Html::a('Add Qualification',['create','create'=> 1],['class' => 'btn btn-outline-warning push-right', 'data' => [
                        'confirm' => 'Are you sure you want to add a Qualification ?',
                        'method' => 'post',
                    ],]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Qualifications.</h3>


                    <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">';
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
                <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="leaves">
                    </table>
                </div>
            </div>
        </div>
    </div>

<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS

    $(function(){
        
        var absolute = $('input[name=absolute]').val();
         /*Data Tables*/
         
        // $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'qualification/getqualifications',
            paging: true,
            columns: [
                { title: '....', data: 'index'},
                { title: 'Applicant ID' ,data: 'Employee_No'},
                { title: 'Qualification Code' ,data: 'Qualification_Code'},
                { title: 'From Date' ,data: 'From_Date'},
                { title: 'To Date' ,data: 'To_Date'},
                { title: 'Description' ,data: 'Description'},
                { title: 'Institution / Company' ,data: 'Institution_Company'},
               // { title: 'Comment' ,data: 'Comment'},
               
                { title: 'Update Action' ,data: 'Update_Action'},
                { title: 'Remove' ,data: 'Remove'},
                
               
            ] ,                              
           language: {
                "zeroRecords": "No  Qualifications to show."
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
      table.columns([0]).visible(false);
    
    /*End Data tables*/
        $('#leaves').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);








