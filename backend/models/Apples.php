<?php

namespace backend\models;


use Yii;

/**
* This is the model class for table "apples".
*
* @property integer $id
* @property string  $color
* @property string  $createDate
* @property string  $fallToGroundDate
* @property integer $appleStatus
* @property integer $eatingProcent
*
*/
class Apples extends \yii\db\ActiveRecord
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'apples';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
        'id'                => 'ID',
        'color'             => 'Color',
        'createDate'        => 'CreateDate',
        'fallToGroundDate'  => 'FallToGroundDate',
        'AppleStatus'       => 'AppleStatus',
        'EatingProcent'     => 'EatingProcent',
        ];
    }



    public static function getAll()
    {
        return Apples::find()->all();
    }

    public function generateApples()
    {
        $colors              = ['red', 'greend', 'yellow', 'brown'];
        $randomDate          = mt_rand(1, time());
        // print_r($crreateDate         = date($randomDate));
        // die();
        $this->color              = $colors[mt_rand(0,3)];      
        $this->createDate         = date('Y-m-d H:i:s', $randomDate);
        $this->fallToGroundDate   = null;
        $this->appleStatus        = ['1', '2', '3'];
        $this->eatingProcent      = null;

        //$command = Yii::$app->db->createCommand('INSERT ');

        return $this->save(false);
    }

}