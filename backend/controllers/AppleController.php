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
        }

        return $this->actionIndex();
    }
    
    public function actionFalltogroundapple()
    {
        $apple = new Apples();

        $appleId = Yii::$app->request->post('appleId');

        if($apple->fallToGround($appleId))
        {
            Yii::$app->session->setFlash('fallenStatus', "Яблоко сорвано, можно есть");
        }
        else
            Yii::$app->session->setFlash('fallenStatus', "Яблоко не сорвано");
  
        return $this->actionIndex();
    }

    public function actionEateapple()
    {
        $apple      = new Apples();
        $status     = Yii::$app->request->post('status');
        $procent    = Yii::$app->request->post('procent');
        $appleId    = Yii::$app->request->post('appleId');
        $appleSize  = Yii::$app->request->post('appleSize');

        if($status != 1 && $status != 3)
        {
            $eatingProcent = $appleSize - ($appleSize * ($procent / 100));
            if($appleSize == 0)
                return $this->actionDeleteapple($appleId);
            else
            {
                if($procent > 100)
                    Yii::$app->session->setFlash('eatingStatus', "Вы пытаетесь откусить больше чем возможно -> $procent");
                else
                {
                    $eatingProcent  = $apple->updateSize($appleId, (float)$eatingProcent);
                    $currentProcent = $apple->getSize($appleId);

                    $procent = $currentProcent['EatingProcent'];
                    Yii::$app->session->setFlash('eatingStatus', "Осталось скушать -> $procent");
                    
                } 
            }      
        }
        else
        {
            switch($status)
            {
                case 1:
                    Yii::$app->session->setFlash('eatingStatus', "Висит на дереве нельзя кушать");
                    break;
                case 3:
                    Yii::$app->session->setFlash('eatingStatus', "Яблоко гнилое");
                    break;
            }
        }


        return $this->actionIndex();
    }

    public function actionDeleteapple($appleId)
    {   $apple = new Apples();

        if($apple->deleteApple($appleId))
        {
            Yii::$app->session->setFlash('eatingStatus', "Вы съели яблоко");         
            return $this->actionIndex();
        }
        else
            return 0;
    }
}