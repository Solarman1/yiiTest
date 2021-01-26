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

        return $this->render('apple', [
            'result' => $resultApple,
            'model'  => $apple
            ]);     
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
        $appleId    = Yii::$app->request->post('appleId');
        $appleSize  = Yii::$app->request->post('appleSize');
        $procent    = $apple->load(\Yii::$app->request->post());
      
        $fallDate = $apple->getFallenDate($appleId);

        $fallenDate = date_create($fallDate['fallToGroundDate']);
        $curDate    = date_create(date('Y-m-d H:i:s'));

        $interval = date_diff($fallenDate, $curDate);
        $difHours = $interval->format('%h');
        if($difHours == '5')
        {
            $apple->updateStatus($appleId, 3);
        }

        if($apple->validate()) 
        {
            if($status != 1 && $status != 3)
            {
              
                $eatingProcent  = $apple->updateSize($appleId, $appleSize);
                $currentProcent = $apple->getSize($appleId);



                Yii::$app->session->setFlash('eatingStatus', "Осталось скушать -> $procent");                           
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
        } 
        else 
        {
            $errors = $apple->errors;
        }
        return $this->actionIndex();
    }

    public function actionDeleteapple($appleId)
    {   
        $apple = new Apples();

        if($apple->deleteApple($appleId))
        {
            Yii::$app->session->setFlash('eatingStatus', "Вы съели яблоко");         
            return $this->actionIndex();
        }
        else
            return 0;
    }
}