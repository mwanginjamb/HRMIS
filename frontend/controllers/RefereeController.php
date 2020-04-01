<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Applicantprofile;
use frontend\models\Referee;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use yii\web\Response;
use kartik\mpdf\Pdf;

class RefereeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
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
                'only' => ['getreferee'],
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

        $model = new Referee();
        $service = Yii::$app->params['ServiceName']['referees'];

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Referee'],$model)){

            $model->Application_No = Yii::$app->recruitment->getProfileID();//on live



            $result = Yii::$app->navhelper->postData($service,$model);


            if(is_object($result)){
                //store profile id in a session

                Yii::$app->session->setFlash('success','Applicant Referee Added Successfully',true);
                return $this->redirect(['index']);

            }else{

                Yii::$app->session->setFlash('error','Error Adding Applicant Referee : '.$result,true);
                return $this->redirect(['index']);

            }

        }//End Saving Profile Gen data


        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,


            ]);
        }

        return $this->render('create',[
            'model' => $model,

        ]);
    }

    public function actionUpdate(){
        $service = Yii::$app->params['ServiceName']['referees'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);
        $Expmodel = new Referee();
        //load nav result to model
        $model = $this->loadtomodel($result[0],$Expmodel);

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Referee'],$model)){
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!empty($result)){
                Yii::$app->session->setFlash('success','Qualification Updated Successfully',true);
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Qualification : '.$result,true);
                return $this->redirect(['index']);
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,

            ]);
        }

        return $this->render('update',[
            'model' => $model,

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['referees'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Referee Purged Successfully .',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Purging Referee: '.$result,true);
            return $this->redirect(['index']);
        }
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

    public function actionGetreferee(){
        $service = Yii::$app->params['ServiceName']['referees'];
        $referees = \Yii::$app->navhelper->getData($service);

        $result = [];
        $count = 0;
        foreach($referees as $ref){
            if(!empty($ref->Line_No)){
                ++$count;
                $link = $updateLink =  '';


                $updateLink = Html::a('<i class="fa fa-edit"></i>',['update','Line'=> $ref->Line_No ],['class'=>'update btn btn-outline-info btn-xs']);

                $link = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $ref->Key ],['class'=>'btn btn-outline-warning btn-xs','data' => [
                    'confirm' => 'Are you sure you want to delete this record?',
                    'method' => 'post',
                ]]);




                $result['data'][] = [
                    'index' => $count,
                    'Key' => $ref->Key,
                    'Application_No' => !empty($ref->Application_No)?$ref->Application_No:'',
                    'First_Name' => !empty($ref->First_Name)?$ref->First_Name:'',
                    'Middle_Name' => !empty($ref->Middle_Name)? $ref->Middle_Name : '',
                    'Last_Name' => !empty($ref->Last_Name)? $ref->Last_Name: '',
                    'Instituition' => !empty($ref->Instituition)? $ref->Instituition: '',
                    'Position' => !empty($ref->Position)? $ref->Position: '',
                    'Email' => !empty($ref->Email)? $ref->Email: '',
                    'Phone_No' => !empty($ref->Phone_No)? $ref->Phone_No: '',
                    'Action' => $updateLink.' | '.$link,
                    //'Remove' => $link
                ];
            }

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

    public function loadpost($post,$model){ // load model with form data


        $modeldata = (get_object_vars($model)) ;

        foreach($post as $key => $val){

            $model->$key = $val;
        }

        return $model;
    }
}