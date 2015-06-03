<?php
namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
        return $this->render('test');
    }

}