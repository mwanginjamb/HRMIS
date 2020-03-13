<?php

namespace frontend\models;

use common\models\Hruser;
use common\models\User;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyEmailForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var User
     */
    private $_user;


    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        $this->_user = User::findByVerificationToken($token);//find an erp user - default identity
        $this->_user = Hruser::findByVerificationToken($token);//Find a hr user

        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return User|null the saved model or null if saving fails
     */
    public function verifyEmail($HRUser = false)
    {
        $user = $this->_user;


        if($HRUser){
            $user->status = Hruser::STATUS_ACTIVE;
            return $user->save(false) ? $user : null;
        }
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}
