<?php
namespace bl\cms\chat\entities;

use Yii;
use bl\multilang\entities\Language;

/**
 * This is the model class for table "chat_status_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $status_id
 * @property integer $language_id
 * @property string $title
 *
 * @property Language $language
 * @property ChatStatus $status
 */
class ChatStatusTranslation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_message_status_translation';
    }

    public function rules()
    {
        return [
            [['status_id', 'language_id', 'title'], 'required'],
            [['status_id', 'language_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'Status ID',
            'language_id' => 'Language ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ChatStatus::className(), ['id' => 'status_id']);
    }
}
