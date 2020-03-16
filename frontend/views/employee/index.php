<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'AAS - Employee Profile'
?>
<h2 class="title">Employee : <?= $model->No.' - '. $model->First_Name. ' '. $model->Last_Name?></h2>

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
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['action'=> ['leave/create']]); ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">General Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'First_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Middle_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Last_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'ID_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Passport_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Citizenship')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Responsibility_Center')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'User_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Supervisor_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Supervisor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Last_Date_Modified')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Last_Date_Modified_By')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Personal Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Gender')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Marital_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Religion')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'First_Language_R_W_S')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'First_Language_Read')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'First_Language_Write')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'First_Language_Speak')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Second_Language_R_W_S')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Second_Language_Read')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Second_Language_Write')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Second_Language_Speak')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Additional_Language')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Vehicle_Registration_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Number_Of_Dependants')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Disabled')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Important Dates</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Date_Of_Birth')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'DAge')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_Of_Join')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'DService')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Probation_Duration')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'End_Of_Probation_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Retirement_date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Pension_Scheme_Join_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Dretire')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'DPension')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Medical_Scheme_Join_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'DMedical')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Wedding_Anniversary')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Job Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Job_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Job_Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Salary_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Posting_Group')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Professional_Body')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Effective_From_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Expiry_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Terms of Service</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Contract_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Contract_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Notice_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Send_Alert_to')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Information</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'PIN_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'NSSF_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'NHIF_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'No_Of_Bank_A_Cs')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Leave Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Reimbursed_Leave_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Allocated_Leave_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Total_Leave_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Total_Leave_Taken')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Acrued_Leave_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Leave_Bal')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Cash_Leave_Earned')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Cash_per_Leave_Day')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Separation Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Date_Of_Leaving_the_Company')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Termination_Grounds')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Exit_Interview_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Exit_Interview_Done_by')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Activate')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
