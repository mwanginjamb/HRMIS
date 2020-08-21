<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/4/2020
 * Time: 12:26 PM
 */

namespace frontend\controllers;

use frontend\models\LeaveRecall;
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


class LeaverecallController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete'],
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
                'only' => ['getrecalls'],
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
        //print '<pre>';
       // print_r(Yii::$app->user->identity->Employee[0]->Gender); exit;
        $model = new LeaveRecall();
        $model->Employee_No = Yii::$app->user->identity->Employee[0]->No;
        $employees = $this->getEmployees();
        $service = Yii::$app->params['ServiceName']['leaveRecallCard'];
        $leaves = $this->actionGetleaves($model->Employee_No);

        $leavetorecall = [];

        foreach($leaves as $leave){
            $leavetorecall[] = [
                'No' => $leave['No'],
                'Description' => $leave['Description'],
                ];
        }

        // Property format leave to recall array for the drop down

        $recalls = ArrayHelper::map($leavetorecall,'No','Description');

        /* Initiate a leave recall request to Navision  with employee number only*/


           $data = [
               'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
           ];
            //make a request to nav inserting employee no of Employee recalling themselves

            $req = Yii::$app->navhelper->postData($service,$data);

            if(is_string($req)){  // A string response is a fucking error

                Yii::$app->session->setFlash('error','Error : '.$req,true);
                return $this->redirect(['index']);
            }


            $model = $this->loadtomodel($req,$model);

        if($model->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post()['LeaveRecall'])){


            Yii::$app->navhelper->loadpost(Yii::$app->request->post()['LeaveRecall'],$model);

            $Recall = Yii::$app->navhelper->getData($service,['Recall_No' => $model->Recall_No]);


            $payload = [
                'Key' => $model->Key = $Recall[0]->Key,
                'Comments' => Yii::$app->request->post()['LeaveRecall']['Comments'],
            ];
            $result = Yii::$app->navhelper->updateData($service,$payload);


            if(!is_string($result)){
                return $this->actionApprovalRequest($result->Recall_No);
            }else{
                Yii::$app->session->setFlash('error','Recall Error: '.$result,true);
                return $this->redirect(['index']);
            }

        }


        return $this->render('create',[
            'model' => $model,
            'employees' => ArrayHelper::map($employees,'No','Full_Name'),
            'leaves' => $recalls


        ]);
    }


    public function actionUpdate($RecallNo){
        $service = Yii::$app->params['ServiceName']['leaveRecallCard'];
        $employees = $this->getEmployees();


        $filter = [
            'Recall_No' => $RecallNo
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);



        //load nav result to model
        $leaveModel = new LeaveRecall();

        $model = $this->loadtomodel($result[0],$leaveModel);

        if(Yii::$app->request->get()){
            $model->Leave_No_To_Recall = Yii::$app->request->get('Leave_No_To_Recall');
            $result = Yii::$app->navhelper->updateData($service,$model);
        }


        $leaves = $this->actionGetleaves($model->Employee_No);

        $leavetorecall = [];

        foreach($leaves as $leave){
            $leavetorecall[] = [
                'No' => $leave['No'],
                'Description' => $leave['Description'],
            ];
        }
        $recalls = ArrayHelper::map($leavetorecall,'No','Description');



        if($model->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post()['LeaveRecall'])){


            Yii::$app->navhelper->loadpost(Yii::$app->request->post()['LeaveRecall'],$model);

            $Recall = Yii::$app->navhelper->getData($service,['Recall_No' => $model->Recall_No]);


            $payload = [
                'Key' => $model->Key = $Recall[0]->Key,
                'Comments' => Yii::$app->request->post()['LeaveRecall']['Comments'],
            ];
            $result = Yii::$app->navhelper->updateData($service,$payload);


            if(!is_string($result)){
                return $this->actionApprovalRequest($result->Recall_No);
            }else{
                Yii::$app->session->setFlash('error','Recall Error: '.$result,true);
                return $this->redirect(['index']);
            }

        }

        return $this->render('update',[
            'model' => $model,
            'employees' => ArrayHelper::map($employees,'No','Full_Name'),
            'leaves' => $recalls
        ]);
    }

    public function actionView($RecallNo){
        $service = Yii::$app->params['ServiceName']['leaveRecallCard'];

        $filter = [
            'Recall_No' => $RecallNo
        ];

        $recalls = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $recallModel = new LeaveRecall();
        $model = $this->loadtomodel($recalls[0],$recallModel );


        return $this->render('view',[
            'model' => $model,
        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = [
            'recallNo' => $app,
            'approvalUrl' => 1,
            'sendMail' => 1,

        ];

        $request = Yii::$app->navhelper->RecallApproval($service, $data,'IanSendLeaveRecallForApproval');

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave recall request sent for approval Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending leave recall request for approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionCancelRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['recallNo' => $app];

        $request = Yii::$app->navhelper->RecallApproval($service, $data,'IanCancelLeaveRecallForApproval');

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Recall Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Cancelling Leave Recall Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionApprove($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['recallNo' => $app];

        $request = Yii::$app->navhelper->RecallApproval($service, $data,'IanApproveLeaveRecall');

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Recall Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending Leave recall Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionReject($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['recallNo' => $app];

        $request = Yii::$app->navhelper->RecallApproval($service, $data,'IanRejectLeaveRecall');

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Recall Approval Request Rejected Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Rejecting Leave recall Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    /*Data access functions */

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetleaves($empno){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
        $recallCardService = Yii::$app->params['ServiceName']['leaveRecallCard'];

        /*$data = [

            'Employee_No' => $empno,
        ];
        $recall = \Yii::$app->navhelper->PostData($recallCardService,$data);*/



        $filter = [
            'Approval_Status' => 'Approved',
            'Employee_No' => $empno,
            'Posted' => true
        ];
        $leaves = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        foreach($leaves as $leave){
            if(isset($leave->Days_Applied) && $leave->Days_Applied > 0) {
                $result[] = [
                    'No' => $leave->Application_No,
                    'Description' => $leave->Application_No . ' | ' . $leave->Start_Date . ' | ' . $leave->End_Date . ' | ' . $leave->Days_Applied.' | '. $leave->Leave_Code,
                ];
                krsort($result);
            }
        }

        return $result;

    }

    public function actionGetrecalls(){
        $service = Yii::$app->params['ServiceName']['leaveRecallList'];
        $filter = [
            'User_ID' => Yii::$app->user->identity->{'User ID'},
            'Days_Applied' => '>0'
        ];
        $leaves = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        foreach($leaves as $leave){


            $link = $updateLink =  '';
            $Viewlink = Html::a('Details',['view','RecallNo'=> $leave->Recall_No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($leave->Approval_Status == 'New' ){
                $link = Html::a('Send Approval Request',['approval-request','app'=> $leave->Recall_No ],['class'=>'btn btn-primary btn-xs']);
                $updateLink = Html::a('Update Leave',['update','RecallNo'=> $leave->Recall_No ],['class'=>'btn btn-info btn-xs']);
            }else if($leave->Approval_Status == 'Approval_Pending'){
                $link = Html::a('Cancel Approval Request',['cancel-request','app'=> $leave->Recall_No ],['class'=>'btn btn-warning btn-xs']);
            }



            $result['data'][] = [
                'Key' => $leave->Key,
                'Recall_No' => $leave->Recall_No,
                'Employee_No' => $leave->Employee_No,
                'Employee_Name' => !empty($leave->Employee_Name)?$leave->Employee_Name:'',
                'Leave_No_To_Recall' => !empty($leave->Leave_No_To_Recall)?$leave->Leave_No_To_Recall:'',
                'Days_Applied' => $leave->Days_Applied,
                'Days_To_Recall' => $leave->Days_To_Recall,
                'Application_Date' => $leave->Application_Date,
                'Approval_Status' => $leave->Approval_Status,

                'Action' => $link,
                'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
    }

    public function actionGetrecall($Leave_No_To_Recall,$Key){
        $service = Yii::$app->params['ServiceName']['leaveRecallCard'];
        $data = [
            'Key' => $Key,
            'Leave_No_To_Recall' => $Leave_No_To_Recall,

        ];


        $recall = \Yii::$app->navhelper->updateData($service,$data);
        return $recall;
    }

    public function actionReport(){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
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

        return $model;
    }

    public function actionCommitrecalldays(){
        $model = new LeaveRecall();
        $service = Yii::$app->params['ServiceName']['leaveRecallCard'];

        $filter = [
            'Recall_No' => Yii::$app->request->post('Recall_No'),
        ];

        // Get current Key Before Updating
        $recall = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($recall)){
            Yii::$app->navhelper->loadmodel($recall[0],$model);
        }
        $model->Days_To_Recall = Yii::$app->request->post('Days_To_Recall');

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
    }

    public function actionCommitleavetorecall(){
        $model = new LeaveRecall();
        $service = Yii::$app->params['ServiceName']['leaveRecallCard'];

        $filter = [
            'Recall_No' => Yii::$app->request->post('Recall_No'),

        ];

        // Get current Key Before Updating
        $recall = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($recall)){
            Yii::$app->navhelper->loadmodel($recall[0],$model);
        }
        $model->Leave_No_To_Recall = Yii::$app->request->post('Leave_No_To_Recall');


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
    }

}