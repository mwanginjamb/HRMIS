<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/11/2020
 * Time: 12:17 PM
 */


?>

<!-- another version - flat style with animated hover effect -->
<div class="breadcrumbb flat">
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'applicantprofile/create' ?>" <?= Yii::$app->recruitment->currentaction('applicantprofile','create')?'class="active"': '' ?>>General Information</a>
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'experience/index' ?>" <?= Yii::$app->recruitment->currentaction('experience','index')?'class="active"': '' ?>>Experience</a>
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'referee/index' ?>" <?= Yii::$app->recruitment->currentaction('referee','index')?'class="active"': '' ?>>Referees</a>
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'language/index' ?>" <?= Yii::$app->recruitment->currentaction('language','index')?'class="active"': '' ?>>Languages</a>
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'hobby/index' ?>" <?= Yii::$app->recruitment->currentaction('hobby','index')?'class="active"': '' ?>>Hobbies</a>
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'qualification/index' ?>" <?= Yii::$app->recruitment->currentaction('qualification','index')?'class="active"': '' ?>>Qualifications</a>
    <a href="<?=  Yii::$app->recruitment->absoluteUrl() .'recruitment/submit' ?>" <?= Yii::$app->recruitment->currentaction('recruitment','submit')?'class="active"': '' ?>>Submit Application</a>
</div>


