<?php

namespace common\models;


use Yii;
use yii\web\IdentityInterface;

/**
* This is the model class for table "user".
*
* @property integer $id
* @property string $password
*
*/
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'user';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
        [['password'], 'string', 'max' => 255],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
        'id' => 'ID',
        'password' => 'Password',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email'=>$email])->one();
    }

    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }

    public static function findByPassword($password)
    {
        return User::find()->where(['password' => $password])->one();
    }
}