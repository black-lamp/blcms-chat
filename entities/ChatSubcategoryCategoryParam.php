<?php
namespace bl\cms\chat\entities;

use Yii;

/**
 * This is the model class for table "chat_subcategory_category_param".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $subcategory_id
 * @property integer $param_id
 *
 * @property ChatCategoryParam $param
 * @property ChatSubcategory $subcategory
 */
class ChatSubcategoryCategoryParam extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_subcategory_category_param';
    }

    public function rules()
    {
        return [
            [['subcategory_id', 'param_id'], 'required'],
            [['subcategory_id', 'param_id'], 'integer'],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParam::className(), 'targetAttribute' => ['param_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatSubcategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subcategory_id' => 'Subcategory ID',
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
    public function getSubcategory()
    {
        return $this->hasOne(ChatSubcategory::className(), ['id' => 'subcategory_id']);
    }
}
