<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentstrength;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Leaveplancard;
use frontend\models\Trainingplan;
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

class LeaveplanController extends Controller
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
                'only' => ['getleaveplans'],
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

        $model = new Leaveplancard() ;
        $service = Yii::$app->params['ServiceName']['LeavePlanCard'];
        $request = Yii::$app->navhelper->postData($service,[]);

        $filter = [];

        if(is_object($request))
        {
            $filter = [
                'Plan_No' => $request->Plan_No,
            ];
        }

        //Yii::$app->recruitment->printrr($request);


        $leaveplan = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $model = $this->loadtomodel($leaveplan[0], $model);

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }


    public function actionUpdate(){
        $model = new Careerdevelopmentstrength() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['CareerDevStrengths'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line_No'),
            'Employee_No' => Yii::$app->request->get('Employee_No'),
            'Appraisal_No' => Yii::$app->request->get('Appraisal_No')
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Careerdevelopmentstrength'],$model) ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!empty($result)){

                return ['note' => '<div class="alert alert-success">Career Development Strength Updated Successfully.</div>'];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Career Development Strength Line: '.$result.'</div>.' ];
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
        $service = Yii::$app->params['ServiceName']['CareerDevStrengths'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($Plan_No){
        $service = Yii::$app->params['ServiceName']['LeavePlanCard'];

        $filter = [
            'Plan_No' => $Plan_No
        ];

        $leaveplan = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $model = $this->loadtomodel($leaveplan[0], new Leaveplancard());

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }

    // Get leave plan list

    public function actionGetleaveplans(){
        $service = Yii::$app->params['ServiceName']['LeavePlanList'];
        $filter = [
            //'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];

        //Yii::$app->recruitment->printrr( );
        $leaves = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        foreach($leaves as $leave){


            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('Details',['view','Plan_No'=> $leave->Plan_No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($leave->Status == 'Open'){
                $link = Html::a('Send Approval Request',['approval-request','Plan_No'=> $leave->Plan_No ],['class'=>'btn btn-primary btn-xs']);

                $updateLink = Html::a('Update Leave',['update','Plan_No'=> $leave->Plan_No ],['class'=>'btn btn-info btn-xs']);
            }else if($leave->Approval_Status == 'Approval_Pending'){
                $link = Html::a('Cancel Approval Request',['cancel-request','Plan_No'=> $leave->Plan_No ],['class'=>'btn btn-warning btn-xs']);
            }


            $result['data'][] = [
                'Key' => $leave->Key,
                'Employee_No' => !empty($leave->Employee_No)?$leave->Employee_No:'',
                'Employee_Name' => !empty($leave->Employee_Name)?$leave->Employee_Name:'',
                'Plan_No' => $leave->Plan_No,
                'Department' => !empty($leave->Global_Dimension_1_Code)?$leave->Global_Dimension_1_Code:'',
                'Branch' => !empty($leave->Global_Dimension_2_Code)?$leave->Global_Dimension_2_Code:'',
                'Leave_Calender_Code' => !empty($leave->Leave_Calender_Code)?$leave->Leave_Calender_Code:'',
                'Status' => $leave->Status,
                'Action' => $link,
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