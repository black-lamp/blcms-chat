<?php
namespace bl\cms\chat\entities;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_message".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $chat_id
 * @property integer $user_id
 * @property string $message
 * @property boolean $moderation
 * @property boolean $hash
 * @property integer $date_create
 * @property integer $date_update
 *
 * @property Chat $chat
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
            ],
        ];
    }

    public static function tableName()
    {
        return 'chat_message';
    }

    public function rules()
    {
        return [
            [['chat_id', 'user_id', 'message'], 'required'],
            [['chat_id', 'user_id'], 'integer'],
            [['message', 'hash'], 'string'],
            [['moderation', 'hash', 'date_create', 'date_update'], 'safe'],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::className(), 'targetAttribute' => ['chat_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }
}
