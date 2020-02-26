<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/25/2020
 * Time: 3:55 PM
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

use frontend\models\Leave;
use yii\web\Response;

class ApprovalsController extends Controller
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
                'only' => ['getapprovals'],
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

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);


        return $this->render('view',[
            'leave' => $leave[0],
        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        print '<pre>';
        print_r($request);
        return;
    }

    /*Data access functions */

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetapprovals(){
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];

        $filter = [
            'Approver_ID' => Yii::$app->user->identity->{'User ID'},
        ];
        $approvals = \Yii::$app->navhelper->getData($service,$filter);

        //print '<pre>';
       //print_r($approvals ); exit;


        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){



                    $Approvelink = ($app->Status == 'Open')? Html::a('Approve Request',['approve-request','app'=> $app->Document_No ],['class'=>'btn btn-success btn-xs','data' => [
                        'confirm' => 'Are you sure you want to Approve this request?',
                        'method' => 'post',
                    ]]):'';
                    $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request','app'=> $app->Document_No ],['class'=>'btn btn-warning btn-xs','data' => [
                        'confirm' => 'Are you sure you want to reject this leave request?',
                        'method' => 'post',
                    ]]): "";

                    $detailsLink = Html::a('Request Details',['leave/view','ApplicationNo'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);



                $result['data'][] = [
                    'Key' => $app->Key,
                    //'ToApprove' => $app->ToApprove,
                    'Details' => $app->Details,
                    'Comment' => $app->Comment,
                    'Sender_ID' => $app->Sender_ID,
                    'Due_Date' => $app->Due_Date,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'Approvelink' => $Approvelink,
                    'Rejectlink' => $Rejectlink,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;
    }



    public function actionApproveRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->ApproveLeaveRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Request Approved Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Approving Leave Request : '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionRejectRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];
        $request = Yii::$app->navhelper->RejectLeaveRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Request Rejected Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Rejecting Leave Request : '.$request,true);
            return $this->redirect(['index']);
        }
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