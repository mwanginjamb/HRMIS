<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:27 PM
 */

namespace common\library;
use yii;
use yii\base\Component;


class Recruitment extends Component
{
    public function absoluteUrl(){
        return \yii\helpers\Url::home(true);
    }

    public function currentaction($ctrl,$actn){//modify it to accept an array of controllers as an argument--> later please
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        if($controller == $ctrl && $action == $actn){
            return true;
        }else{
            return false;
        }
    }
}