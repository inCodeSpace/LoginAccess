<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /* Создание таблицы и заполнение ее данными */
    public function actionTest1()
    {
        // Проверим - можно ли получить информацию о таблице, если нет - создадим таблицу.
        if (Yii::$app->db->schema->getTableSchema('data4table', true) === null) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'; // параметры таблицы
            // Создание таблицы с помощью DAO:
            Yii::$app->db->createCommand()->createTable('data4table', [
                'id' => 'pk',
                'title' => 'string',
                'text' => 'text',
            ], $tableOptions)->execute();
            // Заполним значениями с помощью DAO:
            Yii::$app->db
                ->createCommand()
                ->insert('data4table', [
                    'title' => 'Новоя Книга',
                    'text' => 'Простой текст',
                ])->execute();
            return $this->render('test', ['model' => 'Таблица создана и заполнена',]);
        } else { // если она уже создана
            return $this->render('test', ['model' => 'Таблица уже существует',]);
        }
    }

    /* Зачитывание данных из таблицы */
    public function actionTest2()
    {
        if (Yii::$app->db->schema->getTableSchema('data4table', true) === null) { // если таблицы еще нет
            return $this->render('test', ['model' => 'Таблица пока не существует',]);
        } else { // если таблица есть - выведем данные
            $model = (new \yii\db\Query()) // Используется Query Builder (подключается без use в начале)
                ->select('title, text')
                ->from('data4table')
                ->all();
            return $this->render('test', ['model' => $model,]);
        }
    }

    /* Удаление таблицы */
    public function actionTest3()
    {
        if (Yii::$app->db->schema->getTableSchema('data4table', true) === null) { // если таблицы еще нет
            return $this->render('test', ['model' => 'Таблица пока не существует',]);
        } else { // если таблица есть - выведем данные
            // Удалим таблицу с помощью DAO:
            Yii::$app->db->createCommand()->dropTable('data4table')->execute();
            return $this->render('test', ['model' => 'Таблица удалена',]);
        }
    }

}