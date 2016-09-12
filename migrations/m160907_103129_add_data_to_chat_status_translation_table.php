<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_103129_add_data_to_chat_status_translation_table extends Migration
{
    public function up()
    {
        $this->batchInsert('chat_status_translation',
            [
                'status_id',
                'language_id',
                'title'
            ],
            [
                [ 1, 1, 'Active' ],
                [ 2, 1, 'Removed' ]
            ]);
    }

    public function down()
    {
        return true;
    }
}
