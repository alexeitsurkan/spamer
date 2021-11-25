<?php

use yii\db\Migration;

/**
 * Class m211125_193700_CreateUser
 * @package app\migrations
 */
class m211125_193700_CreateClient extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'client',
            [
                'id'         => $this->primaryKey(),
                'sid'        => $this->bigInteger()->comment('id пользователя в платформе'),
                'username'   => $this->string()->comment('логин'),
                'first_name' => $this->string()->comment('имя'),
                'last_name'  => $this->string()->comment('фамилия'),
                'language'   => $this->string()->comment('язык пользователя'),

            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}