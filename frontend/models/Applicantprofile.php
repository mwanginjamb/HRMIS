<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 11:45 AM
 */

namespace frontend\models;
use yii\base\Model;
use yii\web\UploadedFile;

class Applicantprofile extends Model
{

public $Key;
public $No;
public $First_Name;
public $Middle_Name;
public $Last_Name;
public $Initials;
public $Full_Name;
public $ID_Number;
public $Gender;
public $Date_Of_Birth;
public $Age;
public $Known_As;
public $Marital_Status;
public $Ethnic_Origin;
public $Disabled;
public $Citizenship;
public $Passport_Number;
public $Postal_Address;
public $Residential_Address;
public $City;
public $Post_Code;
public $County;
public $Home_Phone_Number;
public $Cellular_Phone_Number;
public $Work_Phone_Number;
public $E_Mail;
public $Country_Code;
public $Location_Division_Code;
public $Company_E_Mail;
public $Union_Member_x003F_;
public $NSSF_No;
public $NHIF_No;
public $HELB_No;
public $Tribe;
public $Religion;
public $Post_Office_No;
public $Picture;
public $imageFile;
public $ImageUrl;
public $Motivation; //not added on nav

    public function rules()
    {
        return [
            [['E_Mail','Gender','First_Name','Last_Name','Citizenship'], 'required'],
            [['Union_Member_x003F_'], 'boolean'],
            [['E_Mail','Company_E_Mail'],'email'],
            [['Motivation'],'string','max' => 250],
            [['imageFile'],'file','mimeTypes' => ['image/png','image/jpeg']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Union_Member_x003F_' => 'Union Member ?',
            'Known_As' => 'Alias',
            'Motivation' => 'Letter of Motivation.',
            'imageFile' => 'Passport Size Photo'
        ];
    }

     public function upload()
    {
        if ($this->validate('imageFile')) {
            $this->imageFile->saveAs('profile/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->ImageUrl = 'profile/'.$this->imageFile->name;
            return true;
        } else {
            return $this->getErrors();
        }
    }
}




