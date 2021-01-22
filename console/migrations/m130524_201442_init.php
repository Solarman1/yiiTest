<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'password' => $this->string()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'password' => 'qwerty123456',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
