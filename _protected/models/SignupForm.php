<?php
namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            // выполняется проверка валидатором на уникальность поля username из модели AR models\User
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Имя пользователя уже занято.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            // выполняется проверка валидатором на уникальность поля email из модели AR models\User
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Данный email уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) { // идет обращение к SignupForm::rules() выполняются проверка валидации
            $user = new User(); // создать объект модели models\User
            // заполнить поля модели User соотв. данными (обработанными из SignupForm)
            $user->username = $this->username;
            $user->email = $this->email;
            // Перед записью в базу для каждого пользователя нужно генерировать хэш пароля
            // и дополнительный ключ автоматической аутентификации
            $user->setPassword($this->password);
            $user->generateAuthKey();
            // сохранить данные модели в БД
            $user->save();
            // вернуть объект модели User с заполненными полями (который так же, будет implements IdentityInterface)
            return $user;
        }
        return null;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }
}
