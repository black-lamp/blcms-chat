<?php
namespace bl\cms\chat\entities;

use Yii;
use bl\multilang\entities\Language;

/**
 * This is the model class for table "chat_category_param_item_translation".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $language_id
 *
 * @property Language $language
 * @property ChatCategoryParamItem $item
 */
class ChatCategoryParamItemTranslation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chat_category_param_item_translation';
    }

    public function rules()
    {
        return [
            [['item_id', 'language_id'], 'required'],
            [['item_id', 'language_id'], 'integer'],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategoryParamItem::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
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
    public function getItem()
    {
        return $this->hasOne(ChatCategoryParamItem::className(), ['id' => 'item_id']);
    }
}
