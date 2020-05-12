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
use frontend\models\Coverletter;
use frontend\models\Cv;
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

class RecruitmentController extends Controller
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
                'only' => ['getvacancies','getexternalvacancies','requirementscheck'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        //return $this->render('index');
        return $this->redirect(['recruitment/vacancies']);
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
       if(Yii::$app->request->post() && Yii::$app->request->post('type') == 'External'){
           $this->layout = 'external';
           Yii::$app->session->set('mode','external');
       }else{
           Yii::$app->session->set('mode','internal');
       }
        $service = Yii::$app->params['ServiceName']['JobsCard'];

        $filter = [
            'Job_ID' => $Job_ID
        ];

        $job = Yii::$app->navhelper->getData($service, $filter);
        //Get the Job Requisition No

        if(is_null(Yii::$app->recruitment->getRequisitionID($Job_ID))){
            Yii::$app->session->setFlash('error','You cannot apply for this job : Job ID ('.$Job_ID.') cannot be found in HR Requisitions List',true);
                return $this->redirect(['vacancies']);
        }else{
            Yii::$app->session->set('REQUISITION_NO',Yii::$app->recruitment->getRequisitionID($Job_ID));
        }

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

    public function actionExternalvacancies(){
        $this->layout = 'external';
        return $this->render('externalvacancies');
    }

    public function actionGetvacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
        ];
        $requisitions = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($requisitions as $req){
            $RequisitionType = Yii::$app->recruitment->getRequisitionType($req->Job_ID);
                if(($req->No_of_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_ID)) && ($RequisitionType == 'Internal' || $RequisitionType == 'Both' ) ) {
                    $Viewlink = Html::a('Apply', ['view', 'Job_ID' => $req->Job_ID], ['class' => 'btn btn-outline-primary btn-xs']);

                    $result['data'][] = [
                        'Job_ID' => !empty($req->Job_ID) ? $req->Job_ID : 'Not Set',
                        'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : '',
                        'No_of_Posts' => !empty($req->No_of_Posts) ? $req->No_of_Posts : 'Not Set',
                        'Date_Created' => !empty($req->Date_Created) ? $req->Date_Created : '',
                        'ReqType' => \Yii::$app->recruitment->getRequisitionType($req->Job_ID),
                        'action' => !empty($Viewlink) ? $Viewlink : '',

                    ];

                }

        }
        return $result;
    }

    public function actionGetexternalvacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
        ];
        $requisitions = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($requisitions as $req){
            $RequisitionType = Yii::$app->recruitment->getRequisitionType($req->Job_ID);
            if(($req->No_of_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_ID)) && ($RequisitionType == 'External' ) ) {
                $Viewlink = Html::a('Apply', ['view', 'Job_ID' => $req->Job_ID], [
                    'class' => 'btn btn-outline-primary btn-xs',
                    'data' => [
                        'params' => ['type' => 'External'],
                        'method' => 'post',
                    ],
                ]);

                $result['data'][] = [
                    'Job_ID' => !empty($req->Job_ID) ? $req->Job_ID : 'Not Set',
                    'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : '',
                    'No_of_Posts' => !empty($req->No_of_Posts) ? $req->No_of_Posts : 'Not Set',
                    'Date_Created' => !empty($req->Date_Created) ? $req->Date_Created : '',
                    'ReqType' => \Yii::$app->recruitment->getRequisitionType($req->Job_ID),
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

            //return $this->goBack();//reroute to recruitment profile page
            return $this->redirect(['applicantprofile/create']);

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        if(Yii::$app->session->has('HRUSER')){
            Yii::$app->session->remove('HRUSER');
            return $this->redirect(['recruitment/vacancies']);
        }
        return $this->redirect(['recruitment/vacancies']);

       // return $this->goHome();
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

    public function actionVerifyEmail($token)
    {

        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


        if ($user = $model->verifyEmail($HRUser = true)) {
           /* if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }*/
           Yii::$app->session->setFlash('success', 'Your email has been confirmed, Welcome !');
           return $this->redirect(['applicantprofile/create']);
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionSubmit(){

        $model = new Applicantprofile();

        //get Applicant No
        $ApplicationNo = Yii::$app->recruitment->getProfileID();

        $requirements = '';

        //Refresh the Job Applicant Requirements on each update
        if(Yii::$app->session->has('Job_Application_No')){
            $requirements = $this->getRequiremententries();
            Yii::$app->session->set('requirements',$requirements);
            //Yii::$app->recruitment->printrr($requirements);
        }
        if(Yii::$app->request->isPost){

            if(!empty(Yii::$app->request->post()['Applicantprofile']['Motivation'])){ //Update motivation letter
                $service = Yii::$app->params['ServiceName']['applicantProfile'];
                $filter = [
                    'No' => $ApplicationNo,
                ];
                $modelData = Yii::$app->navhelper->getData($service, $filter);
                $model = $this->loadtomodel($modelData[0],$model);
                $model->Motivation = Yii::$app->request->post()['Applicantprofile']['Motivation'];
                $res = Yii::$app->navhelper->updateData($service,$model);
            }

            $service = Yii::$app->params['ServiceName']['JobApplication'];

            //call the job application CodeUnit
            $data = [
                'applicantNo' => $ApplicationNo,
                'requisitionNo' => Yii::$app->session->get('REQUISITION_NO'),
            ];

            $result = Yii::$app->navhelper->SubmitJobApplication($service,$data); // This code unit should return  the Job_Applicant_No so as to generate jobrequirement entries.
            //Remove sessions set within the process
            Yii::$app->session->remove('REQUISITION_NO');

            if(is_array($result)){
                //store Job Applicant Number
                Yii::$app->session->set('Job_Application_No',$result['return_value']);

                $requirements = $this->getRequiremententries();
                //store requirements in a session
                Yii::$app->session->set('requirements',$requirements);


            }



            if(!is_string($result)){
                Yii::$app->session->setFlash('success', 'Congratulations, Job Application submitted successfully.', true);
            }else{
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to submit your application now : '. $result);
            }
        }
        


        return $this->render('submit',[
            'model' => $model,
            'requirements' => (Yii::$app->session->has('requirements'))?Yii::$app->session->get('requirements'):'',
            'cvmodel' => new Cv(),
            'covermodel' => new Coverletter()
        ]);

    }

    public function getRequiremententries(){
        $requirementEntriesService = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];
        $reqFilter = [
            'Job_Applicant_No' =>  (Yii::$app->session->has('Job_Application_No'))?Yii::$app->session->get('Job_Application_No'):'',
        ];
        $requirements = Yii::$app->navhelper->getData($requirementEntriesService, $reqFilter);
        return $requirements;
    }

    public function actionRequirementscheck(){
        $service = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];
        $data = [
            'Key' => Yii::$app->request->post('Key'),
            'Line_No' => Yii::$app->request->post('Line_No'),
            'Met' => True,
        ];

        $result = Yii::$app->navhelper->updateData($service,$data);
        Yii::$app->session->setFlash('success','Job Requirement Specification Updated Successfully.');
        return $result;
    }


    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;//get properties of given object
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    

}