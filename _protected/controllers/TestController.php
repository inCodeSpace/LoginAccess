<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
//use app\models\SignupForm;

class TestController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) { // если пользователь уже залогинился
            return $this->goHome(); // отправить его на главную
        }
        $model = new LoginForm();
        // Если есть данные из заполн. формы - обработать их, либо отправить на заполнение
        // Заполнить модель данными из формы и попытаться залогинится (в соотв. с переданными параметрами)
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(); // перенаправит на последнюю использ. страницу
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout(); // выйти пользователю из системы
        return $this->goHome(); // отправить его на главную
    }

/*
Закоментировано для заливки на сервер (что бы не было возможности забить базу данных, новыми пользователями)
    public function actionSignup()
    {
        $model = new SignupForm(); // Создается объект модели
        // Если форма уже заполнялась - обработать данные:
        // Заполнить модель данными из формы (Попробовать выполнить успешно)
        if ($model->load(Yii::$app->request->post())) {
            // Вызвать метод модели SignupForm::signup (Попробовать выполнить успешно)
            if ($user = $model->signup()) { // в случае успеха сюда
                // придет объект модели User с заполненными полями (который так же, будет implements IdentityInterface)
                // Залогинится используя Yii:
                    // - Вернуть пользовательский компонент и залогинить его передав
                    //  в него объект пользователя (Попробовать выполнить успешно)
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome(); // отправить его на главную
                }
            }
        }
        // Заполнить форму
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
*/

    /**
     * Данное действие будет доступно только для залогиненых пользователей
     * Если пользователь не залогинен, его перенаправит на /test/login
    */
    public function actionAccess0()
    {
        return $this->render('index');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'access0'], // распростроняется только на действие logout, signup, access0
                'rules' => [
                    [
                        'actions' => ['signup'], // для действия signup
                        'allow' => true, // разрешить обращение
                        'roles' => ['?'], // гостям
                    ],
                    [
                        'actions' => ['logout', 'access0'], // для действия logout и access0
                        'allow' => true, // разрешить обращение
                        'roles' => ['@'], // залогиненым пользователям
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'], // обратится к logout можно только методом post
                ],
            ],
        ];
    }
}