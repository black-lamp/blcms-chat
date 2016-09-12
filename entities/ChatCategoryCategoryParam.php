<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_category_category_param".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $param_id
 *
 * @property ChatCategoryParam $param
 * @property ChatCategory $category
 */
class ChatCategoryCategoryParam extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_category_param';
    }

    public function rules()
    {
        return [
            [['category_id', 'param_id'], 'required'],
            [['category_id', 'param_id'], 'integer'],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParam::className(), 'targetAttribute' => ['param_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'param_id' => 'Param ID',
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
    public function getCategory()
    {
        return $this->hasOne(ChatCategory::className(), ['id' => 'category_id']);
    }
}
