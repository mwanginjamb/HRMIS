<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 2:53 PM
 */

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use yii\web\Response;

class LeaveController extends Controller
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
                'only' => ['getleaves'],
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


        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];

        if(\Yii::$app->request->get('create') ){
            //make an initial empty request to nav
            $req = Yii::$app->navhelper->postData($service,[]);
            $modeldata = (get_object_vars($req)) ;
            foreach($modeldata as $key => $val){
                if(is_object($val)) continue;
                $model->$key = $val;
            }

            $model->Start_Date = date('Y-m-d');
            $model->End_Date = date('Y-m-d');

        }

        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();
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
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name'),

        ]);
    }


    public function actionUpdate($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();


        $filter = [
            ['Application_No' => $ApplicationNo]
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $leaveModel = new Leave();

        $model = $this->loadtomodel($result,$leaveModel);

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

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service);


        return $this->render('view',[
            'leave' => $leave[0],
        ]);
    }

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetleaves(){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
        $leaves = \Yii::$app->navhelper->getData($service);

        $result = [];
        foreach($leaves as $leave){
            $result['data'][] = [
                'Key' => $leave->Key,
                'Employee_No' => $leave->Employee_No,
                'Employee_Name' => $leave->Employee_Name,
                'Application_No' => $leave->Application_No,
                'Days_Applied' => $leave->Days_Applied,
                'Application_Date' => $leave->Application_Date,
                'Approval_Status' => $leave->Approval_Status
            ];
        }

        return $result;
    }

    public function Getleavebalance(){
        $service = Yii::$app->params['ServiceName']['leaveBalance'];
        $filter = [
            'No' => 'AAS-069'
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

    public function getEmployees(){
        $service = Yii::$app->params['ServiceName']['employees'];

        $employees = \Yii::$app->navhelper->getData($service);
        return $employees;
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

        return true;
    }

}