<?php

namespace app\controllers;

use app\models\forms\ForgetPasswordForm;
use app\models\forms\LoginForm;

class AuthController extends \app\classes\Controller {
    protected static $accessChecker = false;
    protected static $menuBuilder = false;
    protected static $backUrlSetter = false;

    public $layout = 'auth';

    public function actionLogin() {
        $model = new LoginForm();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            try {
                if ($model->process()) {
                    return $this->goBack();
                }
            } catch (\Exception $error) {
                $this->session->setFlash('error', $error->getMessage());
            }
        }

        return $this->render('login', compact('model'));
    }

    public function actionLogout() {
        $this->user->logout();

        return $this->redirect(['login']);
    }

    public function actionForgetPassword() {
        $model = new ForgetPasswordForm();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            try {
                if ($model->process()) {
                    $this->session->setFlash('success', 'Новый пароль отправлен на вашу почту.');

                    return $this->redirect(['login']);
                }
            } catch (\Exception $error) {
                $this->session->setFlash('error', $error->getMessage());
            }
        }

        return $this->render('forget-password', compact('model'));
    }
}