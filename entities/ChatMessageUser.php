<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_message_user".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $message_id
 * @property integer $status_id
 * @property boolean $unread
 *
 * @property ChatStatus $status
 * @property ChatMessage $message
 */
class ChatMessageUser extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_message_user';
    }

    public function rules()
    {
        return [
            [['user_id', 'message_id', 'status_id'], 'required'],
            [['user_id', 'message_id', 'status_id'], 'integer'],
            [['unread'], 'boolean'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatMessage::className(), 'targetAttribute' => ['message_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message_id' => 'Message ID',
            'status_id' => 'Status ID',
            'unread' => 'Unread'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ChatStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(ChatMessage::className(), ['id' => 'message_id']);
    }
}
