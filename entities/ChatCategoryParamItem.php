<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_category_param_item".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $param_id
 * @property integer $priority
 *
 * @property ChatCategoryParam $param
 * @property ChatCategoryParamItemTranslation[] $chatCategoryParamItemTranslations
 */
class ChatCategoryParamItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_param_item';
    }

    public function rules()
    {
        return [
            [['param_id', 'priority'], 'required'],
            [['param_id', 'priority'], 'integer'],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParam::className(), 'targetAttribute' => ['param_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param_id' => 'Param ID',
            'priority' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParam()
    {
        return $this->hasOne(ChatCategoryParam::className(), ['id' => 'param_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatCategoryParamItemTranslations()
    {
        return $this->hasMany(ChatCategoryParamItemTranslation::className(), ['item_id' => 'id']);
    }
}
