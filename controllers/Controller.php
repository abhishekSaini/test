<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class Controller extends \yii\web\Controller
{
  
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function init() {
      
      if(Yii::$app->user->isGuest && 
        strpos(Yii::$app->request->url, 'login') === FALSE &&
        strpos(Yii::$app->request->url, 'forgot-password') === FALSE &&
        strpos(Yii::$app->request->url, 'reset-password') === FALSE
      )
        return $this->redirect(Yii::$app->urlManager->createUrl(['site/login']), 302);
    }
}