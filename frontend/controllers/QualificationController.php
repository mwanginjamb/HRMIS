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
use yii\web\UploadedFile;
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
                'only' => ['getqualifications','getprofessionalqualifications'],
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

     public function actionProfessional(){

        return $this->render('professional');

    }


    public function actionCreate(){

        $model = new Qualification();
        $service = Yii::$app->params['ServiceName']['qualifications'];

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Qualification'],$model)){
            list($code, $desc) = explode(' - ',Yii::$app->request->post()['Qualification']['Qualification_Code']);
            $model->Qualification_Code = $code;
            $model->Description = $desc;

            $model->Employee_No = Yii::$app->recruitment->getProfileID();

             if(!empty($_FILES['Qualification']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
            $result = Yii::$app->navhelper->postData($service,$model);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Qualification Added Successfully',true);
                return $this->redirect(['index']);

            }else{

                Yii::$app->session->setFlash('error','Error Adding Qualification: '.$result,true);
                return $this->redirect(['index']);

            }

        }//End Saving experience

        $qList = $this->getQualificationsList();

        /*print '<pre>';
        print_r($qualificationsList);exit;*/
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'qlist' => ArrayHelper::map($qList,'Code', 'Description')

            ]);
        }

        return $this->render('create',[

            'model' => $model,
            


        ]);
    }

    public function actionCreateprofessional(){

        $model = new Qualification();
        $service = Yii::$app->params['ServiceName']['qualifications'];

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Qualification'],$model)){


            list($code, $desc) = explode(' - ',Yii::$app->request->post()['Qualification']['Qualification_Code']);
            $model->Qualification_Code = $code;
            $model->Description =  $desc;

            $model->Employee_No = Yii::$app->recruitment->getProfileID();
             if(!empty($_FILES['Qualification']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
            $result = Yii::$app->navhelper->postData($service,$model);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Professional Qualification Added Successfully',true);
                return $this->redirect(['professional']);

            }else{

                Yii::$app->session->setFlash('error','Error Adding Professional Qualification: '.$result,true);
                return $this->redirect(['professional']);

            }

        }//End Saving experience

        $qList = $this->getProfessionalQualificationsList();

        /*print '<pre>';
        print_r($qualificationsList);exit;*/
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'qlist' => ArrayHelper::map($qList,'Code', 'Description')

            ]);
        }

        return $this->render('create',[

            'model' => $model,

        ]);
    }

    public function actionUpdate(){
        $service = Yii::$app->params['ServiceName']['qualifications'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);
        $Expmodel = new Qualification();
        //load nav result to model
        $model = $this->loadtomodel($result[0],$Expmodel);

        

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Qualification'],$model)){


            list($code, $desc) = explode(' - ',Yii::$app->request->post()['Qualification']['Qualification_Code']);
            $model->Qualification_Code = $code;
            $model->Description =  $desc;

             if(!empty($_FILES['Qualification']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
            $result = Yii::$app->navhelper->updateData($service,$model);


            if(!empty($result) && !is_string($result)){
                Yii::$app->session->setFlash('success','Qualification Updated Successfully',true);
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Qualification : '.$result,true);
                return $this->redirect(['index']);
            }

        }
        $qualificationsList = $this->getQualificationsList();
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'qualifications' => ArrayHelper::map($qualificationsList,'Code','Description')

            ]);
        }

        return $this->render('update',[
            'model' => $model,

        ]);
    }


     public function actionUpdateprofessional(){
        $service = Yii::$app->params['ServiceName']['qualifications'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);
        $Expmodel = new Qualification();
        //load nav result to model
        $model = $this->loadtomodel($result[0],$Expmodel);

        

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Qualification'],$model)){

            list($code, $desc) = explode(' - ',Yii::$app->request->post()['Qualification']['Qualification_Code']);
            $model->Qualification_Code = $code;
            $model->Description = $desc;

             if(!empty($_FILES['Qualification']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
            $result = Yii::$app->navhelper->updateData($service,$model);


            if(!empty($result) && !is_string($result)){
                Yii::$app->session->setFlash('success','Professional Qualification Updated Successfully',true);
                return $this->redirect(['professional']);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Professional Qualification : '.$result,true);
                return $this->redirect(['professional']);
            }

        }
        $qualificationsList = $this->getProfessionalQualificationsList();
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'qualifications' => ArrayHelper::map($qualificationsList,'Code','Description')

            ]);
        }

        return $this->render('update',[
            'model' => $model,

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['qualifications'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Qualification Purged Successfully .',true);
            if(!empty(Yii::$app->request->get('path'))){
                //$file = Yii::$app->recruitment->absoluteUrl().Yii::$app->request->get('path');
                unlink(Yii::$app->request->get('path'));
            }
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Purging Qualification: '.$result,true);
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

    public function actionGetqualifications(){
        $service = Yii::$app->params['ServiceName']['qualifications'];

        $filter = [
            'Qualification_Code' => 'ACADEMIC'
        ];
        $qualifications = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $count = 0;
        foreach($qualifications as $quali){

            ++$count;
            $link = $updateLink =  '';


            $updateLink = Html::a('<i class="fa fa-edit"></i>',['update','Line'=> $quali->Line_No ],['class'=>'update btn btn-outline-info btn-xs','title' => 'Update Qualification']);

            if(!empty($quali->Attachement_path)){
                $deletelink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key,'path' => $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs','title' => 'Remove Qualification','data' => [
                    'confirm' => 'Are you sure you want to delete this qualification?',
                    'method' => 'post',
                ]]);
            }else{
                $deletelink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-xs','title' => 'Remove Qualification','data' => [
                    'confirm' => 'Are you sure you want to delete this qualification?',
                    'method' => 'post',
                ]]);
            }

            //for sharepoint use "download" for local fs use "read"
            $qualificationLink = !empty($quali->Attachement_path)? Html::a('View Document',['download','path'=> $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs']):$quali->Qualification_Code;


            $result['data'][] = [
                'index' => $count,
                'Key' => $quali->Key,
                'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                'Qualification_Code' => $qualificationLink,
                'From_Date' => !empty($quali->From_Date)?$quali->From_Date:'',
                'To_Date' => !empty($quali->To_Date)?$quali->To_Date:'',
                'Description' => !empty($quali->Description)?$quali->Description:'',
                'Institution_Company' => !empty($quali->Institution_Company)?$quali->Institution_Company:'',
                //'Comment' => !empty($quali->Comment)?$quali->Comment:'',

                'Action' => $updateLink.' | '.$deletelink,
                //'Remove' => $link
            ];
        }

        return $result;
    }

   
 public function actionGetprofessionalqualifications(){
        $service = Yii::$app->params['ServiceName']['qualifications'];

        $filter = [
            'Qualification_Code' => 'PROFESSIONAL'
        ];
        $qualifications = \Yii::$app->navhelper->getData($service,$filter);

        //print '<pre>';
        //print_r($qualifications); exit;

        $result = [];
        $count = 0;
        foreach($qualifications as $quali){

            ++$count;
            $link = $updateLink =  '';


            $updateLink = Html::a('<i class="fa fa-edit"></i>',['updateprofessional','Line'=> $quali->Line_No ],['class'=>'update btn btn-outline-info btn-xs']);

            $link = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-xs','data' => [
                'confirm' => 'Are you sure you want to delete this qualification?',
                'method' => 'post',
            ]]);

            $qualificationLink = !empty($quali->Attachement_path)? Html::a('View Document',['read','path'=> $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs']):$quali->Qualification_Code;


            $result['data'][] = [
                'index' => $count,
                'Key' => $quali->Key,
                'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                'Qualification_Code' => $qualificationLink,
                'From_Date' => !empty($quali->From_Date)?$quali->From_Date:'',
                'To_Date' => !empty($quali->To_Date)?$quali->To_Date:'',
                'Description' => !empty($quali->Description)?$quali->Description:'',
                'Institution_Company' => !empty($quali->Institution_Company)?$quali->Institution_Company:'',
                //'Comment' => !empty($quali->Comment)?$quali->Comment:'',

                'Action' => $updateLink.' | '.$link,
                //'Remove' => $link
            ];
        }

        return $result;
    }
    

  



    public function getQualificationsList(){
        $service = Yii::$app->params['ServiceName']['HRqualifications'];
        $filter = ['Code' => 'Academic'];

        $qualifications = \Yii::$app->navhelper->getData($service,$filter);

        $res = [];

         foreach($qualifications  as $c){
            if(!empty($c->Description) && !empty($c->Code)){
                $res[] = [
                    'Code' => $c->Code .' - '.$c->Description,
                    'Description' =>  $c->Code .' - '.$c->Description
                ];
            }
                
        }

        return $res;
    }

    public function getProfessionalQualificationsList(){
        $service = Yii::$app->params['ServiceName']['HRqualifications'];
        $filter = ['Code' => 'PROFESSIONAL'];

        $qualifications = \Yii::$app->navhelper->getData($service,$filter);

        $res = [];

         foreach($qualifications  as $c){
            if(!empty($c->Description) && !empty($c->Code)){
                $res[] = [
                    'Code' => $c->Code .' - '.$c->Description,
                    'Description' =>  $c->Code .' - '.$c->Description
                ];
            }
                
        }

        return $res;
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

    public function loadtomodel($obj,$model){ //load object data to a model

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

    public function loadpost($post,$model){ // load form data to a model


        $modeldata = (get_object_vars($model)) ;

        foreach($post as $key => $val){

            $model->$key = $val;
        }

        return $model;
    }

    public function actionRead($path){
        $absolute = Yii::$app->recruitment->absoluteUrl().$path;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $fh = file_get_contents($absolute); //read file into a string or get a file handle resource from sharepoint
        $mimetype = $finfo->buffer($fh); //get mime type

        return $this->render('read',[
            'mimeType' => $mimetype,
            'documentPath' => $absolute
            ]);
    }

    public function actionDownload($path){
        $base = basename($path);
        $ctx = Yii::$app->recruitment->connectWithAppOnlyToken(
            Yii::$app->params['sharepointUrl'],
            Yii::$app->params['clientID'],
            Yii::$app->params['clientSecret']
        );
        $fileUrl = '/Mydocs/'.$base;
        $targetFilePath = './qualifications/download.pdf';
        $resource = Yii::$app->recruitment->downloadFile($ctx,$fileUrl,$targetFilePath);

        return $this->render('readsharepoint',[
            'content' => $resource
        ]);


    }
}