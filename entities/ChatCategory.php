<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_category".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 *
 * @property Chat[] $chats
 * @property ChatCategoryCategoryParam[] $chatCategoryCategoryParams
 * @property ChatCategoryTranslation[] $chatCategoryTranslations
 * @property ChatSubcategory[] $chatSubcategories
 */
class ChatCategory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryCategoryParams()
    {
        return $this->hasMany(ChatCategoryCategoryParam::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryTranslations()
    {
        return $this->hasMany(ChatCategoryTranslation::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatSubcategories()
    {
        return $this->hasMany(ChatSubcategory::className(), ['category_id' => 'id']);
    }
}
