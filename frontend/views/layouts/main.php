<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 2:39 PM
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AdminlteAsset;
use common\widgets\Alert;

AdminlteAsset::register($this);

$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);
$employee = (!Yii::$app->user->isGuest)?Yii::$app->user->identity->employee[0]:[];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://ciskenya.co.ke/wp-content/files/2018/07/favicon-150x150.png" sizes="32x32" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link sidebar-toggle-btn" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <?php if(!Yii::$app->user->isGuest): ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= $absoluteUrl ?>site" class="nav-link">Home</a>
                </li>
                <?php endif; ?>
                <!--<li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>-->
            </ul>

            <!-- SEARCH FORM -->
            <!--<form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>-->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                   <!-- <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>-->
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="<?= $webroot ?>/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-th-large"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!--<span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>-->






                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->isGuest)? Html::a('<i class="fas fa-sign-in-alt "></i> Signup','/site/signup/',['class'=> 'dropdown-item']): ''; ?>

                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->isGuest)? Html::a('<i class="fas fa-lock-open"></i> Login','/site/login/',['class'=> 'dropdown-item']): ''; ?>

                        <div class="dropdown-divider"></div>

                        <div class="dropdown-divider"></div>

                        <?= (!Yii::$app->user->isGuest)? Html::a('<i class="fas fa-sign-out-alt"></i> Logout','/site/logout/',['class'=> 'dropdown-item']):''; ?>

                        <div class="dropdown-divider"></div>

                        <?= Html::a('<i class="fas fa-user"></i> Profile',['./employee'],['class'=> 'dropdown-item']); ?>

                        <div class="dropdown-divider"></div>

                        <?= Html::a('<i class="fas fa-user"></i> Clearance form',['site/clearanceform'],['class'=> 'dropdown-item']); ?>

                    </div>
                </li>
               <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="false" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>-->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= $absoluteUrl ?>site" class="brand-link navbar-light logo-switch " >
                <img src="<?= $webroot ?>/images/30 - Logo1.png" alt="AAS Logo" class="brand-image-xs logo-xl img-responsive elevation-0 ml-4  d-flex flex-column align-content-center"
                     style="opacity: 1; transform: scale(1.4); ">
               <!-- <span class="brand-text font-weight-light">AAS</span>-->
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $webroot ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= $absoluteUrl ?>employee/" class="d-block"><?= (!Yii::$app->user->isGuest)? ucwords($employee->First_Name.' '.$employee->Last_Name): ''?></a>
                    </div>
                </div>-->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->


