<?php
namespace bl\cms\chat\entities;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat".
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $sub_cat_id
 * @property integer $creator_id
 * @property integer $date_create
 * @property integer $date_update
 *
 * @property ChatSubcategory $subCat
 * @property ChatCategory $category
 * @property ChatMessage[] $chatMessages
 * @property ChatUser[] $chatUsers
 */
class Chat extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [['creator_id'], 'required'],
            [['category_id', 'sub_cat_id', 'creator_id'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['sub_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatSubcategory::className(), 'targetAttribute' => ['sub_cat_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public static function tableName()
    {
        return 'chat';
    }

    public function rules()
    {
        return [
            [['category_id', 'sub_cat_id', 'creator_id', 'date_create', 'date_update'], 'integer'],
            [['creator_id', 'date_create', 'date_update'], 'required'],
            [['sub_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatSubcategory::className(), 'targetAttribute' => ['sub_cat_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_cat_id' => 'Sub Cat ID',
            'creator_id' => 'Creator ID',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCat()
    {
        return $this->hasOne(ChatSubcategory::className(), ['id' => 'sub_cat_id']);
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
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatUsers()
    {
        return $this->hasMany(ChatUser::className(), ['chat_id' => 'id']);
    }
}
