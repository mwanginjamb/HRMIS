<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 12:27 AM
 */


namespace frontend\controllers;

use common\models\HrloginForm;
use common\models\SignupForm;
use frontend\models\Appraisalcard;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use frontend\models\Applicantprofile;
use frontend\models\Employeerequisition;
use frontend\models\Employeerequsition;
use frontend\models\Job;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\models\Employee;
use yii\web\Controller;
use yii\web\Response;

class AppraisalController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','vacancies'],
                'rules' => [
                    [
                        'actions' => ['vacancies'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','vacancies'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['getappraisals','getsubmittedappraisals','getapprovedappraisals','getsuperapprovedappraisals'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        return $this->render('index');

    }

    public function actionSubmitted(){

        return $this->render('submitted');

    }

    public function actionApprovedappraisals(){

        return $this->render('approvedappraisals');

    }

    public function actionSuperapprovedappraisals(){

        return $this->render('superapprovedappraisals');

    }

    public function actionMyappraiseelist(){

        return $this->render('myappraiseelist');

    }

    public function actionMysupervisorlist(){

        return $this->render('mysupervisorlist');

    }

    public function actionMyapprovedappraiseelist(){

        return $this->render('myapprovedappraiseelist');

    }

    public function actionMyapprovedsupervisorlist(){

        return $this->render('myapprovedsupervisorlist');

    }

    public function actionEyappraiseelist(){

        return $this->render('eyappraiseelist');

    }

    public function actionEysupervisorlist(){

        return $this->render('eysupervisorlist');

    }

    public function actionEypeer1list(){

        return $this->render('eypeer1list');

    }

    public function actionEypeer2list(){

        return $this->render('eypeer2list');

    }

    public function actionEyagreementlist(){

        return $this->render('eyagreementlist');

    }

    public function actionEyappraiseeclosedlist(){

        return $this->render('eyappraiseeclosedlist');

    }

    public function actionEysupervisorclosedlist(){

        return $this->render('eysupervisorclosedlist');

    }

    public function actionSuperapprovedappraisals12(){

        return $this->render('superapprovedappraisals');

    }


    public function actionGetappraisals(){

        $service = Yii::$app->params['ServiceName']['AppraisalList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        //ksort($appraisals);
        $result = [];

       if(is_array($appraisals)){
           foreach($appraisals as $req){

               $Viewlink = Html::a('View', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

               $result['data'][] = [
                   'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                   'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                   'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                   'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                   'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                   'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                   'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                   'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                   'Action' => !empty($Viewlink) ? $Viewlink : '',

               ];

           }
       }

        return $result;
    }

    /*Get Submitted Appraisals Pending Approval*/
    public function actionGetsubmittedappraisals(){
        $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['SubmittedAppraisals'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];


        if(is_array($appraisals)){
            foreach($appraisals as $req){

                if($model->isSupervisor($req->Employee_User_Id,$req->Supervisor_User_Id)){
                    Yii::$app->session->set('isSupervisor',true);
                }else{
                    Yii::$app->session->set('isSupervisor',false);
                }
                $Viewlink = Html::a('<i class="fa fa-eye"></i>', ['viewsubmitted', 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: '','Employee_No' => $req->Employee_No], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    /**Get Approved Appraisals (Supervisor view) */

    public function actionGetsuperapprovedappraisals(){
        $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['ApprovedAppraisals'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];


        if(is_array($appraisals)){
            foreach($appraisals as $req){

                if($model->isSupervisor($req->Employee_User_Id,$req->Supervisor_User_Id)){
                    Yii::$app->session->set('isSupervisor',true);
                }else{
                    Yii::$app->session->set('isSupervisor',false);
                }

                $Viewlink = Html::a('<i class="fa fa-eye"></i>', ['viewsubmitted', 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: '','Employee_No' => $req->Employee_No], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    /** Get Approved Appraisal Goals/Objectives -- Appraisee */

    public function actionGetapprovedappraisals(){
        $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['ApprovedAppraisals'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
       
        $result = [];

       if(is_array($appraisals)){
           foreach($appraisals as $req){


            if($model->isSupervisor($req->Employee_User_Id,$req->Supervisor_User_Id)){
                Yii::$app->session->set('isSupervisor',true);
            }else{
                Yii::$app->session->set('isSupervisor',false);
            }


            $Viewlink = Html::a('view', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);
            if($model->isSupervisor($req->Employee_User_Id,$req->Supervisor_User_Id)){
                $Viewlink = Html::a('viewsubmitted', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);
            }
               

               $result['data'][] = [
                   'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                   'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                   'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                   'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                   'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                   'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                   'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                   'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                   'Action' => !empty($Viewlink) ? $Viewlink : '',

               ];

           }
       }

        return $result;
    }

    /*Get Mid Year Appraisals - Appraisee List*/

    public function actionGetMYAppraiseeList(){
       // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['MYAppraiseeList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
            'MY_Appraisal_Status' => 'Appraisee_Level'
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('view', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    /*Get Mid Year Approved Appraisals - Appraisee List*/

    public function actionGetMYApprovedAppraiseeList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['MYApprovedList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('view', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    /*Get Mid Year Appraisals - Supervisor List*/

    public function actionGetMYSupervisorList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['MYSupervisorList'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
            'MY_Appraisal_Status' => 'Supervisor_Level',
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('views', ['viewsubmitted','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }


    /*Get Mid Year Approved Appraisals - Supervisor List*/

    public function actionGetMYApprovedSupervisorList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['MYApprovedList'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('view', ['viewsubmitted','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }



    /*Get End Year Appraisals - Appraisee List*/

    public function actionGetEYAppraiseeList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['EYAppraiseeList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
            'EY_Appraisal_Status' => 'Appraisee_Level'
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){


                /* if($model->isSupervisor($req->Employee_User_Id,$req->Supervisor_User_Id)){
                     Yii::$app->session->set('isSupervisor',true);
                 }else{
                     Yii::$app->session->set('isSupervisor',false);
                 }*/


                $Viewlink = Html::a('view', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);
                /* if($model->isSupervisor($req->Employee_User_Id,$req->Supervisor_User_Id)){
                     $Viewlink = Html::a('viewsubmitted', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);
                 }*/


                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }




    /*Get Mid Year Appraisals - Supervisor List*/

    public function actionGetEYSupervisorList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['EYSupervisorList'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
            'EY_Appraisal_Status' => 'Supervisor_Level',
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('views', ['viewsubmitted','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }



    /*Get End Year Appraisals - Peer1 List*/

    public function actionGetEYPeer1List(){

        $service = Yii::$app->params['ServiceName']['EYPeer1List'];
        $filter = [
            'Peer_1_Employee_No' => Yii::$app->user->identity->{'Employee No_'},
            'EY_Appraisal_Status' => 'Peer_1_Level'
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('view', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }



    /*Get End Year Appraisals - Peer2 List*/

    public function actionGetEYPeer2List(){

        $service = Yii::$app->params['ServiceName']['EYPeer2List'];
        $filter = [
            'Peer_2_Employee_No' => Yii::$app->user->identity->{'Employee No_'},
            'EY_Appraisal_Status' => 'Peer_2_Level'
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('view', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }



    /*Get Mid Year Appraisals - Supervisor List*/

    public function actionGetEYAgreementList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['EYAgreementList'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
            'EY_Appraisal_Status' => 'Agreement_Level',
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('views', ['viewsubmitted','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }



    /*Get EY Year Closed Appraisals - Appraisee List*/

    public function actionGetEYAppraiseeClosedList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['ClosedAppraisalsList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
            'EY_Appraisal_Status' => 'Closed',
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('views', ['view','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }

    /*Get EY Year Closed Appraisals -  Supervisor List*/

    public function actionGetEYSupervisorClosedList(){
        // $model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['ClosedAppraisalsList'];
        $filter = [
            'Supervisor_User_Id' => Yii::$app->user->identity->getId(),
            'EY_Appraisal_Status' => 'Closed',
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('views', ['viewsubmitted','Employee_No' => $req->Employee_No, 'Appraisal_No' => !empty($req->Appraisal_No)?$req->Appraisal_No: ''], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Function_Team' =>  !empty($req->Function_Team) ? $req->Function_Team : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ?$req->Appraisal_Period : '',
                    'Goal_Setting_Start_Date' =>  !empty($req->Goal_Setting_Start_Date) ? $req->Goal_Setting_Start_Date : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',

                ];

            }
        }

        return $result;
    }



    public function actionView(){
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();

        $filter = [
            'Appraisal_No' => Yii::$app->request->get('Appraisal_No'),
            'Employee_No' => Yii::$app->request->get('Employee_No')
        ];

        $appraisal = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($appraisal)){
            $model = Yii::$app->navhelper->loadmodel($appraisal[0],$model);
        }

        //echo property_exists($appraisal[0]->Employee_Appraisal_KRAs,'Employee_Appraisal_KRAs')?'Exists':'Haina any';

        // Yii::$app->recruitment->printrr($appraisal[0]);


        return $this->render('view',[
            'model' => $model,
            'card' => $appraisal[0]
        ]);
    }

    public function actionViewsubmitted($Appraisal_No,$Employee_No){
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();

        $filter = [
            'Appraisal_No' => Yii::$app->request->get('Appraisal_No'),
            //'Employee_No' => Yii::$app->request->get('Employee_No')
        ];

        $appraisal = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($appraisal)){
            $model = Yii::$app->navhelper->loadmodel($appraisal[0],$model);
        }

        //echo property_exists($appraisal[0]->Employee_Appraisal_KRAs,'Employee_Appraisal_KRAs')?'Exists':'Haina any';

        // Yii::$app->recruitment->printrr($appraisal[0]);


        return $this->render('viewsubmitted',[
            'model' => $model,
            'card' => $appraisal[0]
        ]);
    }

    //Submit Appraisal to supervisor

    public function actionSubmit($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanSendGoalSettingForApproval($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Perfomance Appraisal Submitted Successfully.', true);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Submitting Performance Appraisal : '. $result);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    /*Supervisor Actions :Approve Reject*/

    public function actionApprove($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            //'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanApproveGoalSetting($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Approved Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{
            Yii::$app->session->setFlash('error', 'Error Approving Performance Appraisal Goals : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }

    }

    public function actionReject($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1,
            'approvalComment' => 'This is Rejected .', //Yii::$app->request->post('rejectionComments')
        ];

        $result = Yii::$app->navhelper->IanSendGoalSettingForApproval($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Rejected and Sent Back to Appraisee Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Rejecting Performance Appraisal Goals : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //Submit MY Appraisal for Approval
 
    public function actionSubmitmy($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanSendMYAppraisalForApproval($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Mid Year Perfomance Appraisal Submitted Successfully.', true);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Submitting Mid Year Performance Appraisal : '. $result);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }


    //Approve MY appraisal
    public function actionApprovemy($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanApproveMYAppraisal($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Mid Year Appraisal Approved Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Approving Mid Year Appraisal : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //Reject Mid-Year Appraisal

    public function actionRejectmy($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            'rejectionComments' => 'This is Rejected .', //Yii::$app->request->post('rejectionComments')
        ];

        $result = Yii::$app->navhelper->IanSendMYAppraisaBackToAppraisee($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Mid Year Appraisal Rejected and Sent Back to Appraisee Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Rejecting Mid Year Appraisal : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //Submit End Year Appraisal for Approval

    public function actionSubmitey($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisalForApproval($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Perfomance Appraisal Submitted Successfully.', true);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Submitting End Year Performance Appraisal : '. $result);
            return $this->redirect(['view','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }


    //Approve EY appraisal
    public function actionApproveey($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanApproveEYAppraisal($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Appraisal Approved Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Approving End Year Appraisal : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //Reject End-Year Appraisal

    public function actionRejectey($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            'rejectionComments' => 'This is Rejected .', //Yii::$app->request->post('rejectionComments')
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisaBackToAppraisee($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Appraisal Rejected and Sent Back to Appraisee Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Rejecting End Year Appraisal : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //send appraisal to peer 1

    public function actionSendpeer1($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisalToPeer1($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent to Peer 1 Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Appraisal to Peer 1 : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //send appraisal to peer 2

    public function actionSendpeer2($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisalToPeer2($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent to Peer 2 Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Appraisal to Peer 2 for evaluation : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //send End Year Appraisal Back to Supervisor from peer

    public function actionSendbacktosupervisor($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisaBackToSupervisorFromPeer($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent back to supervisor from peer  Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending End Year Appraisal to Supervisor from Peer : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }

    //Send End-Year Appraisal to Agreement Level

    public function actionSendtoagreementlevel($appraisalNo,$employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalWorkflow'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisalToAgreementLevel($service,$data);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent Agreement Level  Successfully.', true);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending End Year Appraisal to Agreement Level : '. $result);
            return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);

        }

    }


}