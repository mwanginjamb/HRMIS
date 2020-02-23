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
            <div class="card-header">
                <h3 class="card-title">My Leave History List</h3>
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
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: './getleaves',
            paging: true,
            columns: [
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Application No' ,data: 'Application_No'},
                { title: 'Days Applied' ,data: 'Days_Applied'},
                { title: 'Application Date' ,data: 'Application_Date'},
                { title: 'Approval Status' ,data: 'Approval_Status'},
               
            ]                   
           
       });
    
    /*End Data tables*/
    });
        
JS;

$this->registerJs($script);






