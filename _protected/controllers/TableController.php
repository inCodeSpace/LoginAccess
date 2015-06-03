<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;

/**
 * Использовать только для создания структуры БД.
 * Использовать только перед созданием рабочего проекта.
 * Удалить данный файл из рабочего проекта.
 */
class TableController extends Controller
{
    /**
     * Метод создает таблицу User
     * Перед созданием проверяет, есть ли, уже такая таблица.
     */
    public function actionAdd()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'; // параметры таблиц
        // Создание табл. user
        // Проверим - можно ли получить информацию о таблице, если нет - создадим таблицу.
        if (Yii::$app->db->schema->getTableSchema('user', true) === null) {
            // Создание таблицы user с помощью DAO:
            Yii::$app->db->createCommand()->createTable('user', [
                'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'username' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'auth_key' => 'VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'password_hash' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'email' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'created_at' => 'INT(11) UNSIGNED',
                'updated_at' => 'INT(11) UNSIGNED',
            ], $tableOptions)->execute();
            $model = 'Таблица user создана. ';
        } else { // если она уже создана
            $model = 'Таблица user не создана, т.к. уже существует. ';
        }
        return $model; // Вывод сообщения результата выполнения.
    }
}