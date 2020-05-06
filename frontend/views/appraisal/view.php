<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Performance Appraisal - '.$model->Appraisal_No;
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal View', 'url' => ['view','Employee_No'=> $model->Employee_No,'Appraisal_No' => $model->Appraisal_No]];
/** Status Sessions */

Yii::$app->session->set('Goal_Setting_Status',$model->Goal_Setting_Status);
Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-info">
            <div class="card-header">
                <h3>Performance Appraisal Card </h3>
            </div>
            
            <div class="card-body info-box">

                <div class="row">
                <?php if($model->Goal_Setting_Status == 'New'): ?>

                    <div class="col-md-4">

                        <?= Html::a('<i class="fas fa-forward"></i> submit',['submit','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],['class' => 'btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to submit this appraisal?',
                                'method' => 'post',
                            ],
                            'title' => 'Submit Goals for Approval'

                        ]) ?>
                    </div>

                <?php endif; ?>
                <?php if($model->Goal_Setting_Status == 'Approved' && $model->MY_Appraisal_Status == 'Appraisee_Level'): ?>

                    <div class="col-md-4">
                        <?= Html::a('<i class="fas fa-forward"></i> MY Appraisal',['submitmy','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-app bg-info submitforapproval',
                            'title' => 'Submit Your Mid Year Appraisal for Approval',
                            'data' => [
                                'confirm' => 'Are you sure you want to submit Your Mid Year Appraisal?',
                                'method' => 'post',
                            ]
                        ]) ?>
                    </div>

                <?php endif; ?>
                <?php if($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Appraisee_Level'): ?>

                    <div class="col-md-4">
                    <?= Html::a('<i class="fas fa-forward"></i> submit EY',['submitey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-primary',
                                'title' => 'Submit End Year Appraisal for Approval',
                                'data' => [
                                'confirm' => 'Are you sure you want to submit End Year Appraisal?',
                                'method' => 'post',
                            ]
                        ]) ?>
                    </div>

                <?php endif; ?>

                </div>

            </div>
           
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


                               <?= $form->field($model, 'Peer_1_Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Peer_2_Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


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

        <!--KRA CARD -->
        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Employee Appraisal KRA</h4>
            </div>
            <div class="card-body">

                <?php if(property_exists($card->Employee_Appraisal_KRAs,'Employee_Appraisal_KRAs')){ ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Line No.</th>
                                <th>Appraisal No</th>
                                <th>Employee No</th>
                                <th>KRA</th>
                                <th>Perfomance Level</th>
                                <th>Perfomance Comment</th>
                                <th>Appraisee Self Rating</th>
                                <th>Appraiser Rating</th>
                                <th>Agreed Rating</th>
                                <th>Rating Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($card->Employee_Appraisal_KRAs->Employee_Appraisal_KRAs as $k){ ?>

                                <tr class="parent">

                                    <td><span>+</span></td>
                                    <td><?= $k->Appraisal_No ?></td>
                                    <td><?= $k->Employee_No ?></td>
                                    <td><?= $k->KRA ?></td>
                                    <td><?= !empty($k->Perfomance_Level)?$k->Perfomance_Level: 'Not Set' ?></td>
                                    <td><?= !empty($k->Perfomance_Comment)?$k->Perfomance_Comment: 'Not Set' ?></td>
                                    <td><?= !empty($k->Appraisee_Self_Rating)?$k->Appraisee_Self_Rating: 'Not Set' ?></td>
                                    <td><?= !empty($k->Appraiser_Rating)?$k->Appraiser_Rating: 'Not Set' ?></td>
                                    <td><?= !empty($k->Agreed_Rating)?$k->Agreed_Rating: 'Not Set' ?></td>
                                    <td><?= !empty($k->Rating_Comments)?$k->Rating_Comments: 'Not Set' ?></td>
                                    <td><?= Html::a('Evaluate',['appraisalkra/update','Line_No'=> $k->Line_No,'Appraisal_No' => $k->Appraisal_No,'Employee_No' => $k->Employee_No ],['class' => ' evalkra btn btn-info btn-xs'])?></td>
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
                                                <th> <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fas fa-plus"></i>',['employeeappraisalkpi/create','Appraisal_No'=> $k->Appraisal_No,'Employee_No' => $k->Employee_No,'KRA_Line_No' => $k->Line_No],['class' => 'btn btn-xs btn-success add-objective','title' => 'Add Objective / KPI']):'' ?>
                                                </th>
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
                                                <td>
                                                    <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fas fa-edit"></i> ',['employeeappraisalkpi/update','Appraisal_No'=> $kpi->Appraisal_No,'Employee_No' => $kpi->Employee_No,'KRA_Line_No' => $kpi->KRA_Line_No,'Line_No' => $kpi->Line_No],['class' => 'btn btn-xs btn-primary add-objective', 'title' => 'Update Objective /KPI']):'' ?>
                                                    <?= ($model->Goal_Setting_Status == 'New')? Html::a('<i class="fa fa-trash"></i>',['employeeappraisalkpi/delete','Key' => $kpi->Key],['class'=> 'btn btn-xs btn-danger delete-objective','title' => 'Delete Objective']):'' ?>

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

                            <?php } ?>
                        </tbody>
                    </table>


                <?php } ?>
            </div>
        </div>

        <!--ENF KRA CARD -->

        <?php //if($model->isSupervisor($model->Employee_User_Id,$model->Supervisor_User_Id)){ ?>
        <!--Training Plan Card -->
        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Training Plan </h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

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
        <!--/Training Plan Card -->
        <?php //}  ?>
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
                                             <th>Behaviour Name</th>
                                            <th>Applicable</th>
                                            <th>Current Proficiency level</th>
                                            <th>Expected Proficiency Level</th>
                                            <th>Behaviour Description</th>
                                            <th>Self Rating</th>
                                            <th>Appraiser Rating</th>
                                            <th>Peer 1</th>
                                            <th>Peer 2</th>
                                            <th>Agreed Rating</th>
                                            <th>Overall Remarks</th>
                                            <th>Action</th>
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
                                                    <td><?= !empty($be->Behaviour_Description)?$be->Behaviour_Description:'' ?></td>
                                                    <td><?= !empty($be->Self_Rating)?$be->Self_Rating:'' ?></td>
                                                    <td><?= !empty($be->Appraiser_Rating)?$be->Appraiser_Rating:'' ?></td>
                                                    <td><?= !empty($be->Peer_1)?$be->Peer_1:'' ?></td>
                                                    <td><?= !empty($be->Peer_2)?$be->Peer_2:'' ?></td>
                                                    <td><?= !empty($be->Agreed_Rating)?$be->Agreed_Rating:'' ?></td>
                                                    <td><?= !empty($be->Overall_Remarks)?$be->Overall_Remarks:'' ?></td>
                                                    <td><?= Html::a('Evaluate',['employeeappraisalbehaviour/update','Employee_No'=>$be->Employee_No,'Line_No'=> $be->Line_No,'Appraisal_No' => $be->Appraisal_Code ],['class' => ' evalbehaviour btn btn-info btn-xs'])?></td>
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

<?php if($model->EY_Appraisal_Status !== 'Agreement_Level'){ ?>
        <!--Learning Assessment Card -->
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
                                <td><?= $asses->Status_Mid_Year ?></td>
                                <td><?= $asses->Status_End_Year ?></td>
                                <td><?= $asses->Comments ?></td>
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


<?php

$script = <<<JS

    $(function(){
      
        
     /*Deleting Records*/
     
     $('.delete, .delete-objective').on('click',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $.get(url).done(function(msg){
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
      
    
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
      
      /*Update Learning Assessment and Add/update employee objectives/kpis */
      
      $('.update-learning, .add-objective').on('click',function(e){
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
    
        //Add Career Development Plan
        
        $('.add-cdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
           
            
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         /*End Add Weakness Development Plan*/
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

