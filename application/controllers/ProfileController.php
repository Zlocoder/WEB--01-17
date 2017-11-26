<?php

namespace app\controllers;

use app\models\forms\ProfileForm;

class ProfileController extends \app\classes\Controller {
    public function actionIndex() {
            try {
            $model = new ProfileForm();

            if ($this->request->isPost) {
                $model->process($this->request->post());
            }
        } catch (\Exception $error) {
            $this->session->setFlash('error', $error->getMessage());
        }

        return $this->render('form', compact('model'));
    }
}