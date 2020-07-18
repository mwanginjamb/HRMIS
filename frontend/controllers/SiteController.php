<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Office365\PHP\Client\Runtime\OData\JsonFormat;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */



    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','getemployee'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
                /*'denyCallback' => function ($rule, $action) {
                    //throw new \Exception('You are not allowed to access this page');
                    return $this->goBack();
                }*/
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    ///'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $employee = $this->actionGetemployee()[0];
        $supervisor = isset($employee->Supervisor_Code)?$this->getSupervisor($employee->Supervisor_Code):'';
        $balances = $this->Getleavebalance();

        //print '<pre>'; print_r($balances); exit;

        return $this->render('index',[
            'employee' => $employee,
            'supervisor' => $supervisor,
            'balances' => $balances
            ]);
    }

    public function actionOpenrequests()
    {
        return $this->render('openrequests', [

        ]);
    }

    public function actionApprovedrequests()
    {
        return $this->render('approvedrequests', [

        ]);
    }

    public function actionRejectedrequests()
    {
        return $this->render('rejectedrequests', [

        ]);
    }

    public function actionSupervisorrejected()
    {
        return $this->render('supervisorrejected', [

        ]);
    }

    public function actionSupervisorapproved()
    {
        return $this->render('supervisorapproved', [

        ]);
    }

    public function actionPendingapprovals()
    {
        return $this->redirect(['./approvals']);
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

        $model = new LoginForm();


        if ($model->load(Yii::$app->request->post()) && $model->login()  ) {

            //var_dump($model->login()); exit;
            return $this->goBack();

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {

        if(Yii::$app->session->has('IdentityPassword')){
            Yii::$app->session->remove('IdentityPassword');
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionGetemployee(){

        $service = Yii::$app->params['ServiceName']['employeeCard'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $employee = \Yii::$app->navhelper->getData($service,$filter);
        return $employee;
    }

    public function getSupervisor($userID){
        $service = Yii::$app->params['ServiceName']['employeeCard'];
        $filter = [
            'User_ID' => $userID
        ];
        $supervisor = \Yii::$app->navhelper->getData($service,$filter);
        //Yii::$app->recruitment->printrr($filter);
        if(is_array($supervisor)){
            return $supervisor[0];
        }else{
            return false;
        }
        
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

    // Get Open Requests

    function actionGetopenrequests()
    {
        $result = [];
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Open'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return [];
        }else {
            $count = 0;
            krsort($result);
            foreach( $result as $app){
                $count++;
                $detailsLink = Html::a('<i class="fa fa-eye"></i>',['leave/view','ApplicationNo'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);

                $result['data'][] = [
                    'Key' => $app->Key,
                    'id' => $count,
                    'Details' => $app->Details,
                    'Comment' => $app->Comment,
                    'Sender_ID' => $this->getName($app->Sender_ID),
                    'Due_Date' => $app->Due_Date,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }

        return $result;

    }

    function actionGetapprovedrequests()
    {
        $result = [];
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return [];
        }else {
            $count = 0;
            krsort($result);
            foreach( $result as $app){
                $count++;

                $detailsLink = Html::a('<i class="fa fa-eye"></i>',['leave/view','ApplicationNo'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);

                $result['data'][] = [
                    'Key' => $app->Key,
                    'id' => $count,
                    'Details' => $app->Details,
                    'Comment' => $app->Comment,
                    'Sender_ID' => $this->getName($app->Sender_ID),
                    'Due_Date' => $app->Due_Date,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }

        return $result;

    }



    function actionGetrejectedrequests()
    {
        $result = [];
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return [];
        }else {
            $count = 0;
            krsort($result);
            foreach( $result as $app){
                $count++;

                $detailsLink = Html::a('<i class="fa fa-eye"></i>',['leave/view','ApplicationNo'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);

                $result['data'][] = [
                    'Key' => $app->Key,
                    'id' => $count,
                    'Details' => $app->Details,
                    'Comment' => $app->Comment,
                    'Sender_ID' => $this->getName($app->Sender_ID),
                    'Due_Date' => $app->Due_Date,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }

        return $result;

    }

    function actionGetsupervisorapproved()
    {
        $result = [];
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return [];
        }else {
            $count = 0;
            krsort($result);
            foreach( $result as $app){
                $count++;

                $detailsLink = Html::a('<i class="fa fa-eye"></i>',['leave/view','ApplicationNo'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);

                $result['data'][] = [
                    'Key' => $app->Key,
                    'id' => $count,
                    'Details' => $app->Details,
                    'Comment' => $app->Comment,
                    'Sender_ID' => $this->getName($app->Sender_ID),
                    'Due_Date' => $app->Due_Date,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }

        return $result;

    }


    function actionGetsupervisorrejected()
    {
        $result = [];
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return [];
        }else {
            $count = 0;
            krsort($result);
            foreach( $result as $app){
                $count++;

                $detailsLink = Html::a('<i class="fa fa-eye"></i>',['leave/view','ApplicationNo'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);

                $result['data'][] = [
                    'Key' => $app->Key,
                    'id' => $count,
                    'Details' => $app->Details,
                    'Comment' => $app->Comment,
                    'Sender_ID' => $this->getName($app->Sender_ID),
                    'Due_Date' => $app->Due_Date,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }

        return $result;

    }



    public function getName($userID){

        //get Employee No
        $user = \common\models\User::find()->where(['User ID' => $userID])->one();
        $No = $user->{'Employee No_'};
        //Get Employees full name
        $service = Yii::$app->params['ServiceName']['employees'];
        $filter = [
            'No' => $No
        ];

        $results = Yii::$app->navhelper->getData($service,$filter);
        return $results[0]->Full_Name;
    }
}
