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
        $command = Yii::$app->db->createCommand()->update('apples', [
            'fallToGroundDate'  => date('Y-m-d H:i:s', time()),
            'AppleStatus'       => 2,
        ], "id = $appleId")->execute();

        return $command;
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
        $color              = $colors[mt_rand(0,3)];      
        $cratedDate         = date('Y-m-d H:i:s', $randomDate);
        $fallToGroundDate   = null;
        $appleStatus        = 1;
        $eatingProcent      = null;

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