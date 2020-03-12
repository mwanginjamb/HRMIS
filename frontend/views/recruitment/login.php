<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->params['breadcrumbs'][] = $this->title;
?>





            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>



                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>



                <?= $form->field($model, 'password')->passwordInput() ?>



                <?= $form->field($model, 'rememberMe')->checkbox() ?>


                <div style="color:#999;margin:1em 0; display: none">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    <?= Html::a('signup', ['/site/signup'],['class' => 'btn btn-warning']) ?>
                </div>

    <?php ActiveForm::end(); ?>



<?php

$style = <<<CSS
            .login-page { 
          background: url("../../images/2 - 46569988015_a6687614de_b.jpg") no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
    }
CSS;

$this->registerCss($style);






    






