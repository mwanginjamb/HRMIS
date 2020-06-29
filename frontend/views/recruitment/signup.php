<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//$this->title = 'HRMIS - SignUp';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>Please fill out the following fields to signup:</p>



            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username',[
                    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span>{input}</div>'
                ])->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Username'
                    ])->label(false) ?>

                <?= $form->field($model, 'email',[
                    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span>{input}</div>'
                ])->textInput(['placeholder' => 'Your E-mail Address'])->label(false) ?>

                <?= $form->field($model, 'password',[
                    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span>{input}</div>'
                ])->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                <?= $form->field($model, 'confirmpassword',[
                    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span>{input}</div>'
                ])->passwordInput(['placeholder' => 'Confirm your Password','required' => true])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-warning', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>


</div>

<?php

$style = <<<CSS
    .login-page { 
          background: url("../../images/login.png") no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
    }
    
    .top-logo {
        display: flex;
        margin-left: 10px;
       
    }
     .top-logo img { 
                width: 120px;
                height: auto;
                position: absolute;
                left: 15px;
                top:15px;
                
          
            }
     .login-logo a  {
        color: #f6c844!important;
        font-family: sans-serif, Verdana;
        font-size: larger;
        font-weight: 400;
     }
     
     input.form-control {
        border-left: 0!important;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border: 1px solid #f6c844;
    }
    
    span.input-group-text {
        border-right: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border: 1px solid #f6c844;
    }

    .card {
    background-color: rgba(0,0,0,.1);
   }
   
   .login-card-body {
     background-color: rgba(0,0,0,.1);
   }
CSS;

$this->registerCss($style);
