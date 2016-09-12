Component with basic methods for work with chat
==========
Installation
------------
#### Run command
```
composer require black-lamp/blcms-chat
```
or add
```json
"black-lamp/blcms-chat": "*"
```
to the require section of your composer.json.
#### Applying migrations
yii migrate --migrationPath=@vendor/black-lamp/blcms-chat/migrations
#### Add 'ChatBase' component to application config
```php
'components' => [
      // ...
      'mainChat' => [
          'class' => bl\cms\chat\ChatBase::className(),
          'enableMessageModeration' => true // for moderation messages in the chat
      ]
 ]
```