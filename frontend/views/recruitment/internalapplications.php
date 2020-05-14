<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - My Applications';
$this->params['breadcrumbs'][] = ['label' => 'Recruitment ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'External Vacancies', 'url' => ['externalvacancies']];
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">HRMIS - My Applications</h3>


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
            ajax: absolute +'recruitment/getinternalapplications',
            paging: true,
            columns: [
                { title: 'Job Application No' ,data: 'Job_Application_No'},
                { title: 'Applicant_Name' ,data: 'Applicant_Name'},
                { title: 'Job_Description' ,data: 'Job_Description'},
                { title: 'Application_Status' ,data: 'Application_Status'},            
                    
            ] ,                              
           language: {
                "zeroRecords": "You have no job applications to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#requistions').DataTable();
       //table.columns([3,4,5,6,]).visible(false);
    
    /*End Data tables*/
        $('#requistions').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);






