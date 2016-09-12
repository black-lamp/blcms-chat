<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102305_create_chat_category_param_type_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_param_type', [
            'id' => $this->primaryKey()
        ]);
    }

    public function down()
    {
        $this->dropTable('chat_category_param_type');
    }
}
