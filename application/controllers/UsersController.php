<?php

namespace app\controllers;

use app\models\filters\UsersFilter;
use app\models\forms\UserForm;
use app\models\User;
use yii\helpers\Url;

class UsersController extends \app\classes\Controller {
    protected static $backUrlSetter = [
        'except' => ['create', 'update', 'delete']
    ];

    public function actionIndex() {
        $filter = new UsersFilter();
        $filterActive = false;
        $filterReset = '';


        if ($this->request->get('UsersFilter')) {
            $filter->load($this->request->get());
            $filterActive = true;
            $filterReset = Url::to(['index']);
        }


        return $this->render('list', compact('filter', 'filterActive', 'filterReset'));
    }

    public function actionCreate() {
        $model = new UserForm([
            'scenario' => 'create',
            'user' => new User([
                'active' => 1,
                'role' => User::ROLE_USER
            ])
        ]);

        if ($this->request->isPost) {
            $model->load($this->request->post());

            try {
                if ($model->process()) {
                    return $this->redirect(['index']);
                }
            } catch (\Exception $error) {
                $this->session->addFlash('error', $error->getMessage());
            }
        }

        return $this->render('create', compact('model'));
    }

    public function actionView($id) {

    }

    public function actionUpdate() {

    }

    public function actionDelete() {

    }
}