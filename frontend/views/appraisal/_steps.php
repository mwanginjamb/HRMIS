<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/11/2020
 * Time: 12:17 PM
 */

$profileAction = (Yii::$app->session->has('ProfileID') && Yii::$app->recruitment->hasProfile(Yii::$app->session->get('ProfileID')))?'update?No='.Yii::$app->session->get('ProfileID'):'create';

//var_dump(Yii::$app->recruitment->hasProfile(Yii::$app->session->get('ProfileID')));
?>

<!-- another version - flat style with animated hover effect -->
<div class="breadcrumbb flat">

        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'appraisal/view?Employee_No='.$model->Employee_No.'&Appraisal_No='.$model->Appraisal_No ?>" <?= ($model->Goal_Setting_Status == 'New') ?'class="active"': '' ?>>Goal Setting</a>
        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'appraisal/myappraiseelist' ?>" <?= ($model->Goal_Setting_Status == 'Approved' && $model->MY_Appraisal_Status == 'Appraisee_Level')?'class="active"': '' ?>>Mid Year Appraisal</a>

       
        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'appraisal/view?Employee_No='.$model->Employee_No.'&Appraisal_No='.$model->Appraisal_No ?>" <?= ($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Appraisee_Level')?'class="active"': '' ?>>End Year Appraisal</a>

        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'appraisal/view?Employee_No='.$model->Employee_No.'&Appraisal_No='.$model->Appraisal_No ?>" <?= ($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Agreement_Level')?'class="active"': '' ?>>Training Plan & Training Assessment</a>

        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'appraisal/eyappraiseeclosedlist' ?>" <?= ($model->EY_Appraisal_Status == 'Closed')?'class="active"': '' ?>>Closed Appraisals</a>


</div>


