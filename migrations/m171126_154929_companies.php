<?php

use yii\db\Migration;

class m171126_154929_companies extends Migration {
    public function safeUp() {
        $this->createTable('companies', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull()->unique(),
            'name' => $this->string(50)->notNull()->unique(),
            'created' => $this->dateTime()->notNull()
        ]);

        try {
            $this->addForeignKey('companies_userId_fk', 'companies', 'userId', 'users', 'id');
        } catch (\Exception $error) {
            $this->dropTable('companies');
            throw $error;
        }
    }

    public function safeDown() {
        $this->dropTable('companies');
    }
}
