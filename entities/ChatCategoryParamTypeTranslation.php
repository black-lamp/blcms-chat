<?php
namespace bl\cms\chat\entities;

use Yii;
use bl\multilang\entities\Language;

/**
 * This is the model class for table "chat_category_param_type_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $language_id
 * @property string $name
 *
 * @property Language $language
 * @property ChatCategoryParamType $type
 */
class ChatCategoryParamTypeTranslation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_param_type_translation';
    }

    public function rules()
    {
        return [
            [['type_id', 'language_id', 'name'], 'required'],
            [['type_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParamType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'language_id' => 'Language ID',
            'name' => 'Name',
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
    public function getType()
    {
        return $this->hasOne(ChatCategoryParamType::className(), ['id' => 'type_id']);
    }
}
