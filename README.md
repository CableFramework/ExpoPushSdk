# ExpoPushSdk
include 'vendor/autoload.php';
```php 

// set your users
$users = (new \Cable\Expo\ExpoUserBag())->setUsers(array(
    'YourToken'
));


$expo = new \Cable\Expo\ExpoSdk();
$expo->setUsers($users);

// create your message
$message = \Cable\Expo\ExpoMessage::create('Test Mesaj', 'test icerik')->enableSound();

// send messages
$expo->notify($message, function (\Cable\Expo\ExpoSentMessage $message) {
    var_dump($message->getToken(), $message->isSucceed());
});
```