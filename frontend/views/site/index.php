<?php

/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';

/*print '<pre>';
print_r(Yii::$app->user->identity->employee);
exit;*/

?>

<section class="content">
    <div class="container-fluid">






        <div class="row">



            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="https://via.placeholder.com/150/cccccc/FFFFFF/?text=<?= Yii::$app->user->identity->Employee[0]->Last_Name?>"
                                 alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= (!empty( $employee->First_Name) && !empty( $employee->Last_Name))? $employee->First_Name.' '.$employee->Last_Name:'';  ?></h3>

                        <p class="text-muted text-center"><?= !empty($employee->Title)?$employee->Title:'' ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><i class="fa fa-phone-alt"></i></b> <a class="float-right"><?= !empty($employee->Cellular_Phone_Number)?$employee->Cellular_Phone_Number:'' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fa fa-mail-bulk"></i></b><a class="float-right"><?= !empty($employee->Company_E_Mail)?$employee->Company_E_Mail:'' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fa fa-hourglass-start"></i></b> <a title="Length of Service" class="float-right"><?= !empty($employee->DService)?$employee->DService:'' ?></a>
                            </li>


                            <li class="list-group-item">
                                <b><i class="fa fa-briefcase"></i></b> <a title="Job Title" class="float-right"> <?= !empty($employee->Job_Title)?$employee->Job_Title:'' ?></a>
                            </li>


                            <li class="list-group-item">
                                <b><i class="fa fa-briefcase"></i></b> <a title="Job Grade" class="float-right"><?= !empty($employee->Salary_Grade)?$employee->Salary_Grade:'' ?></a>
                            </li>

                            <li class="list-group-item">
                                <b><i class="fa fa-person-booth mr-1"></i></b> <a title="Date of Join" class="float-right"><?= !empty($employee->Date_Of_Join)?$employee->Date_Of_Join:'' ?></a>
                            </li>


                        </ul>

                        <a href="<?= Yii::$app->recruitment->absoluteUrl() ?>employee/" class="btn btn-primary btn-block"><b>My Profile</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">My Leave Balances</h3>
                    </div>
                    <div class="card-body">
                        <table class="table dt-responsive table-hover">
                            <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php



                            foreach($balances as $key => $val){
                                if($key == 'Key')
                                    continue;
                                print '
                                    <tr>
                                        <td>'.str_replace('_',' ',$key).'</td><td>'.$val.'</td>
                                     </tr>
                            ';

                            } ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!--End Me Box-->

                <!-- /.card -->
            </div>
            <!-- /.col -->


            <!--start col ---9-->



            <div class="col-md-9">



                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'recruitment/vacancies' ?>" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-briefcase" style="color:#fff!important;"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vacancies</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getVacancies() ?>
                                      <small></small>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                    </div>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>


                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                            <a href="<?= Yii::$app->recruitment->absoluteUrl().'site/openrequests' ?>" target="_blank">

                                    <div class="info-box-content">
                                        <span class="info-box-text">Open Requests</span>
                                        <span class="info-box-number"><?= Yii::$app->dashboard->getOpenApprovals() ?>
                                          <small></small>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->

                            </a>
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">


                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'site/approvedrequests' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Approved Reqs.</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getApprovedApprovals() ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'site/rejectedrequests' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rejected Reqs.</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getRejectedApprovals() ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->

                        </a>



                    </div>


                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'site/pendingapprovals' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-envelope-open" style="color:#fff!important;"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Approvals</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getSuperPending())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'recruitment/internalapplications' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-paper-plane"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">My Applications</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getInternalapplications())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- .col my Approved -->

                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'site/supervisorapproved' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">My Approved</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getSuperApproved())?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                        </a>

                    </div>


                    <!-- /.col -->


                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- .col My Rejected -->

                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'site/supervisorrejected' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">My Rejected</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getSuperRejected())?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                        </a>
                    </div>


                    <!-- /.col -->



                </div>
                <!-- /.row -->


<!--                Appraisal Stuff -->
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/approvedappraisals' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Approved Goals</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getApprovedAppraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/myappraiseelist' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-balance-scale"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Mid Year Appraisals</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getMyAppraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/eyappraiseelist' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-balance-scale"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">End Year Appraisals</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getEyAppraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/eyappraiseeclosedlist' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-balance-scale"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Closed Appraisal</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getClosedAppraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->


                </div>

<!--                Peer Evals Row-->

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/eypeer1list' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Peer 1 Evaluations</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getPeer1Appraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/eypeer2list' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Peer 2 Evaluations</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getPeer2Appraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl().'appraisal/eyagreementappraiseelist' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-handshake"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Agreement Level</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getAgreementlevelAppraisals())?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>

                    </div>

                    <div class="col-12 col-sm-6 col-md-3">


                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Staff on Leave This Week</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered dt-responsive table-hover" id="leaves">
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
       
            $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: '/leave/getactiveleaves',
            paging: true,
            columns: [
                // { title: 'Leave No.' ,data: 'Application Code'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Days Applied' ,data: 'Days_Applied'},
                { title: 'Start Date' ,data: 'Start_Date'},
                { title: 'End Date' ,data: 'End_Date'},
                { title: 'Return Date' ,data: 'Return_Date'},
                { title: 'Leave Type' ,data: 'Leave_Type'},
                // { title: 'Status', data: 'Status' },
               
            ] ,                              
           language: {
                "zeroRecords": "No Active Leaves to display"
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

// $this->registerCss($style);