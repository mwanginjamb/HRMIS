<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Qualification;
use yii\web\Response;
use kartik\mpdf\Pdf;

class QualificationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index'],
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
                'only' => ['getqualifications'],
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

        $model = new Applicantprofile();
        $service = Yii::$app->params['ServiceName']['applicantProfile'];

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){

            $result = Yii::$app->navhelper->postData($service,Yii::$app->request->post()['Applicantprofile']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Leave request Created Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Leave request: '.$result,true);
                return $this->redirect(['index']);

            }

        }


        $Countries = $this->getCountries();
        $Religion = $this->getReligion();

        return $this->render('create',[

            'model' => $model,
            'countries' => ArrayHelper::map($Countries,'Code','Name'),
            'religion' => ArrayHelper::map($Religion,'Code','Description')

        ]);
    }


    public function actionUpdate($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
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

    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $leaveModel = new Leave();
        $model = $this->loadtomodel($leave[0],$leaveModel);


        return $this->render('view',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name'),
        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave request sent for approval Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending leave request for approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionCancelRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->CancelLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Cancelling Leave Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    /*Data access functions */

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetqualifications(){
        $service = Yii::$app->params['ServiceName']['qualifications'];
        $qualifications = \Yii::$app->navhelper->getData($service);

        $result = [];
        $count = 0;
        foreach($qualifications as $quali){

            ++$count;
            $link = $updateLink =  '';


            $updateLink = Html::a('Update Qualification',['update','Key'=> $quali->Key ],['class'=>'btn btn-outline-info btn-xs']);

            $link = Html::a('Remove Qualification',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-xs']);


            $result['data'][] = [
                'index' => $count,
                'Key' => $quali->Key,
                'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                'Qualification_Code' => !empty($quali->Qualification_Code)?$quali->Qualification_Code:'',
                'From_Date' => !empty($quali->From_Date)?$quali->From_Date:'',
                'To_Date' => !empty($quali->To_Date)?$quali->To_Date:'',
                'Description' => !empty($quali->Description)?$quali->Description:'',
                'Institution_Company' => !empty($quali->Institution_Company)?$quali->Institution_Company:'',
                //'Comment' => !empty($quali->Comment)?$quali->Comment:'',

                'Update_Action' => $updateLink,
                'Remove' => $link
            ];
        }

        return $result;
    }

    public function actionReport(){
        $service = Yii::$app->params['ServiceName']['expApplicationList'];
        $leaves = \Yii::$app->navhelper->getData($service);
        krsort( $leaves);//sort by keys in descending order
        $content = $this->renderPartial('_historyreport',[
            'leaves' => $leaves
        ]);

        //return $content;
        $pdf = \Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->orientation = Pdf::ORIENT_PORTRAIT;

        //The trick to returning binary content
        $content = $pdf->render('', 'S');
        $content = chunk_split(base64_encode($content));

        return $content;
    }

    public function actionReportview(){
        return $this->render('_viewreport',[
            'content'=>$this->actionReport()
        ]);
    }

    public function Getleavebalance(){
        $service = Yii::$app->params['ServiceName']['leaveBalance'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $balances = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        //print '<pre>';
        // print_r($balances);exit;

        foreach($balances as $b){
            $result = [
                'Key' => $b->Key,
                'Annual_Leave_Bal' => $b->Annual_Leave_Bal,
                'Maternity_Leave_Bal' => $b->Maternity_Leave_Bal,
                'Paternity' => $b->Paternity,
                'Study_Leave_Bal' => $b->Study_Leave_Bal,
                'Compasionate_Leave_Bal' => $b->Compasionate_Leave_Bal,
                'Sick_Leave_Bal' => $b->Sick_Leave_Bal
            ];
        }

        return $result;

    }



    public function getLeaveTypes($gender = 'Female'){
        $service = Yii::$app->params['ServiceName']['leaveTypes'];
        $filter = [
            'Gender' => $gender,
            'Gender' => 'Both'
        ];

        $leavetypes = \Yii::$app->navhelper->getData($service,$filter);
        return $leavetypes;
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];

        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Name))
                $res[] = [
                    'Code' => $c->Code,
                    'Name' => $c->Name
                ];
        }

        return $res;
    }

    public function getReligion(){
        $service = Yii::$app->params['ServiceName']['Religion'];
        $filter = [
            'Type' => 'Religion'
        ];
        $religion = \Yii::$app->navhelper->getData($service, $filter);
        return $religion;
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