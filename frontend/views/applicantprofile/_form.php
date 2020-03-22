<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
//$this->title = 'AAS - Employee Profile'
?>



<!--THE STEPS THING--->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Applicant : <?= $model->No.' - '. $model->First_Name. ' '. $model->Last_Name?></h2>
            </div>
        </div>
               <?= $this->render('_steps') ?>
    </div>
</div>

<!--END THE STEPS THING--->


<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Personal info for Profile: <?= Yii::$app->session->has('ProfileID')? Yii::$app->session->get('ProfileID'): '' ?></h3>
            </div>
            <div class="card-body">

                 

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'No')->textInput(['readonly'=> true,'disabled' => true]) ?>
                            <?= $form->field($model, 'First_Name')->textInput() ?>
                            <?= $form->field($model, 'Middle_Name')->textInput() ?>
                            <?= $form->field($model, 'Last_Name')->textInput() ?>
                            <?= $form->field($model, 'Initials')->textInput() ?>

                            <?= $form->field($model, 'Full_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Picture')->fileInput() ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'ID_Number')->textInput() ?>
                            <?= $form->field($model, 'Gender')->textInput() ?>
                            <?= $form->field($model, 'Date_Of_Birth')->textInput(['type'=> 'date']) ?>
                            <?= $form->field($model, 'Age')->textInput(['type'=> 'Number','readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Known_As')->textInput() ?>
                            <?= $form->field($model, 'Marital_Status')->textInput() ?>
                            <?= $form->field($model, 'Ethnic_Origin')->dropDownList(['African' => 'African', 'Indian' => 'Indian', 'White' => 'White', 'Coloured' => 'Coloured','usa' => 'American' ], ['prompt' => 'Select Ethnic Origin..']) ?>
                            <?= $form->field($model, 'Disabled')->dropDownList(['No' => 'NO', 'Yes' => 'YES'],['prompt' => 'Select Disability Status']) ?>
                            <?= $form->field($model, 'Citizenship')->dropDownList($countries, ['prompt' => 'Select Citizenship']) ?>
                            <?= $form->field($model, 'Passport_Number')->textInput() ?>




                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Communication</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Postal_Address')->textInput(['placeholder' => 'Postal Address']) ?>
                            <?= $form->field($model, 'Residential_Address')->textInput(['placeholder'=> 'Residential Address']) ?>
                            <?= $form->field($model, 'City')->textInput(['placeholder'=> 'Your City']) ?>
                            <?= $form->field($model, 'Post_Code')->textInput(['placeholder '=> 'Postal Code']) ?>
                            <?= $form->field($model, 'County')->textInput(['placeholder '=> 'Your County']) ?>
                            <?= $form->field($model, 'Home_Phone_Number')->textInput(['placeholder '=> 'Home Phone Number']) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Cellular_Phone_Number')->textInput(['placeholder'=> 'Mobile Phone Number']) ?>
                            <?= $form->field($model, 'Work_Phone_Number')->textInput(['placeholder'=> 'Work Phone Number']) ?>
                            <?= $form->field($model, 'E_Mail')->textInput(['placeholder'=> 'E-mail Address', 'type' => 'email']) ?>
                            <?= $form->field($model, 'Country_Code')->dropDownList($countries, ['prompt' => 'Select Country of Origin..']) ?>

                            <?= $form->field($model, 'Location_Division_Code')->textInput(['placeholder'=> 'Locality']) ?>
                            <?= $form->field($model, 'Company_E_Mail')->textInput(['placeholder'=> 'Official E-Mail']) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Other Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Union_Member_x003F_')->checkbox() ?>
                            <?= $form->field($model, 'NSSF_No')->textInput() ?>
                            <?= $form->field($model, 'NHIF_No')->textInput() ?>
                            <?= $form->field($model, 'HELB_No')->textInput() ?>



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model,'Key')->hiddenInput()->label('...') ?>
                            <?= $form->field($model, 'Tribe')->textInput() ?>
                            <?= $form->field($model, 'Religion')->dropDownList($religion,['prompt' => 'Select Religion']) ?>
                            <?= $form->field($model, 'Post_Office_No')->textInput() ?>


                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>







            </div>
        </div>











        <?php ActiveForm::end(); ?>
    </div>
</div>
