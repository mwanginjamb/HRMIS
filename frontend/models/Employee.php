<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace frontend\models;


use yii\base\Model;

class Employee extends Model
{
    public $Key;
    public $No;
    public $First_Name;
    public $Middle_Name;
    public $Last_Name;
    public $ID_Number;
    public $Passport_Number;
    public $Citizenship;
    public $Responsibility_Center;
    public $_x003C_GlobSal_Dimension_1_Code_x003E_;
    public $Global_Dimension_2_Code;
    public $Title;
    public $User_ID;
    public $Supervisor_Code;
    public $Supervisor_Name;
    public $Last_Date_Modified;
    public $Last_Date_Modified_By;
    public $Status;
    public $Gender;
    public $Marital_Status;
    public $Religion;
    public $First_Language_R_W_S;
    public $First_Language_Read;
    public $First_Language_Write;
    public $First_Language_Speak;
    public $Second_Language_R_W_S;
    public $Second_Language_Read;
    public $Second_Language_Write;
    public $Second_Language_Speak;
    public $Additional_Language;
    public $Vehicle_Registration_Number;
    public $Number_Of_Dependants;
    public $Disabled;
    public $Home_Phone_Number;
    public $Cellular_Phone_Number;
    public $Work_Phone_Number;
    public $E_Mail;
    public $Company_E_Mail;
    public $Post_Code;
    public $Postal_Address;
    public $City;
    public $County;
    public $Date_Of_Birth;
    public $DAge;
    public $Date_Of_Join;
    public $DService;
    public $Probation_Duration;
    public $End_Of_Probation_Date;
    public $Retirement_date;
    public $Pension_Scheme_Join_Date;
    public $Dretire;
    public $DPension;
    public $Medical_Scheme_Join_Date;
    public $DMedical;
    public $Wedding_Anniversary;
    public $Job_ID;
    public $Job_Title;
    public $Salary_Grade;
    public $Grade;
    public $Posting_Group;
    public $Professional_Body;
    public $Effective_From_Date;
    public $Expiry_Date;
    public $Contract_Type;
    public $Contract_End_Date;
    public $Notice_Period;
    public $Send_Alert_to;
    public $PIN_No;
    public $NSSF_No;
    public $NHIF_No;
    public $No_Of_Bank_A_Cs;
    public $Reimbursed_Leave_Days;
    public $Allocated_Leave_Days;
    public $Total_Leave_Days;
    public $Total_Leave_Taken;
    public $Acrued_Leave_Days;
    public $Leave_Bal;
    public $Cash_Leave_Earned;
    public $Cash_per_Leave_Day;
    public $Date_Of_Leaving_the_Company;
    public $Termination_Grounds;
    public $Exit_Interview_Date;
    public $Exit_Interview_Done_by;
    public $Activate;
    public $ProfileID;

    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

        ];
    }

}