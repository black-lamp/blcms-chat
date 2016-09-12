<?php
namespace bl\cms\chat\entities;

use Yii;
use bl\multilang\entities\Language;

/**
 * This is the model class for table "chat_category_param_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $param_id
 * @property integer $language_id
 * @property string $name
 *
 * @property Language $language
 * @property ChatCategoryParam $param
 */
class ChatCategoryParamTranslation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_param_translation';
    }

    public function rules()
    {
        return [
            [['param_id', 'language_id', 'name'], 'required'],
            [['param_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParam::className(), 'targetAttribute' => ['param_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param_id' => 'Param ID',
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
    public function getParam()
    {
        return $this->hasOne(ChatCategoryParam::className(), ['id' => 'param_id']);
    }
}
