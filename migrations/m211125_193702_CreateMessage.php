<?php

use yii\db\Migration;

/**
 * Class m211125_193702_CreateMessage
 * @package app\migrations
 */
class m211125_193702_CreateMessage extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'message',
            [
                'id'          => $this->primaryKey(),
                'message_sid' => $this->bigInteger()->unique()->notNull()->comment('id сообщения в чате'),
                'chat_id'     => $this->bigInteger()->notNull()->comment('id пользователя'),
                'client_id'   => $this->bigInteger()->notNull()->comment('текст сообщения'),
                'text'        => $this->text(),
                'date'        => $this->bigInteger(),

            ]
        );

        $this->addForeignKey(
            'fk-message-chat_id',
            'message',
            'chat_id',
            'chat',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-message-client_id',
            'message',
            'client_id',
            'client',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('message');
    }
}