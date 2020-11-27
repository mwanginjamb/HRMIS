<?php
namespace common\models;

use frontend\models\Appraisalheader;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::$app->params['CompanyNameStripped'].'User Setup ';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //['status', 'default', 'value' => self::STATUS_INACTIVE],
           // ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        if($id == 1){
            return null;
        }
        $username = strtoupper(Yii::$app->params['ldPrefix'].'\\'.$id);
        return static::findOne(['User ID' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $username = strtoupper(Yii::$app->params['ldPrefix'].'\\'.$username);

        return static::findOne(['User ID' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        return;
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return;
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        return;
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->{'User ID'};
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return 1;
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return 1;
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /*Do actual Active directory validation*/
        return true;
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        return;
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        return;
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        return;
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        return;
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        return;
        $this->password_reset_token = null;
    }

    public static function getDb(){
        return Yii::$app->nav;
    }

    public function getEmployee(){
        $service = Yii::$app->params['ServiceName']['employeeCard'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $employee = \Yii::$app->navhelper->getData($service,$filter);
        return $employee;
    }

    public function isSupervisor($AppraiseeNo = ''){
        //loop through user setup check if current identity appears in approvers column
        $super = Employee::find()->where(['Supervisor Code ' => $this->getId()])->count();

        if($super > 0){
            return true;
        }else{
            return false;
        }
    }

    public function isAppraisalSupervisor($AppraiseeNo = ''){

        if(Yii::$app->session->has('Appraisee_ID'))
        {
            $Appraisee_ID = Yii::$app->session->get('Appraisee_ID');
            //check if current identity appears as supervisor with corresponsing Employee_User_Id
            $super = \common\models\AppraisalHeader::find()->where([
                'Supervisor User Id ' => $this->getId(),
                'Employee User Id ' => $Appraisee_ID
                ])->count();

            if($super > 0){
                return true;
            }else{
                return false;
            }
        }else {
            Yii::$app->session->setFlash('error', 'Appraisee Employee_User_ID state is missing.');
            return false;

        }
    }

    // Loggedin User is designated as an appraisal Supervisor

    public function isAppraisalSupervisorDesignate($AppraiseeNo = ''){

            //check if current identity is designated as supervisor for any employee
            $super = \common\models\AppraisalHeader::find()->where([
                'Supervisor User Id ' => $this->getId()
            ])->count();

            if($super > 0){
                return true;
            }else{
                return false;
            }

    }

    public function isPeer1(){
        //loop through user setup check if current identity appears in approvers column
        $super = Appraisalheader::find()->where(['Peer 1 Employee No ' => $this->{'Employee No_'}])->count();

        if($super > 0){
            return true;
        }else{
            return false;
        }
    }

    public function isPeer2(){
        //loop through user setup check if current identity appears in approvers column
        $super = Appraisalheader::find()->where(['Peer 2 Employee No ' => $this->{'Employee No_'}])->count();

        if($super > 0){
            return true;
        }else{
            return false;
        }
    }



}
