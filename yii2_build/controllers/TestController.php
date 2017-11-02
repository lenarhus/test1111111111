<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 01.09.16
 * Time: 10:56
 */

namespace app\controllers;


class TestController extends AppController
{
    public $layout = 'main';
    public function actionIndex()
    {
        return $this->render('test');
    }

    public function actionTest1()
    {
        return $this->render('test1');
    }

    public function actionTestok()
    {
        return $this->render('testok');
    }

    public function actionVictorina()
    {
        return $this->render('victorina');
    }
}