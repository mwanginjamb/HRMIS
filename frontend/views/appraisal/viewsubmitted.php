<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Supervisor Appraisal View - '.$model->Appraisal_No;
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal View', 'url' => ['view','Employee_No'=> $model->Employee_No,'Appraisal_No' => $model->Appraisal_No]];

Yii::$app->session->set('Goal_Setting_Status',$model->Goal_Setting_Status);
Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor','true');
//Yii::$app->recruitment->printrr($peers);
$absoluteUrl = \yii\helpers\Url::home(true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-info">
            <div class="card-header">
                <h3>Performance Appraisal Card</h3>
            </div>

         
           
           
            <div class="card-body info-box">

                <div class="row">

                <?php if($model->Goal_Setting_Status == 'Pending_Approval'): ?>

                    <div class="col-md-4">

                        <?= Html::a('<i class="fas fa-check"></i> Approve',['approve','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-success submitforapproval',
                                'title' => 'Approve Appraisal Objectives/ Goals for Appraisee',
                                'data' => [
                                'confirm' => 'Are you sure you want to Approve this appraisal?',
                                'method' => 'post',
                            ]
                        ]) ?>

                    </div>
                <?php elseif($model->MY_Appraisal_Status == 'Supervisor_Level'): ?>
                    <?= Html::a('<i class="fas fa-check"></i> Approve MY',['approvemy','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-success submitforapproval',
                                'title' => 'Approve Mid Year Appraisal',
                                'data' => [
                                'confirm' => 'Are you sure you want to Approve this Mid Year Appraisal ?',
                                'method' => 'post',
                            ]
                        ]) ?>

                <?php elseif($model->EY_Appraisal_Status == 'Agreement_Level'): ?>

                    <?= Html::a('<i class="fas fa-check"></i> Approve EY',['approveey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-success submitforapproval',
                                'title' => 'Approve End Year Appraisal',
                                'data' => [
                                'confirm' => 'Are you sure you want to Approve this End Year Appraisal ?',
                                'method' => 'post',
                            ]
                        ])
                    ?>

                <?php endif; ?>


                <?php if($model->EY_Appraisal_Status == 'Supervisor_Level'): ?>

                <?= Html::a('<i class="fas fa-check"></i> Agreement',['sendtoagreementlevel','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-app bg-success submitforapproval',
                            'title' => 'Move Appraisal to  Agreement Level',
                            'data' => [
                            'confirm' => 'Are you sure you want to send this End-Year Appraisal to Agreement Level ?',
                            'method' => 'post',
                            ]
                    ])
                ?>

            <?php endif; ?>




                <?php if($model->Goal_Setting_Status == 'Pending_Approval'): ?>
                    <div class="col-md-4">

                        <?= Html::a('<i class="fas fa-times"></i> Reject',['reject','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-warning reject',
                                'title' => 'Reject Goals Set by Appraisee',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
                                'method' => 'post',]*/
                            ]) 
                        ?>

                    </div>

                <?php elseif($model->MY_Appraisal_Status == 'Supervisor_Level'): ?>

                    <?= Html::a('<i class="fas fa-times"></i> Reject MY',['rejectmy'],[
                                'class' => 'btn btn-app bg-warning rejectmy',
                                'title' => 'Reject Mid-Year Appraisal',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid-Year appraisal?',
                                'method' => 'post',]*/
                            ]) 
                        ?>
                <?php elseif($model->EY_Appraisal_Status == 'Agreement_Level'): ?>

                    
                    <?= Html::a('<i class="fas fa-times"></i> Reject EY',['rejectey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-warning rejectey',
                                'title' => 'Reject End-Year Appraisal',
                                'rel' =>  $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this End-Year Appraisal?',
                                'method' => 'post',]*/
                            ]) 
                    ?>

                <?php endif; ?>
</div><!--end row-->

