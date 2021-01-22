<?php
namespace common\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    private $_user;
    public $password;

    public function rules()
    {
        return [
            [['password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUserByPass();

        if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    /**
    * Logs in a user using the provided username and password.
    *
    * @return bool whether the user is logged in successfully
    */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUserByPass());
        }

        return false;
    }

    /**
    * Finds user by [[paswword]]
    *
    * @return User|null
    */
    protected function getUserByPass()
    {
        if ($this->_user === null) {
            $this->_user = User::findByPassword($this->password);
        }
        return $this->_user;
    }
}