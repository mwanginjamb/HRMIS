<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 12:27 AM
 */


namespace frontend\controllers;

use frontend\models\Employeerequisition;
use frontend\models\Employeerequsition;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\models\Employee;
use yii\web\Controller;
use yii\web\Response;

class EmployeerequisitionController extends Controller
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
                'only' => ['getrequisitions'],
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
        $model->isNewRecord = true;
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


        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){

            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Employeerequsition']);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Employee Requisition Created Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Employee Requisition : '.$result,true);
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

    public function actionUpdate($Requisition_No){
        $model = new Employeerequsition();
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeCard'];
        $filter = [
            'Requisition_No' => $Requisition_No,
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->navhelper->printrr($result);
        }


        $jobs = $this->getJobs();
        $requestReasons = $this->getRequestReasons();
        $employmentTypes = $this->getEmploymentTypes();
        $priority = $this->getPriority();
        $requisitionType = $this->getRequisitionTypes();

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Employeerequsition'],$model) ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){
                Yii::$app->session->setFlash('success','Employee Requisition Updated Successfully',true);
                return $this->redirect(['view','Requisition_No' => $result->Requisition_No]);
            }else{

                Yii::$app->session->setFlash('error','Error Updating Employee Requisition : '.$result,true);
                return $this->redirect(['index']);

            }


        }



        return $this->render('update',[
            'model' => $model,
            'jobs' => $jobs,
            'requestReasons' => $requestReasons,
            'employmentTypes' => $employmentTypes,
            'priority' => $priority,
            'requisitionType' => $requisitionType
        ]);
    }

    public function actionView($Requisition_No){
        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeCard'];


        $filter = [
            'Requisition_No' => $Requisition_No
        ];

        $requisition = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $requisitionModel = new Employeerequsition();
        $model = $this->loadtomodel($requisition[0],$requisitionModel);

        //print '<pre>';
        //print_r($model); exit;

        $jobs = $this->getJobs();
        $requestReasons = $this->getRequestReasons();
        $employmentTypes = $this->getEmploymentTypes();
        $priority = $this->getPriority();
        $requisitionType = $this->getRequisitionTypes();


        return $this->render('view',[
            'model' => $model,
            'jobs' => $jobs,
            'requestReasons' => $requestReasons,
            'employmentTypes' => $employmentTypes,
            'priority' => $priority,
            'requisitionType' => $requisitionType
        ]);
    }

    public function getJobs(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
            'Status' => 'Approved'
        ];
        $jobs = \Yii::$app->navhelper->getData($service, $filter);
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



    public function actionGetrequisitions(){
        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeList'];
        $requisitions = \Yii::$app->navhelper->getData($service);

        $result = [];
        foreach($requisitions as $req){


            $link = $updateLink =  '';
            $Viewlink = Html::a('Details',['view','Requisition_No'=> $req->Requisition_No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($req->Approval_Status == 'Open' ){
                $link = Html::a('Send Approval Request',['approval-request','app'=> $req->Requisition_No ],['class'=>'btn btn-primary btn-xs']);
                $updateLink = Html::a('Update Leave',['update','Requisition_No'=> $req->Requisition_No ],['class'=>'btn btn-info btn-xs']);
            }else if($req->Approval_Status == 'Pending_Approval'){
                $link = Html::a('Cancel Approval Request',['cancel-request','app'=> $req->Requisition_No ],['class'=>'btn btn-warning btn-xs']);
            }



            $result['data'][] = [
                'Requisition_No' => $req->Requisition_No,
                'Requisition_Date' => $req->Requisition_Date,
                'Job_Description' => !empty($req->Job_Description)?$req->Job_Description:'Not Set',
                'Reason_For_Request' => !empty($req->Reason_for_Request_Other)?$req->Reason_for_Request_Other: 'Not Set',
                'Required_Positions' => $req->Positions,
                'Type_of_Contract_Required' => !empty($req->Type_of_Contract_Required)?$req->Type_of_Contract_Required:'Not set',
                'Completion_Status' => $req->Completion_Status,
                'Approval_Status' => $req->Approval_Status,
                'action' => $link,
                'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
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