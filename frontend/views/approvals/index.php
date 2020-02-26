<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - Approval Requests';
?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Approval Requests</h3>


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
                    <table class="table table-bordered dt-responsive table-hover" id="approvals">
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
         
         $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#approvals').DataTable({
           
            //serverSide: true,  
            ajax: absolute +'approvals/getapprovals',
            paging: true,
            columns: [
                //{ title: 'ToApprove' ,data: 'ToApprove'},
                { title: 'Details' ,data: 'Details'},
                { title: 'Comment' ,data: 'Comment'},
                { title: 'Sender_ID' ,data: 'Sender_ID'},
                { title: 'Due_Date' ,data: 'Due_Date'},
                { title: 'Status' ,data: 'Status'},
                { title: 'Document_No' ,data: 'Document_No'},
                { title: 'Approve' ,data: 'Approvelink'},
                { title: 'Reject' ,data: 'Rejectlink'},
                { title: 'Details' ,data: 'details'},
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Requests to Approve for now."
            },
            
            order : [[ 6, "desc" ]]
           
       });
        
       //Hidding some 
       var table = $('#approvals').DataTable();
       //table.columns([0,2,6]).visible(false);
    
    /*End Data tables*/
    });
        
JS;

$this->registerJs($script);