<!--Approval Management -->
                        <?php if( !Yii::$app->user->isGuest &&   Yii::$app->user->identity->isSupervisor()): ?>
                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('approvals')?'menu-open':'' ?>">

                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('approvals')?'active':'' ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Approval Management
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>approvals" class="nav-link <?= Yii::$app->recruitment->currentaction('approvals','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Approval Requests</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <?php endif; ?>
<!--end Aprroval Management-->


                        <li class="nav-item has-treeview  <?= Yii::$app->recruitment->currentCtrl('leave')?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('leave')?'active':'' ?>">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>
                                    Leave Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/create?create=1" class="nav-link <?= Yii::$app->recruitment->currentaction('leave','create')?'active':'' ?> ">
                                        <i class="fa fa-running nav-icon"></i>
                                        <p>New Leave Application</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/" class="nav-link <?= Yii::$app->recruitment->currentaction('leave','index')?'active':'' ?>">
                                        <i class="fa fa-door-open nav-icon"></i>
                                        <p>Leave List</p>
                                    </a>
                                </li>

                                <!--<li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/leavebalances" class="nav-link <?= Yii::$app->recruitment->currentaction('leave','leavebalances')?'active':'' ?>">
                                        <i class="fa fa-balance-scale nav-icon"></i>
                                        <p>Leave Balances</p>
                                    </a>
                                </li>-->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/reportview" class="nav-link <?= Yii::$app->recruitment->currentaction('leave','reportview')?'active':'' ?>">
                                        <i class="fa fa-file-pdf nav-icon"></i>
                                        <p>Leave History Report</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leavestatement/index" class="nav-link <?= Yii::$app->recruitment->currentaction('leavestatement','index')?'active':'' ?>">
                                        <i class="fa fa-file-pdf nav-icon"></i>
                                        <p>Leave Statement  Report</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leaverecall/create/?create=1" class="nav-link <?= Yii::$app->recruitment->currentaction('leaverecall','create')?'active':'' ?>">
                                        <i class="fa fa-recycle nav-icon"></i>
                                        <p>Recall Leave</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leaverecall/index" class="nav-link <?= Yii::$app->recruitment->currentaction('leaverecall','index')?'active':'' ?>">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Recall Leave List</p>
                                    </a>
                                </li>

                            </ul>
                        </li>



                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(Yii::$app->params['profileControllers'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('recruitment')?'active':'' ?>">
                                <i class="nav-icon fas fa-briefcase " ></i>
                                <p>
                                    Employee Recruitment
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>recruitment/vacancies" class="nav-link <?= Yii::$app->recruitment->currentaction('recruitment','vacancies')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Job Vacancies </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>recruitment/externalvacancies" class="nav-link <?= Yii::$app->recruitment->currentaction('recruitment','externalvacancies')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>External Job Vacancies </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>applicantprofile/create" class="nav-link <?= Yii::$app->recruitment->currentaction('applicantprofile',['create','index'])?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Applicant Profile</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>employeerequisition" class="nav-link <?= Yii::$app->recruitment->currentaction('employeerequisition','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>HR Requsitions List</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>employeerequisition/create?create=1" class="nav-link <?= Yii::$app->recruitment->currentaction('employeerequisition','create')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Create HR Requsitions</p>
                                    </a>
                                </li>





                            </ul>
                        </li>

                        <!--Payroll reports -->
                         <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['payslip','p9'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['payslip','p9'])?'active':'' ?>">
                                <i class="nav-icon fa fa-file-invoice-dollar"></i>
                                <p>
                                    Payroll Reports
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>payslip" class="nav-link <?= Yii::$app->recruitment->currentaction('payslip','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Generate Payslip</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>p9" class="nav-link <?= Yii::$app->recruitment->currentaction('p9','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Generate P9 </p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <!--payroll reports-->









                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('appraisal')?'menu-open':'' ?>">
                            <a href="#" title="Performance Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl('appraisal')?'active':'' ?>">
                                <i class="nav-icon fa fa-balance-scale"></i>
                                <p>
                                    Perfomance Mgt.
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Goal Setting</p>
                                    </a>
                                </li>


                     <?php if(Yii::$app->user->identity->isAppraisalSupervisorDesignate()){ ?>


                                <?php if( !Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>
                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/submitted" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','submitted')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>Submitted Goals List </p>
                                                </a>
                                            </li>
                                <?php endif; ?>
                                           <!-- <li class="nav-item">
                                                <a href="<?/*= $absoluteUrl */?>appraisal/approvedappraisals" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','approvedappraisals')?'active':'' */?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>Approved Goals </p>
                                                </a>
                                            </li>-->
                                <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>
                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/superapprovedappraisals" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','superapprovedappraisals')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>Approved (Supervisor) </p>
                                                </a>
                                            </li>
                                <?php endif; ?>

                                <!--Mid Year Appraisals-->
                                <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('appraisal')?'menu-open':'' ?>">
                                    <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('appraisal')?'active':'' ?>">
                                        <i class="nav-icon fa fa-balance-scale"></i>
                                        <p>
                                            Mid Year Appraisals
                                            <i class="fas fa-angle-left right"></i>
                                            <!--<span class="badge badge-info right">6</span>-->
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview"><!--Mid Year Appraisals Menu-->

                                       <!-- <li class="nav-item">
                                            <a href="<?/*= $absoluteUrl */?>appraisal/myappraiseelist" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','myappraiseelist')?'active':'' */?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>M-Y Appraisal (Appraisee) </p>
                                            </a>
                                        </li>-->

                                        <?php if( !Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>

                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/mysupervisorlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','mysupervisorlist')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>M-Y Appraisal (Supervisor) </p>
                                                </a>
                                            </li>

                                        <?php endif; ?>

                                       <!-- <li class="nav-item">
                                            <a href="<?/*= $absoluteUrl */?>appraisal/myapprovedappraiseelist" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','myapprovedappraiseelist')?'active':'' */?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>M-Y Approved (Appraisee) </p>
                                            </a>
                                        </li>-->

                                        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>

                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/myapprovedsupervisorlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','myapprovedsupervisorlist')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>M-Y Approved (Supervisor) </p>
                                                </a>
                                            </li>

                                        <?php endif; ?>




                                    </ul><!--End Mid Year Appraisals menu list-->


                                </li><!--End Mid Year Child Menu list-->

                                <!--end Year Appraisals -->
                                <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('appraisal')?'menu-open':'' ?>">
                                    <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('appraisal')?'active':'' ?>">
                                        <i class="nav-icon fa fa-balance-scale"></i>
                                        <p>
                                            End Year Appraisals
                                            <i class="fas fa-angle-left right"></i>
                                            <!--<span class="badge badge-info right">6</span>-->
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview"><!--Mid Year Appraisals Menu-->


                                        <!--<li class="nav-item">
                                            <a href="<?/*= $absoluteUrl */?>appraisal/eyappraiseelist" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','eyappraiseelist')?'active':'' */?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>E-Y Appraisals (Appraisee) </p>
                                            </a>
                                        </li>-->

                                        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>
                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eysupervisorlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','eysupervisorlist')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y Appraisals (Supervisor) </p>
                                                </a>
                                            </li>

                                        <?php endif; ?>

                                        <!--<li class="nav-item">
                                            <a href="<?/*= $absoluteUrl */?>appraisal/eypeer1list" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','eypeer1list')?'active':'' */?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>E-Y Appraisals (Peer1) </p>
                                            </a>
                                        </li>-->


                                        <!--<li class="nav-item">
                                            <a href="<?/*= $absoluteUrl */?>appraisal/eypeer2list" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','eypeer2list')?'active':'' */?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>E-Y Appraisals (Peer2) </p>
                                            </a>
                                        </li>-->

                                        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>
                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eyagreementlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','eyagreementlist')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y Appraisals (Agreement) </p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                       <!-- <li class="nav-item">
                                            <a href="<?/*= $absoluteUrl */?>appraisal/eyappraiseeclosedlist" class="nav-link <?/*= Yii::$app->recruitment->currentaction('appraisal','eyappraiseeclosedlist')?'active':'' */?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>E-Y Closed (Appraisee) </p>
                                            </a>
                                        </li>-->
                                        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAppraisalSupervisorDesignate()):  ?>
                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eysupervisorclosedlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','eysupervisorclosedlist')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y Closed (Superviosr) </p>
                                                </a>
                                            </li>

                                        <?php endif; ?>




                                    </ul><!--End Mid Year Appraisals menu list-->


                                </li><!--/ End Year Child Menu list-->


                    <?php } ?>








                            </ul>
                        </li>







                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <!--<li class="breadcrumb-item"><a href="site">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>-->
                                <?=
                                Breadcrumbs::widget([
                                'itemTemplate' => "<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                                'homeLink' => [
                                'label' => Yii::t('yii', 'Home'),
                                'url' => Yii::$app->homeUrl,
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </ol>

                        </div><!-- /.col-6 bread ish -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?= $content ?>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->


        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; AAS -  <?= Html::encode(Yii::$app->name) ?> 2014 - <?= date('Y') ?>   <a href="#"> African Academy of Sciences</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b><?php Yii::signature() ?></b>
            </div>
        </footer>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->




    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();



?>
