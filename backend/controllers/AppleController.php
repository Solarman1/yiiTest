<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Apples;

class AppleController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetapples()
    {
        $apple = new Apples();
        $apple->generateApples();
        echo 'get';
    }
    
    public function actionFalltogroundapple()
    {
        echo 'fall';
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