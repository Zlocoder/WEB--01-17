<?php

namespace app\controllers;

use app\models\forms\ProfileForm;

class ProfileController extends \app\classes\Controller {
    public function actionIndex() {
        $model = new ProfileForm();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            try {
                $model->process();
            } catch (\Exception $error) {
                $this->session->setFlash('error', $error->getMessage());
            }
        }

        return $this->render('form', compact('model'));
    }
}