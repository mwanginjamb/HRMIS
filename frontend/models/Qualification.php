<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class Qualification extends Model
{
    public $Key;
    public $Employee_No;
    public $Qualification_Code;
    public $From_Date;
    public $To_Date;
    public $Description;
    public $Institution_Company;
    public $Comment;
    public $Line_No;
    public $Attachement_path;
    public $ImageUrl;
    public $imageFile;



    public function rules()
    {
        return [

            [['Employee_No'],'required'],
            [['imageFile'],'file','mimeTypes' => Yii::$app->params['QualificationsMimeTypes']]

        ];
    }

    public function attributeLabels()
    {
        return [
            'To_Date' => 'Completion Date',
            'Employee_No' => 'Profile ID',
            'imageFile' => 'Qualification Attachment'
        ];
    }

    public function upload()
    {
        if ($this->validate('imageFile')) {
            $this->imageFile->saveAs('qualifications/' . str_replace(' ','',$this->imageFile->baseName) . '.' . $this->imageFile->extension);
            $this->Attachement_path = 'qualifications/'.str_replace(' ','',$this->imageFile->name);
            //You can then attach to sharepoint and unlink the resource on local file system
            Yii::$app->recruitment->sharepoint_attach($this->Attachement_path);
            return true;
        } else {
            return $this->getErrors();
        }
    }


}