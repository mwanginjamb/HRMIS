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

class RecruitmentController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['getvacancies'],
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

    public function actionCreate(){

        $model = new Employeerequsition();


        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeCard'];

        if(\Yii::$app->request->get('create') ){
            //make an initial empty request to nav
            $req = Yii::$app->navhelper->postData($service,[]);
            $model = $this->loadtomodel($req,$model);
        }

        $jobs = $this->getJobs();
        $requestReasons = $this->getRequestReasons();
        $employmentTypes = $this->getEmploymentTypes();
        $priority = $this->getPriority();
        $requisitionType = $this->getRequisitionTypes();
        $message = "";
        $success = false;

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){

            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Leave']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Leave request Created Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Leave request: '.$result,true);
                return $this->redirect(['index']);

            }

        }



        return $this->render('create',[
            'model' => $model,
            'jobs' => $jobs,
            'requestReasons' => $requestReasons,
            'employmentTypes' => $employmentTypes,
            'priority' => $priority,
            'requisitionType' => $requisitionType

        ]);
    }

    public function actionUpdate($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['reqApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();


        $filter = [
            'Application_No' => $ApplicationNo
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);



        //load nav result to model
        $leaveModel = new Leave();

        $model = $this->loadtomodel($result[0],$leaveModel);



        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){
            $result = Yii::$app->navhelper->updateData($model);


            if(!empty($result)){
                Yii::$app->session->setFlash('success','Leave request Updated Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Leave Request : '.$result,true);
                return $this->redirect(['index']);
            }

        }

        return $this->render('update',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name')
        ]);
    }

    public function actionView($Job_ID){
        $service = Yii::$app->params['ServiceName']['JobsCard'];


        $filter = [
            'Job_ID' => $Job_ID
        ];

        $job = Yii::$app->navhelper->getData($service, $filter);

        //print '<pre>';
        //print_r($job); exit;

        //load nav result to model
        $jobModel = new Job();
        //$model = $this->loadtomodel($requisition[0],$jobModel);

        return $this->render('view',[
            'model' => $job,

        ]);
    }

    public function getJobs(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $jobs = \Yii::$app->navhelper->getData($service);
        (object)$result = [];

        foreach($jobs as $j){
            $result []= [
                'Job_ID' =>$j->Job_ID,
                'Job_Description' => !empty($j->Job_Description)? $j->Job_Description: 'Not Set'
            ];
        }

        return ArrayHelper::map($result,'Job_ID','Job_Description');
    }

    public function getRequestReasons(){

        $result = [
            ['Code' => 'New_Vacancy', 'Description' => 'New Vacancy'],
            ['Code' => 'Replacement', 'Description' => 'Replacement'],
            ['Code' => 'Retirement', 'Description' => 'Retirement'],
            ['Code' => 'Retrenchment', 'Description' => 'Retrenchment'],
            ['Code' => 'Demise', 'Description' => 'Demise'],
            ['Code' => 'Other', 'Description' => 'Other'],
        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function getEmploymentTypes(){

        $result = [
            ['Code' => 'Permanent', 'Description' => 'Permanent'],
            ['Code' => 'Temporary', 'Description' => 'Temporary'],
            ['Code' => 'Voluntary', 'Description' => 'Voluntary'],
            ['Code' => 'Contract', 'Description' => 'Contract'],
            ['Code' => 'Interns', 'Description' => 'Interns'],
            ['Code' => 'Casuals', 'Description' => 'Casuals'],
        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function getPriority(){
        $result = [
            ['Code' => '_blank_', 'Description' => '_blank_'],
            ['Code' => 'High', 'Description' => 'High'],
            ['Code' => 'Medium', 'Description' => 'Medium'],
            ['Code' => 'Low', 'Description' => 'Low'],

        ];

        return ArrayHelper::map($result,'Code','Description');
    }

    public function getRequisitionTypes(){

        $result = [
            ['Code' => '_blank_', 'Description' => '_blank_'],
            ['Code' => 'Internal', 'Description' => 'Internal'],
            ['Code' => 'External', 'Description' => 'External'],
            ['Code' => 'Both', 'Description' => 'Both'],

        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function actionVacancies(){
        return $this->render('vacancies');
    }

    public function actionGetvacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
           /* 'Closed' => false,
            'Advertised' => true,
            'Positions' => '>0',*/

        ];
        $requisitions = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        foreach($requisitions as $req){
                if($req->No_of_Posts > 0 && !empty($req->Job_Description) ) {
                    $Viewlink = Html::a('View Details', ['view', 'Job_ID' => $req->Job_ID], ['class' => 'btn btn-outline-primary btn-xs']);

                    $result['data'][] = [
                        'Job_ID' => !empty($req->Job_ID) ? $req->Job_ID : 'Not Set',
                        'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : '',
                        'No_of_Posts' => !empty($req->No_of_Posts) ? $req->No_of_Posts : 'Not Set',
                        'Date_Created' => !empty($req->Date_Created) ? $req->Date_Created : '',
                        'action' => !empty($Viewlink) ? $Viewlink : '',

                    ];

                }

        }

        return $result;
    }



    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new HrloginForm();


        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();//reroute to recruitment profile page

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm(); //This signup form in common is for registering external hrusers
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();//redirect to recruitment profile page
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

}