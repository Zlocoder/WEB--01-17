<?php

use yii\db\Migration;

class m171126_163006_tariffs extends Migration {
    public function safeUp() {
        $this->createTable('tariffs', [
            'id' => $this->primaryKey(),
            'companyId' => $this->integer()->notNull(),
            'priceFrom' => $this->float()->notNull(),
            'priceTo' => $this->float()->notNull(),
            'widthFrom' => $this->integer()->notNull(),
            'widthTo' => $this->integer()->notNull(),
            'heightFrom' => $this->integer()->notNull(),
            'heightTo' => $this->integer()->notNull(),
            'lengthFrom' => $this->integer()->notNull(),
            'lengthTo' => $this->integer()->notNull(),
            'weightFrom' => $this->integer()->notNull(),
            'weightTo' => $this->integer()->notNull(),
            'activity' => $this->boolean()->notNull()
        ]);

        try {
            $this->addForeignKey('tariffs_companyId_fk', 'tariffs', 'companyId', 'companies', 'id');
        } catch (\Exception $error) {
            $this->dropTable('tariffs');
            throw $error;
        }
    }

    public function safeDown() {
        $this->dropTable('tariffs');
    }
}
