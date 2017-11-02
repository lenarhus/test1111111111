<?php

namespace app\controllers;
/*
use app\models\Callback;
use app\models\Certificate;
use app\models\Code;
use app\models\SuspectCode;
use app\models\SuspectIp;*/

use Yii;
use app\models\User;
use yii\filters\AccessControl;
use app\commands\Rbac;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\ForbiddenHttpException;

class BackendController extends AppController{
    public $layout = 'backend';

    public function behaviors(){
        return [
            'ghost-access'=> [
            'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
   
   public function actionLogout(){
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex(){
        return $this->render('index');
    }

    
}
