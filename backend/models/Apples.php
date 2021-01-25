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

    public function fallToGround($appleId)
    {
        $this->findOne($appleId);
        $this->fallToGroundDate = date('Y-m-d H:i:s', time());
        $this->appleStatus      = 2;

        return $this->update(false);
    }


    public static function getAll()
    {
       // return Apples::find()->orderBy(['id'=> SORT_DESC])->one();
       return Apples::find()->all();
    }

    public function generateApples()
    {
        
        $colors              = ['red', 'green', 'yellow', 'brown'];
        $randomDate          = mt_rand(1, time());
        // print_r($crreateDate         = date($randomDate));
        // die();
        $color              = $this->color              = $colors[mt_rand(0,3)];      
        $cratedDate         = $this->createDate         = date('Y-m-d H:i:s', $randomDate);
        $fallToGroundDate   = $this->fallToGroundDate   = null;
        $appleStatus        = $this->appleStatus        = 1;
        $eatingProcent      = $this->eatingProcent      = null;

        $command = Yii::$app->db->createCommand()->insert('apples', [
            'color'             => $color,
            'createDate'        => $cratedDate,
            'fallToGroundDate'  => $fallToGroundDate,
            'AppleStatus'       => $appleStatus,
            'EatingProcent'     => $eatingProcent,
            ])->execute();

        // Yii::$app->db->transaction(function($db) {
        //     $db->createCommand($sql1)->execute();
        //     $db->createCommand($sql2)->execute();
        //     // ... executing other SQL statements ...
        // });
        
        return  $command;
    }

}