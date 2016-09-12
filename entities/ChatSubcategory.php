<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_subcategory".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $priority
 *
 * @property ChatCategory $category
 * @property ChatSubcategoryCategoryParam[] $chatSubcategoryCategoryParams
 * @property ChatSubcategoryTranslation[] $chatSubcategoryTranslations
 */
class ChatSubcategory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_subcategory';
    }

    public function rules()
    {
        return [
            [['category_id', 'priority'], 'required'],
            [['category_id', 'priority'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'priority' => 'Priority',
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
    public function getChatSubcategoryCategoryParams()
    {
        return $this->hasMany(ChatSubcategoryCategoryParam::className(), ['subcategory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatSubcategoryTranslations()
    {
        return $this->hasMany(ChatSubcategoryTranslation::className(), ['sub_cat_id' => 'id']);
    }
}
