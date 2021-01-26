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
            [['eatingProcent'], 'required'],
            ['eatingProcent', 'integer', 'max' => 100],
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
        'appleStatus'       => 'AppleStatus',
        'eatingProcent'     => 'EatingProcent',
        ];
    }

    public function fallToGround($appleId)
    {
        $command = Yii::$app->db->createCommand()->update('apples', [
            'fallToGroundDate'  => date('Y-m-d H:i:s', time()),
            'appleStatus'       => 2,
        ], "id = $appleId")->execute();

        return $command;
    }

    public function getSize($appleId)
    {
        $params = [':id' => $appleId];

        $post = Yii::$app->db->createCommand('SELECT eatingProcent FROM apples WHERE id=:id')
                         ->bindValues($params)
                         ->queryOne();
        
        return $post;

    }

    public function getFallenDate($appleId)
    {
        $params = [':id' => $appleId];

        $post = Yii::$app->db->createCommand('SELECT fallToGroundDate FROM apples WHERE id=:id')
                         ->bindValues($params)
                         ->queryOne();
        
        return $post;
    }

    public function updateStatus($appleId, $statusNum)
    {
        $command = Yii::$app->db->createCommand()->update('apples', [
            'appleStatus'       => $statusNum,
        ], "id = $appleId")->execute();

        return $command;
    }

    public function updateSize($appleId, $appleSize)
    {
        $procent        = $this->eatingProcent;

        $eatingProcent  = $appleSize - ($appleSize * ($procent / 100));

        $command = Yii::$app->db->createCommand()->update('apples', [
            'eatingProcent'  => $eatingProcent,
        ], "id = $appleId")->execute();

        $eatedProc = $this->getSize($appleId);

        if($eatedProc['eatingProcent'] == 0)
        {
           return $this->deleteApple($appleId);
        }

        return $command ? $command : 0;     
    }


    public static function getAll()
    {
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
            'appleStatus'       => $appleStatus,
            'eatingProcent'     => $eatingProcent,
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