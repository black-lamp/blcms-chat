<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102619_create_chat_category_category_param_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_category_param', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'param_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_category_category_param-chat_category-FK', 'chat_category_category_param',
            'category_id', 'chat_category', 'id');
        $this->addForeignKey('chat_category_category_param-chat_category_param-FK', 'chat_category_category_param',
            'param_id', 'chat_category_param', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_category_param-chat_category-FK', 'chat_category_category_param');
        $this->dropForeignKey('chat_category_category_param-chat_category_param-FK', 'chat_category_category_param');

        $this->dropTable('chat_category_category_param');
    }
}
