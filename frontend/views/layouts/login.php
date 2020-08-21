<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 4:19 PM
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AdminlteAsset;
use common\widgets\Alert;

AdminlteAsset::register($this);
$this->title = 'Welcome to the AAS Integrated Systems Portal';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>

<div class="top-logo">
    <img src="<?= \yii\helpers\Url::to('/images/Logo.png')?>" />
</div>

<div class="login-logo">
    <a href="#"><b><?= $this->title ?></a>
</div>
<!-- /.login-logo -->
<div class="card">
    <div class="card-body login-card-body">
        <!--<p class="login-box-msg">Sign in to start your session</p>-->

        <?= $content?>

        <!--<div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
        </div>-->

    </div>
    <!-- /.login-card-body -->
</div>
</div>


</body>
<footer class="footer" style="color: #fff3cd">
    <strong>Copyright &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b><?php Yii::signature() ?></b>
    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>


