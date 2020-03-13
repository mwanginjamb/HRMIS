<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'Recruitment - Job Experience';
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
        <?= \yii\helpers\Html::a('Add Experience',['create','create'=> 1],['class' => 'create btn btn-outline-warning push-right']) ?>
        </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Work Experince.</h3>


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
    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Work Experience</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>

<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
        // $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: './getexperience',
            paging: true,
            columns: [
                { title: '....', data: 'index'},
                { title: 'Position' ,data: 'Position'},
                { title: 'Job_Description' ,data: 'Job_Description'},
                { title: 'Institution' ,data: 'Institution'},
                { title: 'Update_Action' ,data: 'Update_Action'},
                { title: 'Remove' ,data: 'Remove'},
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Work Experience to Show.."
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
      table.columns([0]).visible(false);
    
    /*End Data tables*/
        $('#leaves').on('click','.update', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
       //Add an experience
    
     $('.create').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
    
    /*Handle dismissal eveent of modal */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
        
        
    });//end jquery

    

        
JS;

$this->registerJs($script);





