<?php

/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS';
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
                                 src="../../dist/img/user4-128x128.jpg"
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
                        </ul>

                        <a href="mailto:<?= $supervisor->Company_E_Mail ?>" class="btn btn-primary btn-block"><b>Email Supervisor</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Job Title</strong>

                        <p class="text-muted">
                            <?= !empty($employee->Job_Title)?$employee->Job_Title:'' ?>
                        </p>

                        <hr>

                        <strong><i class="fas fa-person-booth mr-1"></i> Gender</strong>

                        <p class="text-muted"><?= !empty($employee->Gender)?$employee->Gender:'' ?> </p>

                        <hr>

                        <strong><i class="fas fa-birthday-cake mr-1"></i> Age</strong>

                        <p class="text-muted">
                            <?= !empty($employee->DAge)?$employee->DAge:''?>
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> Date of Join:</strong>

                        <p class="text-muted"><?= !empty($employee->Date_Of_Join)?$employee->Date_Of_Join:'' ?></p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->


            <!--start col ---9-->



            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <h3>General Information</h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover table-borderless">

                            <tbody>
                                <tr>
                                    <td>No.</td><td class="bg-gray"><?= $employee->No?></td>
                                    <td>User ID.</td><td class="bg-gray"><?= $employee->User_ID ?></td>
                                </tr>

                                <tr>
                                    <td>First Name: </td><td class="bg-gray"><?= $employee->First_Name ?></td>
                                    <td>Last Name</td><td class="bg-gray"><?= $employee->Last_Name ?></td>
                                </tr>

                                <tr>
                                    <td>ID Number: </td><td class="bg-gray"><?= $employee->First_Name ?></td>
                                    <td>Passport Number</td><td class="bg-gray"><?= $employee->Last_Name ?></td>
                                </tr>

                                <tr>
                                    <td>Supervisor Name: </td><td class="bg-gray"><?= $employee->Supervisor_Name ?></td>
                                    <td>Citizenship</td><td class="bg-gray"><?= !empty($employee->Citizenship)? $employee->Citizenship: '' ?></td>
                                </tr>
                            </tbody>



                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
