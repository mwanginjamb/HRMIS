<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/23/2020
 * Time: 4:29 PM
 */

/* @var $this yii\web\View */

$this->title = 'Recruitment - Sharepoint Reader';
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
                    <?= \yii\helpers\Html::a('Go Back',['submit'],['class' => ' back btn btn-outline-primary push-right']) ?>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Qualifications.</h3>

                </div>
                <div class="card-body" >




                    <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>



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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">My Academic Qualifications</h4>
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


    <input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS

    $(function(){
        
        var absolute = $('input[name=absolute]').val();
         /*Data Tables*/
         
         $.fn.dataTable.ext.errMode = 'throw';        
    
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
    
    
    /*Update Qualifications */
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
    });
        
JS;

$this->registerJs($script);








