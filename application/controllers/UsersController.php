<?php

namespace app\controllers;

use app\models\filters\UsersFilter;
use app\models\forms\UserForm;
use app\models\User;
use yii\helpers\Url;

class UsersController extends \app\classes\Controller {
    public $modelClass = 'app\models\User';

    public function actionIndex() {
        $filter = new UsersFilter();
        $filter->load($this->request->get());
        $filterReset = Url::to(['index']);

        return $this->render('list', compact('filter', 'filterReset'));
    }

    public function actionCreate() {
        try {
            $model = new UserForm([
                'scenario' => 'create',
                'user' => new User(),
                'role' => User::ROLE_CLIENT
            ]);

            if ($this->request->isPost) {
                if ($this->request->post('generate')) {
                    $model->load($this->request->post());
                    $model->password = $this->security->generateRandomString(8);
                } else if ($model->process($this->request->post())) {
                    $this->session->setFlash('success', "Пользовтаель {$model->login} добавлен");
                    return $this->goBack();
                }
            }
        } catch (\Exception $error) {
            $this->session->setFlash('error', $error->getMessage());
        }

        return $this->render('form', compact('model'));
    }

    public function actionToggle() {
        try {
            if (!$this->model->toggle()->save()) {
                throw new \Exception('Can not toggle user');
            }

            $this->session->setFlash('success', "Состояние пользовтаеля {$this->model->login} изменено");
        } catch (\Exception $error) {
            $this->session->setFlash('error', $error->getMessage());
        }

        return $this->goBack();
    }

    public function actionView() {
        $model = $this->model;

        return $this->render('details', compact('model'));
    }

    public function actionUpdate() {
        try {
            $model = new UserForm([
                'scenario' => 'update',
                'user' => $this->model
            ]);

            if ($this->request->isPost) {
                if ($this->request->post('generate')) {
                    $model->load($this->request->post());
                    $model->password = $this->security->generateRandomString(10);
                } else if ($model->process($this->request->post())) {
                    $this->session->setFlash('success', "Пользовтаель {$model->login} сохранен");
                    return $this->goBack();
                }
            }
        } catch (\Exception $error) {
            $this->session->setFlash('error', $error->getMessage());
        }

        return $this->render('form', compact('model'));
    }

    public function actionDelete() {
        try {
            if ($this->model->delete()) {
                $this->session->setFlash('success', "Пользователь {$this->model->login} удален");
            } else {
                $this->session->setFlash('error', "Удалить пользователя {$this->model->login} не удалось.");
            }
        } catch (\Exception $error) {
            $this->session->setFlash('error', $error->getMessage());
        }

        return $this->goBack();
    }
}