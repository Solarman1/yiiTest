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

    public function getSize($appleId)
    {
        // return  Apples::find('EatingProcent')
        //                 ->where(['id' => $appleId])
        //                 ->one();
        $params = [':id' => $appleId];

        return  $post = Yii::$app->db->createCommand('SELECT EatingProcent FROM apples WHERE id=:id')
                        ->bindValues($params)
                        ->queryOne();
    }

    public function updateSize($appleId, $procent)
    {
        $command = Yii::$app->db->createCommand()->update('apples', [
            'EatingProcent'  => $procent,
        ], "id = $appleId")->execute();

        if($this->getSize($appleId) == 0)
        {
            die('this');
           return $this->deleteApple($appleId);
        }
            

        return $command ? $command : 0;     
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

        $color              = $colors[mt_rand(0,3)];      
        $cratedDate         = date('Y-m-d H:i:s', $randomDate);
        $fallToGroundDate   = null;
        $appleStatus        = 1;
        $eatingProcent      = 1;

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

    public function deleteApple($appleId)
    {
        return Yii::$app->db->createCommand()->delete('apples', "id = $appleId")->execute();
    }

}