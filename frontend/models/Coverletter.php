<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/11/2020
 * Time: 3:51 AM
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Coverletter extends Model
{

    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $Attachement_path;
    public $sharepointUrl;
    public $metadata = [];

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Cover Letter',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('qualifications/' .str_replace(' ','',$this->imageFile->name));
            $this->Attachement_path = 'qualifications/'.str_replace(' ','',$this->imageFile->name);

            $this->sharepointUrl = 'https://aaofsciences.sharepoint.com/Portal/'.str_replace(' ','',$this->imageFile->name);

            //Sharepoint Metadata
            $this->metadata = [
                'profileid' => \Yii::$app->recruitment->getProfileID(),
                'documenttype' => 'Application Cover Letter',
                'description' => 'Cover Letter',
            ];
            Yii::$app->session->set('metadata',$this->metadata);

            Yii::$app->recruitment->sharepoint_attach($this->Attachement_path);

            //Update Job Applicant Card
            $applicationService = Yii::$app->params['ServiceName']['HRJobApplicationsCard'];
            $filter = [
                'Job_Application_No' => \Yii::$app->session->get('Job_Application_No'),//Yii::$app->recruitment->getProfileID(),
            ];
           // Yii::$app->recruitment->printrr($filter);
            $application = Yii::$app->navhelper->getData($applicationService,$filter);
            $updateData = [
                'Key' => $application[0]->Key,
                'Cover_Letter' => $this->sharepointUrl
            ];
            $res = Yii::$app->navhelper->updateData($applicationService,$updateData);

            //Yii::$app->recruitment->printrr($res);

            return true;
        } else {
            return false;
        }
    }

    public function getPath(){

        $service = Yii::$app->params['ServiceName']['HRJobApplicationsCard'];
        $filter = [
            'Job_Application_No' => \Yii::$app->session->get('Job_Application_No')
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)) {
            return basename($result[0]->Cover_Letter);
        }else{
            return false;
        }

    }
}