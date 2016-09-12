<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_status".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 *
 * @property ChatStatusTranslation[] $chatMessageStatusTranslations
 * @property ChatMessageUser[] $chatMessageUsers
 */
class ChatStatus extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_REMOVED = 2;

    public static function tableName()
    {
        return 'chat_message_status';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessageStatusTranslations()
    {
        return $this->hasMany(ChatStatusTranslation::className(), ['status_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessageUsers()
    {
        return $this->hasMany(ChatMessageUser::className(), ['status_id' => 'id']);
    }
}
