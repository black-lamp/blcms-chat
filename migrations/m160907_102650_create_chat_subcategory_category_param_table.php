<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102650_create_chat_subcategory_category_param_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_subcategory_category_param', [
            'id' => $this->primaryKey(),
            'subcategory_id' => $this->integer()->notNull(),
            'param_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_subcategory_category_param-chat_category-FK', 'chat_subcategory_category_param',
            'subcategory_id', 'chat_subcategory', 'id');
        $this->addForeignKey('chat_subcategory_category_param-chat_category_param-FK', 'chat_subcategory_category_param',
            'param_id', 'chat_category_param', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_subcategory_category_param-chat_category-FK', 'chat_subcategory_category_param');
        $this->dropForeignKey('chat_subcategory_category_param-chat_category_param-FK', 'chat_subcategory_category_param');

        $this->dropTable('chat_subcategory_category_param');
    }
}
