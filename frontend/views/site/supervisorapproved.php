<?php

/* @var $this yii\web\View */

$this->title = 'HRMIS - Supervisor Approved  Requests';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';

/*print '<pre>';
print_r(Yii::$app->user->identity->employee);
exit;*/

?>

<section class="content">
    <div class="container-fluid">


        <div class="row">

            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">My Open Requests. </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered dt-responsive table-hover" id="open">
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>

</section>



<?php


$script = <<<JS

    $(function(){
         /*Data Tables*/
        
         
         //$.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#onleave').DataTable({
           
           paging: true,                                        
           language: {
                "zeroRecords": "No records to display"
            },
            
            order : [[ 0, "desc" ]]            
           
       });
          
       /*Active leaves */
       
            $('#open').DataTable({
           
            //serverSide: true,  
            ajax: '/site/getsupervisorapproved',
            paging: true,
            columns: [
                
                { title: '#' ,data: 'id'},
                { title: 'Details' ,data: 'Details'},
                { title: 'Comment' ,data: 'Comment'},
                { title: 'Sender_ID' ,data: 'Sender_ID'},
                { title: 'Due_Date' ,data: 'Due_Date'},
                { title: 'Status' ,data: 'Status'},
                // { title: 'Status', data: 'Status' },
               
            ] ,                              
           language: {
                "zeroRecords": "No Approved Requests to display"
            },
            
            //order : [[ 2, "desc" ]]     
       });
        
      
    
   
    });
        
JS;

$this->registerJs($script);


$style = <<<CSS
tr > td:nth-child(5), th:nth-child(5){
    color: red!important;
}

tr > td:nth-child(3), th:nth-child(3){
    color: lightgreen!important;
}

tr > td:nth-child(4), th:nth-child(4){
    color: #0056b3!important;
}
CSS;

//$this->registerCss($style);