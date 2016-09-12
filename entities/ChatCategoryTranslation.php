<?php
namespace bl\cms\chat\entities;

use Yii;
use bl\multilang\entities\Language;

/**
 * This is the model class for table "chat_category_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $language_id
 * @property string $title
 *
 * @property ChatCategory $category
 * @property Language $language
 */
class ChatCategoryTranslation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_translation';
    }

    public function rules()
    {
        return [
            [['category_id', 'language_id', 'title'], 'required'],
            [['category_id', 'language_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'language_id' => 'Language ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ChatCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
