<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Apples;

class AppleController extends Controller
{
    
    public function actionIndex()
    {
        $apple = new Apples();

        $resultApple = $apple->getAll();

        return $this->render('apple', ['result' => $resultApple]);     
    }

    public function actionGetapples()
    {
        $apple = new Apples();
        $apple->deleteAll();
        for($i = 0; $i < mt_rand(3,12); $i++)
        {
            $apple->generateApples();
            //print_r('iterat');
        }

        return $this->actionIndex();
    }
    
    public function actionFalltogroundapple()
    {
        $apple = new Apples();

        $appleId = Yii::$app->request->post('appleId');

        $apple-> fallToGround($appleId);
            // die(var_dump($appleId));
            // echo 'fall';
  
        return $this->actionIndex();
    }

    public function actionEateapple()
    {
        echo 'update';
    }

    public function actionDeleteapple()
    {
        echo 'dell';
    }
}