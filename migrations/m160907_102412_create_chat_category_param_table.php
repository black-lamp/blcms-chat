<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102412_create_chat_category_param_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_param', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'priority' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_category_param-chat_category_param_type-FK', 'chat_category_param', 'type_id',
            'chat_category_param_type', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_param-chat_category_param_type-FK', 'chat_category_param');

        $this->dropTable('chat_category_param');
    }
}
