<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS Employee Requisition';
$this->params['breadcrumbs'][] = ['label' => 'Employee Requisition ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Requisitions List', 'url' => ['index']];
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Requisition List</h3>


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
                <table class="table table-bordered dt-responsive table-hover" id="requistions">
                </table>
            </div>
        </div>
    </div>
</div>


<?php
$absoluteUrl = \yii\helpers\Url::home(true);
print '<input type="hidden" id="ab" value="'.$absoluteUrl.'" />';
$script = <<<JS

    $(function(){
         /*Data Tables*/
         var absolute = $('#ab').val(); 
         
         //$.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#requistions').DataTable({
           
            //serverSide: true,  
            ajax: absolute +'employeerequisition/getrequisitions',
            paging: true,
            columns: [
                { title: 'Requisition No' ,data: 'Requisition_No'},
                { title: 'Requisition Date' ,data: 'Requisition_Date'},
                { title: 'Job Description' ,data: 'Job_Description'},
                { title: 'Reason For Request' ,data: 'Reason_For_Request'},
                { title: 'Required Positions' ,data: 'Required_Positions'},
                { title: 'Contract Required' ,data: 'Type_of_Contract_Required'},
                { title: 'Completion Status' ,data: 'Completion_Status'},
                { title: 'Approval Status', data: 'Approval_Status' },
                { title: 'Action', data: 'action' },
                { title: 'Update', data: 'Update_Action' },
                { title: 'Details', data: 'view' },
                
               
            ] ,                              
           language: {
                "zeroRecords": "No HR requisitions to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#requistions').DataTable();
       table.columns([3,4,5,6,]).visible(false);
    
    /*End Data tables*/
        $('#requistions').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);






