<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ForgotPasswordForm;
use app\models\ResetPasswordForm;
use app\models\User;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionForgotPassword() {
      
      $isSuccessfull = false;
      $model = new ForgotPasswordForm();
      
      if($model->load(Yii::$app->request->post()) && $model->validate()) {
        
        //send forgot password retrieval email to the client
        $isSuccessfull = true;
        
        $user = User::find()->where(['email' => $model->email])->one();
        
        $user->authKey = uniqid('', TRUE);
        $user->save(false);
        
        $model->sendForgotPasswordEmail($user);
      }
      
      return $this->render('forgotPassword', [
          'model' => $model,
          'success' => $isSuccessfull
      ]);
    }
    
    public function actionResetPassword($id) {
      
      $isSuccessfull = false;
      
      $model = new ResetPasswordForm();
      $model->id = $id;
      
      if($model->load(Yii::$app->request->post()) && $model->validate()) {
        
        //send forgot password retrieval email to the client
        $isSuccessfull = true;
        $user = User::find()->where(['authKey' => $model->id])->one();
        
        $user->password = md5($model->password);
        $user->save(false);
      }
      
      return $this->render('resetPassword', [
          'model' => $model,
          'success' => $isSuccessfull
      ]);
    }
}
