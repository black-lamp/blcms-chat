<?php
namespace bl\cms\chat\entities;

use Yii;
use bl\multilang\entities\Language;

/**
 * This is the model class for table "chat_subcategory_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $sub_cat_id
 * @property integer $language_id
 *
 * @property Language $language
 * @property ChatSubcategory $subCat
 */
class ChatSubcategoryTranslation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_subcategory_translation';
    }

    public function rules()
    {
        return [
            [['sub_cat_id', 'language_id'], 'required'],
            [['sub_cat_id', 'language_id'], 'integer'],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['sub_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatSubcategory::className(), 'targetAttribute' => ['sub_cat_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sub_cat_id' => 'Sub Cat ID',
            'language_id' => 'Language ID',
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
    public function getSubCat()
    {
        return $this->hasOne(ChatSubcategory::className(), ['id' => 'sub_cat_id']);
    }
}
