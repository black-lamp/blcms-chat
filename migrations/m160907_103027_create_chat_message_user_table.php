<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_103027_create_chat_message_user_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_message_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->defaultValue('1'),
            'unread' => $this->boolean()->defaultValue(true)
        ]);

        $this->addForeignKey('chat_message_user-chat_message-FK', 'chat_message_user', 'message_id',
            'chat_message', 'id');
        $this->addForeignKey('chat_message_user-chat_status-FK', 'chat_message_user', 'status_id',
            'chat_status', 'id');

        $this->createIndex('chat_message_user-user_id-IDX', 'chat_message_user', 'user_id');
        $this->createIndex('chat_message_user-message_id-IDX', 'chat_message_user', 'message_id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_message_user-chat_message-FK', 'chat_message_user');
        $this->dropForeignKey('chat_message_user-chat_status-FK', 'chat_message_user');

        $this->dropIndex('chat_message_user-user_id-IDX', 'chat_message_user');
        $this->dropIndex('chat_message_user-message_id-IDX', 'chat_message_user');

        $this->dropTable('chat_message_user');
    }
}
