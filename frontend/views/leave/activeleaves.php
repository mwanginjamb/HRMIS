<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS Active Leaves';
$this->params['breadcrumbs'][] = ['label' => 'My Leaves List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Staff on Leaves', 'url' => ['activeleaves']];
?>



<?php
if(Yii::$app->session->hasFlash('success')){
    print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}else if(Yii::$app->session->hasFlash('error')){
    print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Staff on Leave List</h3>






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
         
         //$.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: './getactiveleaves',
            paging: true,
            columns: [
                { title: 'Leave No.' ,data: 'Application Code'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Days Applied' ,data: 'Days_Applied'},
                { title: 'Start_Date' ,data: 'Start_Date'},
                { title: 'Return_Date' ,data: 'Return_Date'},
                { title: 'End_Date' ,data: 'End_Date'},
                { title: 'Status', data: 'Status' },
               
            ] ,                              
           language: {
                "zeroRecords": "No Active Leaves to display"
            },
            
            //order : [[ 2, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
      // table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#leaves').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
tr > td:nth-child(4), th:nth-child(4){
    color: red!important;
}

tr > td:nth-child(5), th:nth-child(5){
    color: lightgreen!important;
}

tr > td:nth-child(6), th:nth-child(6){
    color: #0056b3!important;
}
CSS;

$this->registerCss($style);





