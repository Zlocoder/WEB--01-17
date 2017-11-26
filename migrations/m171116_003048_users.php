<?php

use yii\db\Migration;

use app\models\User;

class m171116_003048_users extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string(25)->notNull()->unique(),
            'email' => $this->string(100)->notNull()->unique(),
            'password' => $this->string(60)->notNull(),
            'role' => $this->string(25)->notNull(),
            'activity' => 'BIT(1) NOT NULL',
            'created' => $this->dateTime()->notNull(),
        ]);

        try {
            $user = new User([
                'login' => 'admin',
                'email' => \Yii::$app->params['adminEmail'],
                'password' => \Yii::$app->security->generatePasswordHash('admin'),
                'role' => 'admin',
                'activity' => 1,
                'created' => new \yii\db\Expression('NOW()')
            ]);

            if (!$user->save()) {
                throw new \Exception('Can not create initial administrator. ' . \yii\helpers\VarDumper::dump($user->errors));
            };
        } catch (\Exception $error) {
            $this->dropTable('users');

            throw $error;
        }
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }
}
