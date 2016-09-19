<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160916_145728_add_hash_column_to_chat_message_table extends Migration
{
    public function up()
    {
        $this->addColumn('chat_message', 'hash', $this->string());
    }

    public function down()
    {
        $this->dropColumn('chat_message', 'hash');
    }
}
