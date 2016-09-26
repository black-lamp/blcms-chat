<?php

use yii\db\Migration;

class m160923_145310_add_status_id_column_to_chat_message_table extends Migration
{
    public function up()
    {
        $this->addColumn('chat_message', 'status_id', $this->integer()->defaultValue(1));
        $this->addForeignKey('chat_message-chat_status-FK', 'chat_message', 'status_id', 'chat_status', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_message-chat_status-FK', 'chat_message');
        $this->dropColumn('chat_message', 'status_id');
    }
}
