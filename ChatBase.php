<?php
namespace bl\cms\chat;

use yii;
use yii\base\Component;
use yii\base\Exception;
use yii\db\Exception as DbException;
use yii\helpers\ArrayHelper;

use bl\cms\chat\entities\Chat;
use bl\cms\chat\entities\ChatUser;
use bl\cms\chat\entities\ChatMessage;
use bl\cms\chat\entities\ChatMessageUser;
use bl\cms\chat\entities\ChatStatus;

/**
 * This component contains basic methods for work with the chats
 *
 * Install
 * Add this component to application config
 * ```php
 * 'components' => [
 *      // ...
 *      'mainChat' => [
 *          'class' => bl\cms\chat\ChatBase::className(),
 *          'enableMessageModeration' => true // for moderation messages in the chat
 *      ]
 * ]
 * ```
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @link https://github.com/black-lamp/blcms-chat
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class ChatBase extends Component
{
    // Events for chat
    const EVENT_BEFORE_CREATE_CHAT = 'beforeCreateChat';
    const EVENT_AFTER_CREATE_CHAT = 'afterCreateChat';
    const EVENT_BEFORE_REMOVE_CHAT = 'beforeRemoveChat';
    const EVENT_AFTER_REMOVE_CHAT = 'afterRemoveChat';

    // Events for users
    const EVENT_BEFORE_ADD_USER = 'beforeAddUser';
    const EVENT_AFTER_ADD_USER = 'afterAddUser';
    const EVENT_BEFORE_REMOVE_USER = 'beforeRemoveUser';
    const EVENT_AFTER_REMOVE_USER = 'afterRemoveUser';

    // Events for messages
    const EVENT_BEFORE_SEND_MESSAGE = 'beforeSendMessage';
    const EVENT_AFTER_SEND_MESSAGE = 'afterSendMessage';
    const EVENT_BEFORE_REMOVE_MESSAGE = 'beforeRemoveMessage';
    const EVENT_AFTER_REMOVE_MESSAGE = 'afterRemoveMessage';
    const EVENT_BEFORE_EDIT_MESSAGE = 'beforeEditMessage';
    const EVENT_AFTER_EDIT_MESSAGE = 'afterEditMessage';

    /**
     * @var boolean component property, set `true` if you want
     * enable moderation for messages in the chat
     */
    public $enableMessageModeration = false;
    /**
     * @var boolean component property, set `true` if you want
     * add hash string for messages
     */
    public $enableHashString = false;
    /**
     * @var integer chat id
     */
    protected $_chatId;
    /**
     * @var integer current user id
     */
    protected $_userId;

    /**
     * @return integer
     */
    public function getChatId()
    {
        return $this->_chatId;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Method for the existence check of the chat
     *
     * @param integer $chatId chat id
     * @return bool `true` if chat exist, `false` if not exists
     */
    public static function isChatExists($chatId) {
        $chat = Chat::findOne($chatId);

        return ($chat != null) ? true : false;
    }

    /**
     * @param integer $chatId
     * @param integer $userId
     * @return bool `true` if the chat has the user, `false` if not has
     */
    public static function isChatHasUser($chatId, $userId) {
        $user = ChatUser::findOne(['chat_id' => $chatId, 'user_id' => $userId]);

        return ($user != null) ? true : false;
    }

    /**
     * Method for the existence check users in the chat
     *
     * @param integer $chatId chat id
     * @return bool `true` if chat has users, `false` if not has any user
     */
    public static function isChatHasUsers($chatId) {
        $users = ChatUser::findAll(['chat_id' => $chatId]);

        return ($users != null) ? true : false;
    }

    /**
     * Method for the check exist user in the chat
     *
     * @param integer $userId user id
     * @param integer $chatId chat id
     * @return bool `true` if user exists in the chat, `false` if not exists
     */
    public static function isUserExistInChat($userId, $chatId) {
        $chatUser = ChatUser::findOne(['user_id' => $userId, 'chat_id' => $chatId]);

        return ($chatUser != null) ? true : false;
    }

    /**
     * Method for moderation of the messages
     *
     * @param integer $messageId
     * @return bool
     */
    public static function moderateMessage($messageId) {
        /** @var ChatMessage $message */
        $message = ChatMessage::findOne($messageId);
        $message->moderation = true;

        if($message->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * You must call this method if you want start a work
     * with existing chat.
     *
     * Usage example
     * ```php
     * Yii::$app->mainChat
     *      ->chat(1, 4)
     *      ->sendMessage("Hello! How are you?");
     * ```
     *
     * @param integer $chatId Required parameter, chat id
     * @param integer|null $userId If `null` - component will use 'Yii::$app->user->id'
     * @return $this
     * @throws Exception if chat is not exists
     * @see ChatBase::SendMessage()
     */
    public function chat($chatId, $userId = null) {
        if(!self::isChatExists($chatId)) {
            throw new Exception("Chat is not exists!");
        }

        $this->_chatId = $chatId;

        if($userId == null && !Yii::$app->user->isGuest) {
            $this->_userId = Yii::$app->user->id;
        }
        elseif($userId != null) {
            $this->_userId = $userId;
        }
        else {
            throw new Exception("You must login or add \$userId parameter to the method call!");
        }

        return $this;
    }

    /**
     * You must call this method if you want create new chat
     * and start work with it.
     * Or if you want create a new chat, you should call this method.
     *
     * Usage example
     * ```php
     * Yii::$app->mainChat
     *      ->createChat(1, 69)
     *      ->addUser([69, 587])
     *      ->sendMessage("Hey :)");
     * ```
     *
     * @param integer|null $categoryId chat category id, if chat has subcategory - this field not required
     * @param integer|null $subcategoryId chat subcategory id, if chat not has subcategory - thi field not required
     * @param integer $creatorId Required parameter, user id who will creating the chat
     * @return $this
     * @throws DbException
     * @see ChatBase::addUser()
     * @see ChatBase::sendMessage()
     */
    public function createChat($creatorId, $categoryId = null, $subcategoryId = null) {
        $this->trigger(self::EVENT_BEFORE_CREATE_CHAT);

        $this->_userId = $creatorId;

        $chat = new Chat();
        if($categoryId != null) {
            $chat->category_id = $categoryId;
        }
        if($subcategoryId != null) {
            $chat->sub_cat_id = $subcategoryId;
        }
        $chat->creator_id = $this->_userId;

        if($chat->validate() && $chat->save()) {
            $this->_chatId = $chat->id;
            $this->trigger(self::EVENT_AFTER_CREATE_CHAT);

            return $this;
        }

        throw new DbException("Creating new chat is failed!");
    }

    /**
     * Method for remove the chat.
     *
     * Method not delete a chat really,
     * it just set status 'REMOVED' for chat.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(2, 45)
     *      ->removeChat();
     * // second example
     * Yii::$app->mainChat
     *      ->removeChat(2, 45);
     * ```
     *
     * @param integer|null $chatId chat id
     * @param integer|null $userId user id who wants to remove herself from the chat
     * @return $this
     * @throws Exception if user is not found in the chat
     * @see ChatBase::chat()
     */
    public function removeChat($chatId = null, $userId = null) {
        $this->trigger(self::EVENT_BEFORE_REMOVE_CHAT);

        $chat = ($chatId == null) ? $this->_chatId : $chatId;
        $user = ($userId == null) ? $this->_userId : $userId;

        /** @var ChatUser $chatUser */
        $chatUser = ChatUser::findOne(['chat_id' => $chat, 'user_id' => $user]);
        if($chatUser == null) {
            throw new Exception("User is not found in this chat!");
        }

        $chatUser->status_id = ChatStatus::STATUS_REMOVED;
        $chatUser->save(false);

        $this->trigger(self::EVENT_AFTER_REMOVE_CHAT);

        return $this;
    }

    /**
     * Method for adding a new user to chat.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(2, 45)
     *      ->addUser();
     *
     * // second example
     * Yii::$app->mainChat
     *      ->createChat(2, 45)
     *      ->addUser();
     *
     * // third example
     * Yii::$app->mainChat
     *      ->addUser([45, 67, 23]);
     * ```
     *
     * @param integer|integer[]|null $userId user id or array with users id
     * @param integer|null $chatId user id who will added to the chat
     * @return $this
     * @throws Exception if chat is not exists or user exists in the chat
     * @throws DbException
     * @see ChatBase::chat()
     * @see ChatBase::createChat()
     */
    public function addUser($userId = null, $chatId = null) {
        $this->trigger(self::EVENT_BEFORE_ADD_USER);

        if($chatId != null && !self::isChatExists($chatId)) {
            throw new Exception("Chat is not exists!");
        }
        $chat = ($chatId == null) ? $this->_chatId : $chatId;

        if($userId != null && is_array($userId)) {

            /** @var integer[] $users */
            $users = $userId;
            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                foreach($users as $user) {
                    if(self::isUserExistInChat($user, $chat)) {
                        throw new Exception("User exists in this chat!");
                    }

                    $chatUser = new ChatUser();
                    $chatUser->chat_id = $chat;
                    $chatUser->user_id = $user;

                    $chatUser->validate();
                    $chatUser->save();
                }

                $transaction->commit();
            }
            catch(DbException $error) {
                $transaction->rollBack();
                throw $error;
            }
        }
        else {
            $user = ($userId == null) ? $this->_userId : $userId;

            if(self::isUserExistInChat($user, $chat)) {
                throw new Exception("User exists in this chat!");
            }

            $chatUser = new ChatUser();
            $chatUser->chat_id = $chat;
            $chatUser->user_id = $user;
            try {
                $chatUser->validate();
                $chatUser->save();
            }
            catch(DbException $error) {
                throw $error;
            }
        }

        $this->trigger(self::EVENT_AFTER_ADD_USER);

        return $this;
    }

    /**
     * Method for remove a user from the chat.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(3, 45)
     *      ->removeUser();
     *
     * //second example
     * Yii::$app->mainChat->mainChat
     *      ->removeUser(45, 3);
     * ```
     *
     * @param integer|null $userId user id who will removed from the chat
     * @param integer|null $chatId chat id
     * @return $this
     * @throws Exception if user is not exists
     * @see ChatBase::chat()
     */
    public function removeUser($userId = null, $chatId = null) {
        $this->trigger(self::EVENT_BEFORE_REMOVE_USER);

        $user = ($userId == null) ? $this->_userId : $userId;
        $chat = ($chatId == null) ? $this->_chatId : $chatId;

        /** @var ChatUser $chatUser */
        $chatUser = ChatUser::findOne(['user_id' => $user, 'chat_id' => $chat]);
        if($chatUser == null) {
            throw new Exception("User not exists!");
        }
        $chatUser->delete();

        $this->trigger(self::EVENT_AFTER_REMOVE_USER);

        return $this;
    }

    /**
     * Method for sending a message to the chat.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(3, 56)
     *      ->sendMessage("Where are U?");
     *
     * // second example
     * Yii::$app->mainChat
     *      ->sendMessage("Have a nice day ;)", 56, 3);
     *
     * // third example
     * Yii::$app->mainChat
     *      ->createChat(1, 89)
     *      ->addUser([89, 809])
     *      ->sendMessage("Hello, my friend :)");
     * ```
     *
     * @param string $message Required parameter, message text
     * @param integer|null $userId, user id on whose behalf the message will be sent
     * @param integer|null $chatId chat id
     * @return $this
     * @throws DbException
     * @throws Exception if chat has not contains users
     * @see ChatBase::chat()
     * @see ChatBase::createChat()
     * @see ChatBase::addUser()
     */
    public function sendMessage($message, $userId = null, $chatId = null) {
        $this->trigger(self::EVENT_BEFORE_SEND_MESSAGE);

        if($chatId != null && !self::isChatExists($chatId)) {
            throw new DbException("Chat is not exists!");
        }
        $chat = ($chatId == null) ? $this->_chatId : $chatId;
        $user = ($userId == null) ? $this->_userId : $userId;

        if(!self::isChatHasUsers($chat)) {
            throw new Exception("Chat has not contains users!");
        }

        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $chatMessage = new ChatMessage();
            $chatMessage->chat_id = $chat;
            $chatMessage->user_id = $user;
            $chatMessage->message = $message;

            if($this->enableMessageModeration) {
                $chatMessage->moderation = false;
            }

            if($chatMessage->validate() && $chatMessage->save()) {
                if($this->enableHashString) {
                    $key = '7e5f277456322b5bdbaa54ec9aafe864c1d42bda';
                    $data = $chatMessage->id;
                    $hash = hash_hmac('md5', $data, $key);

                    $chatMessage->hash = $hash;
                    $chatMessage->save(false);
                }
            }

            /** @var ChatUser[] $users */
            $users = ChatUser::find()
                ->select('user_id')
                ->where(['chat_id' => $chat])
                ->all();

            foreach ($users as $u) {
                /** @var ChatMessageUser $messageUser */
                $messageUser = new ChatMessageUser();
                $messageUser->user_id = $u->user_id;
                $messageUser->message_id = $chatMessage->id;

                if ($u->user_id == $user) {
                    $messageUser->unread = false;
                }
                $messageUser->save(false);
            }

            $transaction->commit();
        }
        catch(DbException $error) {
            $transaction->rollBack();
            throw $error;
        }

        $this->trigger(self::EVENT_AFTER_SEND_MESSAGE);

        return $this;
    }

    /**
     * Method for remove message from the chat.
     *
     * Method not delete a message really,
     * it just set status `REMOVED` for message.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(1, 2)
     *      ->removeMessage(45);
     *
     * // second example
     * Yii::$app->mainChat
     *      ->removeMessage(45, 2);
     *
     * // third example
     * Yii::$app->mainChat
     *      ->removeMessage([45, 46, 49], 2);
     *```
     *
     * @param integer|integer[] $messageId Required parameter, message id or array of messages id
     * @param integer|null $userId
     * @return $this
     * @throws DbException
     * @throws Exception if message is not exists
     * @see ChatBase::chat()
     */
    public function removeMessage($messageId, $userId = null) {
        $this->trigger(self::EVENT_BEFORE_REMOVE_MESSAGE);

        $user = ($userId == null) ? $this->_userId : $userId;

        if(is_array($messageId)) {

            /** @var integer[] $messagesId */
            $messagesId = $messageId;

            /** @var ChatMessageUser[] $messages */
            $messages = ChatMessageUser::findAll([
                'user_id' => $user,
                'message_id' => $messagesId
            ]);

            if($messages == null) {
                throw new Exception("Message is not exists!");
            }

            $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                foreach ($messages as $message) {
                    $message->status_id = ChatStatus::STATUS_REMOVED;
                    $message->save(false);
                }
                $transaction->commit();
            }
            catch(DbException $error) {
                $transaction->rollBack();
                throw $error;
            }
        }
        else {
            /** @var ChatMessageUser $message */
            $message = ChatMessageUser::findOne(['user_id' => $user, 'message_id' => $messageId]);
            if($message != null) {
                $message->status_id = ChatStatus::STATUS_REMOVED;
                $message->save(false);
            }
            else {
                throw new Exception("Message is not exists!");
            }

        }

        $this->trigger(self::EVENT_AFTER_REMOVE_MESSAGE);

        return $this;
    }

    /**
     * Method for remove the message from all users
     *
     * Usage example
     * ```php
     * Yii::$app->mainChat
     *      ->removeMessageFromAll(245);
     * ```
     *
     * @param integer $messageId id of the message
     * @return $this
     */
    public function removeMessageFromAll($messageId) {
        /** @var ChatMessage $message */
        $message = ChatMessage::findOne(['message_id' => $messageId]);
        $message->status_id = ChatStatus::STATUS_REMOVED;
        $message->save(false);

        return $this;
    }

    /**
     * Method for editing the message.
     *
     * Usage example
     * ```php
     * Yii::$app->mainChat
     *      ->editMessage(101, "Hello!");
     * ```
     *
     * @param integer $messageId Required parameter, message id which you want to edit
     * @param string $editedMessage Required parameter, edited message text
     * @return $this|null
     * @throws DbException
     * @throws Exception if message is not exists
     * @see ChatBase::chat()
     */
    public function editMessage($messageId, $editedMessage) {
        $this->trigger(self::EVENT_BEFORE_EDIT_MESSAGE);

        /** @var ChatMessage $message */
        $message = ChatMessage::findOne($messageId);
        if($message != null) {
            $message->message = $editedMessage;
            try {
                $message->validate();
                $message->save();
            }
            catch(DbException $error) {
                throw $error;
            }
        }
        else {
            throw new Exception("Message is not exists!");
        }

        $this->trigger(self::EVENT_AFTER_EDIT_MESSAGE);

        return $this;
    }

    /**
     * Method for search the message in the chat by keyword.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(2, 78)
     *      ->searchMessageByKeyword("waiting for");
     *
     * // second example
     * Yii::$app->mainChat
     *      ->searchMessageByKeyword("waiting for", 2);
     * ```
     *
     * @param string $keyword  Required parameter, keyword string
     * @param integer|null $chatId chat id where you want to find the message
     * @return array|ChatMessage[]
     * @see ChatBase::chat()
     */
    public function searchMessageByKeyword($keyword, $chatId = null) {
        $chat = ($chatId == null) ? $this->_chatId : $chatId;

        /** @var ChatMessage $messages */
        $messages = ChatMessage::find()
            ->where(['chat_id' => $chat])
            ->andWhere(['like', 'message', $keyword])
            ->all();

        return $messages;
    }

    /**
     * Method for read a one message in the chat.
     *
     * This method just set `false` value for `unread`
     * field in the @see ChatMessageUser entity.
     *
     * ```php
     * //first example
     * Yii::$app->mainChat
     *      ->chat(2, 90)
     *      ->readMessage(102);
     *
     * // second example
     * Yii::$app->mainChat
     *      ->readMessage(102, 90);
     * ```
     *
     * @param integer $messageId message id
     * @param integer|null $userId user id who read the message
     * @return $this
     * @throws Exception if message is not found
     * @see ChatBase::chat()
     */
    public function readMessage($messageId, $userId = null) {
        $user = ($userId == null) ? $this->_userId : $userId;

        /** @var ChatMessageUser $message */
        $message = ChatMessageUser::findOne([
            'message_id' => $messageId,
            'user_id' => $user,
            'unread' => true
        ]);

        if($message == null) {
            throw new Exception("Message is not found!");
        }

        $message->unread = false;
        $message->save(false);

        return $this;
    }

    /**
     * Method for read many messages in the chat.
     *
     * This method just set `false` value for `unread`
     * field in the @see ChatMessageUser entity.
     *
     * Usage example
     * ```php
     * // first example
     * Yii::$app->mainChat
     *      ->chat(4, 65)
     *      ->readMessages();
     *
     * // second example
     * Yii::$app->mainChat
     *      ->readMessages(4, 65);
     * ```
     *
     * @param integer|null $chatId chat id
     * @param integer|null $userId user id who read the message
     * @return $this
     * @throws DbException
     * @see ChatBase::chat()
     */
    public function readMessages($chatId = null, $userId = null) {
        $chat = ($chatId == null) ? $this->_chatId : $chatId;
        $user = ($userId == null) ? $this->_userId : $userId;

        $usersId = ChatUser::find()
            ->select('user_id')
            ->where([
                'chat_id' => $chat,
                'user_id' => $user
            ])
            ->andWhere(['<>', 'status_id', ChatStatus::STATUS_REMOVED])
            ->all();

        /** @var ChatMessageUser[] $messages */
        $messages = ChatMessageUser::findAll([
            'user_id' => ArrayHelper::getColumn($usersId, 'user_id'),
            'unread' => true
        ]);

        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            foreach ($messages as $msg) {
                $msg->unread = false;
                $msg->save(false);
            }

            $transaction->commit();
        }
        catch(DbException $error) {
            $transaction->rollBack();
            throw $error;
        }

        return $this;
    }
}
