<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_category_param".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $priority
 *
 * @property ChatCategoryCategoryParam[] $chatCategoryCategoryParams
 * @property ChatCategoryParamType $type
 * @property ChatCategoryParamItem[] $chatCategoryParamItems
 * @property ChatCategoryParamTranslation[] $chatCategoryParamTranslations
 * @property ChatSubcategoryCategoryParam[] $chatSubcategoryCategoryParams
 */
class ChatCategoryParam extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_param';
    }

    public function rules()
    {
        return [
            [['type_id', 'priority'], 'required'],
            [['type_id', 'priority'], 'integer'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParamType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'priority' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryCategoryParams()
    {
        return $this->hasMany(ChatCategoryCategoryParam::className(), ['param_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ChatCategoryParamType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryParamItems()
    {
        return $this->hasMany(ChatCategoryParamItem::className(), ['param_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryParamTranslations()
    {
        return $this->hasMany(ChatCategoryParamTranslation::className(), ['param_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatSubcategoryCategoryParams()
    {
        return $this->hasMany(ChatSubcategoryCategoryParam::className(), ['param_id' => 'id']);
    }
}
