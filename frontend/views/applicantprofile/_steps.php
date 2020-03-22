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
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'applicantprofile/'.$profileAction ?>" <?= Yii::$app->recruitment->currentaction('applicantprofile',['create','update'])?'class="active"': '' ?>>Personal Info</a>

    <?php if(Yii::$app->recruitment->hasProfile(Yii::$app->recruitment->getProfileID())): ?>


    	 <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'qualification/index' ?>" <?= Yii::$app->recruitment->currentaction('qualification','index')?'class="active"': '' ?>>Academic Qualifications</a>
        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'qualification/professional' ?>" <?= Yii::$app->recruitment->currentaction('qualification','professional')?'class="active"': '' ?>>Professional Qualifications</a>
        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'experience/index' ?>" <?= Yii::$app->recruitment->currentaction('experience','index')?'class="active"': '' ?>>Employment record</a>
       
        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'language/index' ?>" <?= Yii::$app->recruitment->currentaction('language','index')?'class="active"': '' ?>>Extended profile Questions</a>

        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'referee/index' ?>" <?= Yii::$app->recruitment->currentaction('referee','index')?'class="active"': '' ?>>Referees</a>

        <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/submit' ?>" <?= Yii::$app->recruitment->currentaction('recruitment','submit')?'class="active"': '' ?>>Submit Application</a>

    <?php endif; ?>

</div>