<div class="row"><!-- start peer actions-->
                    <div class="col-md-3">
                    </div>

                    <div class="col-md-3">

                        <?=($model->EY_Appraisal_Status == 'Supervisor_Level')?Html::a('<i class="fas fa-play"></i> Send Peer1',['sendpeer1','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-warning',
                                'title' => 'Reject Mid-Year Appraisal',
                                'data' => [
                                'confirm' => 'Are you sure you want to appraisal peer 1?',
                                'method' => 'post',]
                            ]) :'';
                        ?>



                    </div>

                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3">

                        <?= ($model->EY_Appraisal_Status == 'Supervisor_Level')? Html::a('<i class="fas fa-play"></i> Send Peer2',['sendpeer2','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-app bg-warning pull-right',
                            'title' => 'Reject Mid-Year Appraisal',
                            'data' => [
                                'confirm' => 'Are you sure you want to send appraisal to peer 2?',
                                'method' => 'post',]
                        ]) :'';
                        ?>


                        <?=  ($model->EY_Appraisal_Status == 'Closed')?Html::a('<i class="fas fa-book-open"></i> P.A Report',['report','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-app bg-success  pull-right',
                            'title' => 'Generate Performance Appraisal Report',
                            'target'=> '_blank',
                            'data' => [
                                // 'confirm' => 'Are you sure you want to send appraisal to peer 2?',
                                'params'=>[
                                    'appraisalNo'=> $_GET['Appraisal_No'],
                                    'employeeNo' => $_GET['Employee_No'],
                                ],
                                'method' => 'post',]
                        ]):'';
                        ?>

                    </div>

                   
                </div><!--end peer actions--->
                <div class="row">
                    <div class=" col-md-6 col-md-offset-3">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?=($model->EY_Appraisal_Status == 'Peer_1_Level' || $model->EY_Appraisal_Status == 'Peer_2_Level')?Html::a('<i class="fas fa-play"></i> Send Back to Supervisor',['sendbacktosupervisor','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-success ',
                            'title' => 'Send Peer Appraisal to Supervisor',
                            'data' => [
                                'confirm' => 'Are you sure you want to send Appraisal to Supervisor?',
                                'method' => 'post',]
                        ]) :'';
                        ?>
                    </div>
                </div>

            </div><!--end card body-->
         
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Appraisal : <?= $model->Appraisal_No?></h3>



                <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
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


               <?php $form = ActiveForm::begin(); ?>


               <div class="row">
                   <div class=" row col-md-12">
                       <div class="col-md-6">

                           <?= $form->field($model, 'Appraisal_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'MY_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'EY_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <p class="parent"><span>+</span>
                               <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                               <?= $form->field($model, 'Level_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                               <?= $form->field($model, 'Appraisal_No')->hiddenInput(['readonly'=> true, 'disabled'=>true])->label(false) ?>
                               <!---select peers-->

                               <?= $form->field($model, 'Peer_1_Employee_No')->dropDownList($peers,[
                               'prompt' => 'Select Peer 1 ',
                               'class' => 'form-control',
                               'onchange' => '
                               $.post($("input[name=absolute]").val()+"appraisal/setpeer1",{"Employee_No": $(this).val(),"Appraisal_No": $("#appraisalcard-appraisal_no").val() },function(data){
                               }).done(function(msg){
                               //location.reload();
                                    $(".modal").modal("show")
                                   .find(".modal-body")
                                   .html(msg.note);
                               },"json");
                               '
                               ,
                               ])
                               ?>


                               <?= $form->field($model, 'Peer_2_Employee_No')->dropDownList($peers,[
                                   'prompt' => 'Select Peer 1 ',
                                   'class' => 'form-control',
                                   'onchange' => '
                               $.post($("input[name=absolute]").val()+"appraisal/setpeer2",{"Employee_No": $(this).val(),"Appraisal_No": $("#appraisalcard-appraisal_no").val() },function(data){
                               }).done(function(msg){
                               //location.reload();
                                    $(".modal").modal("show")
                                   .find(".modal-body")
                                   .html(msg.note);
                               },"json");
                               '
                                   ,
                               ])
                               ?>

                               <!--End selecting peers -->


                               <?= $form->field($model, 'Job_Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Function_Team')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                               <?= $form->field($model, 'Created_By')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Appraisal_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           </p>


                       </div>
                       <div class="col-md-6">

                           <?= $form->field($model, 'MY_Appraisal_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'EY_Appraisal_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'EY_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <p class="parent"><span>+</span>

                               <?= $form->field($model, 'Supervisor_User_Id')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Employee_User_Id')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Supervisor_No')->hiddenInput(['readonly'=> true, 'disabled'=>true])->label(false) ?>


                               <?= ($model->EY_Appraisal_Status == 'eer_1_Level')?
                                   $form->field($model, 'Peer_1_Employee_Name')->dropDownList($peers,['prompt'=>'Select Peer 1'])
                                   :$form->field($model, 'Peer_1_Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= ($model->EY_Appraisal_Status == 'Peer_2_Level')?$form->field($model, 'Peer_2_Employee_Name')->dropDownList($peers,['prompt'=>'Select Peer 2','class'=>'peer'])
                               :$form->field($model, 'Peer_2_Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                               <?= $form->field($model, 'Goal_Setting_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Goal_Setting_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Goal_Setting_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                           </p>



                       </div>
                   </div>
               </div>



               <?php ActiveForm::end(); ?>



            </div>
        </div><!--end details card-->

        <?php if(($model->EY_Appraisal_Status <> 'Peer_1_Level') && ($model->EY_Appraisal_Status <> 'Peer_2_Level' )){ ?>
        <!--KRA CARD -->
        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Employee Appraisal KRA <?php $model->EY_Appraisal_Status ?></h4>
            </div>
            <div class="card-body">

                <?php if(property_exists($card->Employee_Appraisal_KRAs,'Employee_Appraisal_KRAs')){ ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Line No.</th>
                                <!--<th>Appraisal No</th>
                                <th>Employee No</th>-->
                                <th>KRA</th>
                                <th>Perfomance Level</th>
                                <th>Perfomance Comment</th>
                                <th>Appraisee Self Rating</th>
                                <th>Appraiser Rating</th>
                                <th>Agreed Rating</th>
                                <th>Rating Comments</th>
                                <th>Employee Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($card->Employee_Appraisal_KRAs->Employee_Appraisal_KRAs as $k){
                                if(!empty($k->Perfomance_Level) && $k->Perfomance_Level == 1){
                                    $pl = 'On Track';
                                }elseif(!empty($k->Perfomance_Level)&& $k->Perfomance_Level == 2){
                                    $pl = 'Off Track';
                                }else{
                                    $pl = 'Not Set';
                                }
                                ?>

                                <tr class="parent">

                                    <td><span>+</span></td>
                                    <!--<td><?/*= $k->Appraisal_No */?></td>
                                    <td><?/*= $k->Employee_No */?></td>-->
                                    <td><?= $k->KRA ?></td>
                                    <td><?= !empty($k->Perfomance_Level)?$pl: 'Not Set' ?></td>
                                    <td><?= !empty($k->Perfomance_Comment)?$k->Perfomance_Comment: 'Not Set' ?></td>
                                    <td><?= !empty($k->Appraisee_Self_Rating)?$k->Appraisee_Self_Rating: 'Not Set' ?></td>
                                    <td><?= !empty($k->Appraiser_Rating)?$k->Appraiser_Rating: 'Not Set' ?></td>
                                    <td><?= !empty($k->Agreed_Rating)?$k->Agreed_Rating: 'Not Set' ?></td>
                                    <td><?= !empty($k->Rating_Comments)?$k->Rating_Comments: 'Not Set' ?></td>
                                    <td><?= !empty($k->Employee_Comments)?$k->Employee_Comments: 'Not Set' ?></td>
                                    <td><?= ($model->EY_Appraisal_Status == 'Supervisor_Level' || $model->EY_Appraisal_Status == 'Agreement_Level')
                                            ?Html::a('<i class="fa fa-edit" title="Evaluate"></i>',['appraisalkra/update','Line_No'=> $k->Line_No,'Appraisal_No' => $k->Appraisal_No,'Employee_No' => $k->Employee_No ],['class' => ' evalkra btn btn-info btn-xs']):'' ?></td>
                                </tr>
                                <tr class="child">
                                    <td colspan="11" >
                                    <table class="table table-hover table-borderless table-info">
                                        <thead>
                                            <tr >
                                               <!-- <th>Line No</th>
                                                <th>KRA Line No</th>
                                                <th>Appraisal No</th>
                                                <th>Employee No</th>-->
                                                <th>Objective</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php if(is_array($model->getKPI($k->Line_No))){

                                        foreach($model->getKPI($k->Line_No) as $kpi):  ?>
                                            <tr>
                                                <!--<td><?/*= $kpi->Line_No */?></td>
                                                <td><?/*= $kpi->KRA_Line_No */?></td>
                                                <td><?/*= $kpi->Appraisal_No */?></td>
                                                <td><?/*= $kpi->Employee_No */?></td>-->
                                                <td><?= $kpi->Objective ?></td>
                                                <td><?= $kpi->Due_Date ?></td>
                                            </tr>
                                    <?php
                                            endforeach;
                                    }
                                    ?>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>


                <?php } ?>
            </div>
        </div>

        <?php } ?>
        <!--END KRA CARD -->

        <!--Training Plan Card -->
<?php if(($model->EY_Appraisal_Status <> 'Peer_1_Level') && ($model->EY_Appraisal_Status <> 'Peer_2_Level' )){ ?>
        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Training Plan</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?= Html::a('<i class="fas fa-plus"></i> Add New',['training-plan/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-primary add-trainingplan']) ?>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Line No.</th>
                        <th>Appraisal No</th>
                        <th>Employee No</th>
                        <th>Training Action</th>
                        <th>Delivery Method</th>
                        <th>Due Date</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>

                <?php if(property_exists($card->Training_Plan,'Training_Plan')){ ?>
                    <?php foreach($card->Training_Plan->Training_Plan as $training){ ?>
                        <tr>
                            <td><?= $training->Line_No ?></td>
                            <td><?= $training->Appraisal_No ?></td>
                            <td><?= $training->Employee_No ?></td>
                            <td><?= $training->Training_Action ?></td>
                            <td><?= $training->Delivery_Method ?></td>
                            <td><?= $training->Due_Date ?></td>
                            <td><?= Html::a('<i class="fas fa-edit"></i> ',['training-plan/update','Line_No'=> $training->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-trainingplan']) ?></td>
                        </tr>
                    <?php } ?>
                <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>

<?php } ?>
        <!--/Training Plan Card -->

        <!--Employee Appraisal  Competence --->

        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Employee Appraisal Competences</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td>
                        <!--<th>Appraisal No</th>
                        <th>Employee Code</th>-->
                        <td>Category</td>

                    </tr>
                    </thead>
                <?php if(property_exists($card->Employee_Appraisal_Competence,'Employee_Appraisal_Competence')){ ?>

                        <tbody>
                        <?php foreach($card->Employee_Appraisal_Competence->Employee_Appraisal_Competence as $comp){ ?>

                            <tr class="parent">
                                <td><span>+</span></td>
                                <!--<td><?/*= $comp->Appraisal_Code */?></td>
                                <td><?/*= $comp->Employee_Code */?></td>-->
                                <td><?= $comp->Category ?></td>

                            </tr>
                            <tr class="child">
                                <td colspan="11">
                                    <table class="table table-hover table-borderless table-info">
                                        <thead>
                                        <tr>
                                            <th colspan="14" style="text-align: center;">Employee Appraisal Behaviours</th>
                                        </tr>
                                        <tr>
                                            <!-- <th>Line No</th>-->
                                            <!-- <th>Employee No</th>-->
                                            <!-- <th>Appraisal Code</th>-->
                                            <td><b>Behaviour Name</b></td>
                                            <td><b>Applicable</b></td>
                                            <td width="7%"><b>Current Proficiency level</b></td>
                                            <td width="7%"><b>Expected Proficiency Level</b></td>
                                            <!--<td width="7%">Behaviour Description</td>-->
                                            <td width="4%"><b>Self Rating</b></td>
                                            <td width="10%"><b>Appraisee Remark</b></td>
                                            <td width="4%"><b>Appraiser Rating</b></td>
                                            <td width="4%"><b>Peer 1</b></td>
                                            <td width="10%"><b>Peer 1 Remark</b></td>
                                            <td width="4%"><b>Peer 2</b></td>
                                            <td width="10%"><b>Peer 2 Remark</b></td>
                                            <td width="7%"><b>Agreed Rating</b></td>
                                            <td width="7%"><b>Overall Remarks</b></td>
                                            <td><b>Action</b></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($model->getAppraisalbehaviours($comp->Line_No))){

                                            foreach($model->getAppraisalbehaviours($comp->Line_No) as $be):  ?>
                                                <tr>
                                                    <!--<td><?/*= $be->Line_No */?></td>-->
                                                    <!--<td><?/*= $be->Employee_No */?></td>-->
                                                    <!-- <td><?/*= $be->Appraisal_Code */?></td>-->
                                                    <td><?= $be->Behaviour_Name ?></td>
                                                    <td><?= Html::checkbox('Applicable',$be->Applicable,['disabled' => true]) ?></td>
                                                    <td><?= !empty($be->Current_Proficiency_Level)?$be->Current_Proficiency_Level:'' ?></td>
                                                    <td><?= !empty($be->Expected_Proficiency_Level)?$be->Expected_Proficiency_Level:'' ?></td>
                                                    <!-- <td><?/*= !empty($be->Behaviour_Description)?$be->Behaviour_Description:'' */?></td>-->
                                                    <td><?= !empty($be->Self_Rating)?$be->Self_Rating:'' ?></td>
                                                    <td><?= !empty($be->Appraisee_Remark)?$be->Appraisee_Remark:'' ?></td>
                                                    <td><?= !empty($be->Appraiser_Rating)?$be->Appraiser_Rating:'' ?></td>
                                                    <td><?= !empty($be->Peer_1)?$be->Peer_1:'' ?></td>
                                                    <td><?= !empty($be->Peer_1_Remark)?$be->Peer_1_Remark:'' ?></td>
                                                    <td><?= !empty($be->Peer_2)?$be->Peer_2:'' ?></td>
                                                    <td><?= !empty($be->Peer_2_Remark)?$be->Peer_2_Remark:'' ?></td>
                                                    <td><?= !empty($be->Agreed_Rating)?$be->Agreed_Rating:'' ?></td>
                                                    <td><?= !empty($be->Overall_Remarks)?$be->Overall_Remarks:'' ?></td>
                                                    <td><?= ($be->Applicable)?Html::a('<i title="Evaluate Behaviour" class="fa fa-edit"></i>',['employeeappraisalbehaviour/update','Employee_No'=>$be->Employee_No,'Line_No'=> $be->Line_No,'Appraisal_No' => $be->Appraisal_Code ],['class' => ' evalbehaviour btn btn-info btn-xs']):'' ?></td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>


                <?php } ?>
            </div>
        </div>

        <!--/Employee Appraisal  Competence --->


        <!--Learning Assessment Card -->
<?php if(($model->EY_Appraisal_Status <> 'Peer_1_Level') && ($model->EY_Appraisal_Status <> 'Peer_2_Level' )){ ?>
        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Learning Assessment - Competence</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?= Html::a('<i class="fas fa-plus"></i> Add New',['learningassessment/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-primary add-learning-assessment']) ?>

            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Line No.</th>
                        <!--<th>Employee_No</th>-->
                        <th>Appraisal_No</th>
                        <th>Training Action</th>
                        <th>Due_Date</th>
                        <th>Learning_Hours</th>
                        <th>Status_Mid_Year</th>
                        <th>Status_End_Year</th>
                        <th>Comments</th>
                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php if(property_exists($card->Learning_Assesment_Competenc,'Learning_Assesment_Competenc')){ ?>
                        <?php foreach($card->Learning_Assesment_Competenc->Learning_Assesment_Competenc as $asses){ ?>
                            <tr>
                                <td><?= $asses->Line_No ?></td>
                               <!-- <td><?/*= $asses->Employee_No */?></td>-->
                                <td><?= $asses->Appraisal_No ?></td>
                                <td><?= $asses->Training_Action ?></td>
                                <td><?= $asses->Due_Date ?></td>
                                <td><?= $asses->Learning_Hours ?></td>
                                <td><?= isset($asses->Status_Mid_Year)?$asses->Status_Mid_Year:'' ?></td>
                                <td><?= isset($asses->Status_End_Year)?$asses->Status_End_Year:'' ?></td>
                                <td><?= isset($asses->Comments)?$asses->Comments:'' ?></td>
                                <td><?= Html::a('<i class="fas fa-edit"></i> ',['learningassessment/update','Line_No'=> $asses->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning']) ?></td>
                            </tr>
                        <?php } ?>
                    <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!--/Learning Assessment  Card -->
        <!----Career Development Plan-->

        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Career Development Plan</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?= Html::a('<i class="fas fa-plus"></i> Add New',['careerdevelopmentplan/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' =>$model->Employee_No ],
                    [
                        'class' => 'btn btn-xs btn-primary add-cdp',

                    ]) ?>

            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Line No.</th>
                        <th>Employee No</th>
                        <th>Appraisal No</th>
                        <th>Career Development Goal</th>
                        <th>Estimated Start Date</th>
                        <th>Estimate End Date</th>
                        <th>Duration</th>

                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php if(property_exists($card->Career_Development_Plan,'Career_Development_Plan')){ ?>
                        <?php foreach($card->Career_Development_Plan->Career_Development_Plan as $cdp){ ?>
                            <tr class="parent">
                                <td><span>+</span></td>
                                <td><?= $cdp->Line_No ?></td>
                                <td><?= $cdp->Employee_No ?></td>
                                <td><?= $cdp->Appraisal_No ?></td>
                                <td><?= $cdp->Career_Development_Goal ?></td>
                                <td><?= $cdp->Estimate_Start_Date ?></td>
                                <td><?= $cdp->Estimate_End_Date ?></td>
                                <td><?= $cdp->Duration ?></td>

                                <td>
                                    <?= Html::a('<i class="fas fa-edit"></i> ',['careerdevelopmentplan/update','Line_No'=> $cdp->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning']) ?>
                                    <?= Html::a('<i class="fas fa-plus-square"></i> ',['careerdevelopmentstrength/create','Goal_Line_No'=> $cdp->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary add-cds', 'title'=>'Add Career Development Strength']) ?>
                                </td>
                            </tr>
                            <!--Start displaying children-->
                            <tr class="child">
                                <td colspan="11" >
                                    <table class="table table-hover table-borderless table-info">
                                        <thead>
                                        <tr >
                                            <th>Line No</th>
                                            <th>Appraisal No</th>
                                            <th>Employee No</th>
                                            <th>Strength</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($model->getCareerdevelopmentstrengths($cdp->Line_No))){

                                            foreach($model->getCareerdevelopmentstrengths($cdp->Line_No) as $cds):  ?>
                                                <tr>
                                                    <td><?= $cds->Line_No ?></td>
                                                    <td><?= $cds->Appraisal_No ?></td>
                                                    <td><?= $cds->Employee_No ?></td>
                                                    <td><?= $cds->Strength ?></td>
                                                    <td>
                                                        <?= Html::a('<i class="fas fa-edit"></i> ',['careerdevelopmentstrength/update','Line_No'=> $cds->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning','title' => 'Update Strength']) ?>
                                                        <?= Html::a('<i class="fas fa-trash"></i> ',['careerdevelopmentstrength/delete','Key'=> $cds->Key],['class' => 'btn btn-xs btn-outline-primary delete', 'title'=>'Delete Career Development Strength']) ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!--end displaying children-->





                        <?php } ?>
                    <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--/Career Development Plan-->

        <!---Areas_of_Further_Development-->


        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Areas of Further Development</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?= Html::a('<i class="fas fa-plus"></i> Add New',['furtherdevelopmentarea/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-primary add-fda']) ?>

            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Line No.</th>
                        <th>Employee No</th>
                        <th>Appraisal No</th>
                        <th>Weakness</th>
                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php if(property_exists($card->Areas_of_Further_Development,'Areas_of_Further_Development')){ ?>
                        <?php foreach($card->Areas_of_Further_Development->Areas_of_Further_Development as $fda){ ?>
                            <tr class="parent">
                                <td><span>+</span></td>
                                <td><?= $fda->Line_No ?></td>
                                <td><?= $fda->Employee_No ?></td>
                                <td><?= $fda->Appraisal_No ?></td>
                                <td><?= $fda->Weakness ?></td>

                                <td>
                                    <?= Html::a('<i class="fas fa-edit"></i> ',['furtherdevelopmentarea/update','Line_No'=> $fda->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning']) ?>
                                    <?= Html::a('<i class="fas fa-plus-square"></i> ',['weeknessdevelopmentplan/create','Wekaness_Line_No'=> $fda->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary add-wdp','Add a Weakness Development Plan.']) ?>
                                </td>
                            </tr>
                            <!--Start displaying children-->
                            <tr class="child">
                                <td colspan="11" >
                                    <table class="table table-hover table-borderless table-info">
                                        <thead>
                                        <tr >
                                            <th>Line No</th>
                                            <th>Appraisal No</th>
                                            <th>Employee No</th>
                                            <th>Development Plan</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($model->getWeaknessdevelopmentplan($fda->Line_No))){

                                            foreach($model->getWeaknessdevelopmentplan($fda->Line_No) as $wdp):  ?>
                                                <tr>
                                                    <td><?= $wdp->Line_No ?></td>
                                                    <td><?= $wdp->Appraisal_No ?></td>
                                                    <td><?= $wdp->Employee_No ?></td>
                                                    <td><?= $wdp->Development_Plan ?></td>
                                                    <td>
                                                        <?= Html::a('<i class="fas fa-edit"></i> ',['weeknessdevelopmentplan/update','Line_No'=> $wdp->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning','title'=> 'Update Weakness Development Plan']) ?>
                                                        <?= Html::a('<i class="fas fa-trash"></i> ',['weeknessdevelopmentplan/delete','Key'=> $wdp->Key],['class' => 'btn btn-xs btn-outline-primary delete', 'title'=>'Delete Weakness Development Plan']) ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!--end displaying children-->
                        <?php } ?>
                    <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--/-Areas_of_Further_Development-->

<?php }  ?>

    </div>
</div>

<!--My Bs Modal template  --->

<div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Performance Appraisal</h4>
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

<!-----end modal----------->

<!-- GOALS REJECTION COMMENT FORM--->
    <div id="rejform" style="display: none">

        <?= Html::beginForm(['appraisal/reject'],'post',['id'=>'reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>

<!--End gOAL REJECTION comment form-->



<!---mID YEAR COMMENT REJECTION FORM -->

    <div id="myrejform" style="display: none">

        <?= Html::beginForm(['appraisal/rejectmy'],'post',['id'=>'my-reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Mid-Year Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>


<!---END  mID YEAR COMMENT REJECTION FORM -->


    <!---mID YEAR COMMENT REJECTION FORM -->

    <div id="eyrejform" style="display: none">

        <?= Html::beginForm(['appraisal/rejectey'],'post',['id'=>'ey-reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'End-Year Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>


        <?= Html::submitButton('Reject EY Appraisal',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>


    <!---END  mID YEAR COMMENT REJECTION FORM -->
    <input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php

$script = <<<JS

    $(function(){
      
        
      
    
    /*Evaluate KRA*/
        $('.evalkra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
      //Add a training plan
    
     $('.add-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update a training plan
    
     $('.update-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Update Learning Assessment*/
      
      $('.update-learning').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
      
    
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    /*Parent-Children accordion*/ 
    
    $('tr.parent').find('span').text('+');
    $('tr.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('tr.parent').nextUntil('tr.parent').slideUp(1, function(){});    
    $('tr.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('tr.parent').slideToggle(100, function(){});
     });
    
    /*Divs parenting*/
    
     $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });
    
    //select2
    
    $('.peer').select2();
    
    //Pop up the goals Rejection comment form Modal
    
    $('.reject').on('click', function(e){
        e.preventDefault();
        const form = $('#rejform').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('.modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#reject-form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });//End click event on  GOals rejection-button click
    
    
    
    
    //Click event on M.Y aAppraisal rejection button: modal form
    
    
    $('.rejectmy').on('click', function(e){
        e.preventDefault();
        const form = $('#myrejform').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('.modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#my-reject-form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });
    
    
    
    //End Click event on M.Y aAppraisal rejection button
    
    
    //Rejecting end year Appraisal comment
    
    $('.rejectey').on('click', function(e){
        e.preventDefault();
        const form = $('#eyrejform').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('.modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#ey-reject-form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });
    
    //End Rejecting end year Appraisal comment
    
    //select 2
    
    $('#appraisalcard-peer_1_employee_no').select2();
    $('#appraisalcard-peer_2_employee_no').select2();
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

