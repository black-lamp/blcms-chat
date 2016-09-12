<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102544_create_chat_category_param_item_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_param_item_translation', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_category_param_item_translation-chat_category_param_item-FK',
            'chat_category_param_item_translation', 'item_id', 'chat_category_param_item', 'id');
        $this->addForeignKey('chat_category_param_item_translation-language-FK', 'chat_category_param_item_translation',
            'language_id', 'language', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_param_item_translation-chat_category_param_item-FK',
            'chat_category_param_item_translation');
        $this->dropForeignKey('chat_category_param_item_translation-language-FK', 'chat_category_param_item_translation');

        $this->dropTable('chat_category_param_item_translation');
    }
}
