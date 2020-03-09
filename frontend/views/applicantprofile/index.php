<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
        <?= \yii\helpers\Html::a('New Leave Recall',['create','create'=> 1],['class' => 'btn btn-outline-warning push-right', 'data' => [
            'confirm' => 'Are you sure you want to create a new leave request?',
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
                <h3 class="card-title">My Leave History List</h3>


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


<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
         $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: './getrecalls',
            paging: true,
            columns: [
                { title: 'Recall No' ,data: 'Recall_No'},
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Application No' ,data: 'Leave_No_To_Recall'},
                { title: 'Days Applied' ,data: 'Days_Applied'},
                { title: 'Application Date' ,data: 'Application_Date'},
                { title: 'Approval Status' ,data: 'Approval_Status'},
               
                { title: 'Action', data: 'Action' },
                { title: 'Update Action', data: 'Update_Action' },
                { title: 'Details', data: 'view' },
               
            ] ,                              
           language: {
                "zeroRecords": "No leave Recall history to display"
            },
            
            order : [[ 2, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
       //table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#leaves').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);






