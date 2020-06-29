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
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use yii\web\Response;
use kartik\mpdf\Pdf;

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
                'only' => ['getleaves','getactiveleaves'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        //print '<pre>';
       // print_r(Yii::$app->user->identity->Employee[0]->Last_Name); exit;

        return $this->render('index');

    }

    public function actionActiveleaves(){
        return $this->render('activeleaves');
    }

    public function actionCreate(){

        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];

        if(\Yii::$app->request->get('create')){
            if(empty(Yii::$app->request->post()['Leave'])) {
                //make an initial empty request to nav
                $req = Yii::$app->navhelper->postData($service, []);

                if (is_string($req)) {  // A string response is a fucking error
                    Yii::$app->session->setFlash('error', 'Error : ' . $req, true);
                    return $this->redirect(['index']);
                }


                $modeldata = (get_object_vars($req));
                foreach ($modeldata as $key => $val) {
                    if (is_object($val)) continue;
                    $model->$key = $val;
                }

                $model->Start_Date = date('Y-m-d');
                $model->End_Date = date('Y-m-d');
            }

        }

        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();
        $message = "";
        $success = false;

        if(Yii::$app->request->post() && !empty(Yii::$app->request->post()['Leave']) ){
            Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leave'],$model);
            //Yii::$app->recruitment->printrr($model);
            //Retrieve the leave again to use the new key in the model
            $leave = Yii::$app->navhelper->getData($service,['Application_No' => $model->Application_No]);

            if(is_array($leave)){// A get request returns an array of objects
                $model->Key = $leave[0]->Key;
                $result = Yii::$app->navhelper->updateData($service,$model);
            }


            if(is_object($result)){// an update request result would be a single object


                Yii::$app->session->setFlash('success','Leave request Created Successfully',true);
                $this->actionApprovalRequest($result->Application_No);
                return $this->redirect(['index']);

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

    public function actionSetdays(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];


        $data = [
            'Application_No' => Yii::$app->request->post('Application_No'),
            'Leave_Code' => Yii::$app->request->post('Leave_Code'),
            'Total_No_Of_Days' => Yii::$app->request->post('Total_No_Of_Days'),
            'Key' => Yii::$app->request->post('Key'),
            'Start_Date' => Yii::$app->request->post('Start_Date'),
        ];

        $leave = Yii::$app->navhelper->getData($service,['Application_No' => Yii::$app->request->post('Application_No')]);

        if(is_array($leave)){
            $data['Key'] = $leave[0]->Key;
        }


        $result = Yii::$app->navhelper->updateData($service,$data);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

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
            //Retrieve the leave again to use the new key in the model
            $leave = Yii::$app->navhelper->getData($service,['Application_No' => $model->Application_No]);
            if(is_array($leave)){
                $model->Key = $leave[0]->Key;
            }
            $result = Yii::$app->navhelper->updateData($service,$model);


            if(!empty($result)){
                //Yii::$app->recruitment->printrr($result);
                Yii::$app->session->setFlash('success','Leave request Updated Successfully',true);
                $this->actionApprovalRequest($result->Application_No);
                return $this->redirect(['index']);
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
        $data = [
            'applicationNo' => $app,
            'approvalUrl' => \yii\helpers\Url::home(true).'approvals/',
            'sendMail' => 1,
        ];

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

    public function actionGetleaves(){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];

        //Yii::$app->recruitment->printrr( );
        $leaves = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        foreach($leaves as $leave){


            $link = $updateLink =  '';
            $Viewlink = Html::a('Details',['view','ApplicationNo'=> $leave->Application_No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($leave->Approval_Status == 'New' ){
                $link = Html::a('Send Approval Request',['approval-request','app'=> $leave->Application_No ],['class'=>'btn btn-primary btn-xs']);
                $updateLink = Html::a('Update Leave',['update','ApplicationNo'=> $leave->Application_No ],['class'=>'btn btn-info btn-xs']);
            }else if($leave->Approval_Status == 'Approval_Pending'){
                $link = Html::a('Cancel Approval Request',['cancel-request','app'=> $leave->Application_No ],['class'=>'btn btn-warning btn-xs']);
            }



            $result['data'][] = [
                'Key' => $leave->Key,
                'Employee_No' => !empty($leave->Employee_No)?$leave->Employee_No:'',
                'Employee_Name' => !empty($leave->Employee_Name)?$leave->Employee_Name:'',
                'Application_No' => $leave->Application_No,
                'Days_Applied' => $leave->Days_Applied,
                'Application_Date' => $leave->Application_Date,
                'Approval_Status' => $leave->Approval_Status,
                'Leave_Status' => $leave->Leave_Status,
                'Action' => $link,
                'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
    }

    public function actionReport(){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
        $leaves = \Yii::$app->navhelper->getData($service);
        krsort( $leaves);//sort  keys in descending order
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



    public function getLeaveTypes($gender = ''){
        $service = Yii::$app->params['ServiceName']['leaveTypes'];
        $filter = [
            'Gender' => $gender,
            'Gender' => !empty(Yii::$app->user->identity->Employee[0]->Gender)?Yii::$app->user->identity->Employee[0]->Gender:'Both'
        ];

        $leavetypes = \Yii::$app->navhelper->getData($service,$filter);
        return $leavetypes;
    }

    public function getEmployees(){
        $service = Yii::$app->params['ServiceName']['employees'];

        $employees = \Yii::$app->navhelper->getData($service);
        return $employees;
    }

    /*Get Active Leaves*/

    public function actionGetactiveleaves(){
        $service = Yii::$app->params['ServiceName']['activeLeaveList'];

        $active = \Yii::$app->navhelper->getData($service);
        if(is_array($active)){
            krsort($active);//sort  keys in descending order
        }


        //Yii::$app->recruitment->printrr($active);
        $result = [];
        foreach($active as $leave){

            $result['data'][] = [
                'Key' => !empty($leave->Key)?$leave->Key:'',
                'Application Code' => !empty($leave->Application_Code)?$leave->Application_Code:'',
                'Employee_Name' => !empty($leave->Names)?$leave->Names:'',
                'Days_Applied' => $leave->Days_Applied,
                'Start_Date' => $leave->Start_Date,
                'Return_Date' => $leave->Return_Date,
                'End_Date' => $leave->End_Date,
                'Leave_Type' => !empty($leave->Leave_Type)?$leave->Leave_Type:'',
                'Status' => $leave->Status,
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