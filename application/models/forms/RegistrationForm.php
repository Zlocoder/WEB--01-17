<?php

namespace app\models\forms;

use app\models\Company;
use app\models\User;

class RegistrationForm extends \app\classes\Model {
    public $login;
    public $email;
    public $password;
    public $confirm;
    public $company;

    public function rules() {
        return [
            'default' => [
                'login' => [
                    ['required', 'message' => 'Введите логин'],
                    ['string', 'length' => [3, 25], 'tooShort' => 'В строке должно быть не меньше 3 символов', 'tooLong' => 'В строке должно быть не больше 25 символов'],
                    ['match', 'pattern' => '/^[A-ZА-Я0-9]*$/ui', 'message' => 'Логин содержит недопустимые символы'],
                    ['unique', 'targetClass' => 'app\models\User', 'message' => 'Такой логин уже используется'],
                ],
                'email' => [
                    ['required', 'message' => 'Введите логин'],
                    ['string', 'max' => 100, 'tooLong' => 'В строке должно быть не больше 100 символов'],
                    ['email', 'message' => 'Email содержит недопустимые символы'],
                    ['unique', 'targetClass' => 'app\models\User', 'message' => 'Такой email уже используется'],
                ],
                'password' => [
                    ['required', 'message' => 'Введите пароль'],
                    ['string', 'length' => [5, 25], 'tooShort' => 'В строке должно быть не меньше 5 символов', 'tooLong' => 'В строке должно быть не больше 25 символов'],
                ],
                'confirm' => [
                    ['required', 'message' => 'Подтвердите пароль'],
                    ['compare', 'compareAttribute' => 'password', 'message' => 'пароли не совпадают']
                ],
                'company' => [
                    ['required', 'message' => 'Введите название компании'],
                    ['string', 'length' => [3, 50], 'tooShort' => 'В строке должно быть не меньше 3 символов', 'tooLong' => 'В строке должно быть не больше 50 символов'],
                    ['match', 'pattern' => '/^[A-ZА-Я0-9 -]*$/ui', 'message' => 'Название компании содержит недопустимые символы'],
                    ['unique', 'targetClass' => 'app\models\Company', 'targetAttribute' => 'name', 'message' => 'Такая компания уже зарегистрирована'],
                ]
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'confirm' => 'Подтверждение пароля',
            'company' => 'Название компании'
        ];
    }

    public function onProcess() {
        $user = new User([
            'login' => $this->login,
            'email' => $this->email,
            'password' => \Yii::$app->security->generatePasswordHash($this->password),
            'activity' => 1,
            'role' => User::ROLE_CLIENT
        ]);

        $company = new Company([
            'name' => $this->company
        ]);

        $mail = \Yii::$app->mailer->compose('new-password', ['password' => $this->password]);
        $mail->setFrom(\Yii::$app->params['systemEmail']);
        $mail->setTo($this->email);
        $mail->setSubject('Регистрация');

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if (!$user->save(false)) {
                throw new \Exception('Can not registrate user');
            }

            $company->userId = $user->id;
            if (!$company->save(false)) {
                throw new \Exception('Can not create company');
            }

            if (!$mail->send()) {
                throw new \Exception('Can not send registration mail');
            }

            $transaction->commit();

            \Yii::$app->user->login($user);
        } catch (\Exception $error) {
            $transaction->rollBack();
            throw $error;
        }

        return true;
    }
}