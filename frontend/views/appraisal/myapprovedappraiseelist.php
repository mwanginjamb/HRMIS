<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS Mid Year Appraisal List: Supervisor';
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Approved Mid Year Appraisal List (Appraisee)', 'url' => ['index']];
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
                    <h3 class="card-title">Approved Mid Year Appraisal List (Appraisee)</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="appraisal">
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
         
         $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#appraisal').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'appraisal/getmyapprovedappraiseelist',
            paging: true,
            columns: [
                { title: 'Appraisal No' ,data: 'Appraisal_No'},
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Level Grade' ,data: 'Level_Grade'},
                { title: 'Job Title' ,data: 'Job_Title'},
                { title: 'Function Team' ,data: 'Function_Team'},
                { title: 'Appraisal Period' ,data: 'Appraisal_Period'},
                { title: 'Goal Setting Start Date' ,data: 'Goal_Setting_Start_Date'},
               
                { title: 'Action', data: 'Action' },
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Appraisals to display"
            },
            
            order : [[ 6, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#appraisal').DataTable();
       //table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#appraisal').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);






