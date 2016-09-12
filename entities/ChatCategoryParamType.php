<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_category_param_type".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 *
 * @property ChatCategoryParam[] $chatCategoryParams
 * @property ChatCategoryParamTypeTranslation[] $chatCategoryParamTypeTranslations
 */
class ChatCategoryParamType extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_param_type';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryParams()
    {
        return $this->hasMany(ChatCategoryParam::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryParamTypeTranslations()
    {
        return $this->hasMany(ChatCategoryParamTypeTranslation::className(), ['type_id' => 'id']);
    }
}
