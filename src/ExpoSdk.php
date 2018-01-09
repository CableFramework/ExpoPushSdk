<?php

namespace Cable\Expo;

use Cable\Expo\Exceptions\RequestErrorException;
use RollingCurl\Request;
use RollingCurl\RollingCurl;

class ExpoSdk
{

    const INTERNAL_SERVER_ERROR = 500;
    const UNKNOWN_ERROR = 404;
    const NOT_REGISTERED_ERROR = 400;

    private $errors = [
        'INTERNAL_SERVER_ERROR' => self::INTERNAL_SERVER_ERROR,
        'UNKNOWN_ERROR' => self::UNKNOWN_ERROR,
        'NOT_REGISTERED_ERROR' => self::NOT_REGISTERED_ERROR
    ];

    /**
     * @var ExpoUserBag
     */
    private $users;


    const EXPO_API_URL = 'https://exp.host/--/api/v2/push/send';

    /**
     * ExpoSdk constructor.
     * @param ExpoUserBag|null $userBag
     */
    public function __construct(ExpoUserBag $userBag = null)
    {
        $this->users = $userBag;
    }

    /**
     * @return ExpoUserBag
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ExpoUserBag $users
     * @return ExpoSdk
     */
    public function setUsers(ExpoUserBag $users)
    {
        $this->users = $users;
        return $this;
    }


    public function notify(ExpoMessage $message, callable $callback)
    {
        $userBag = $this->users;

        $users = $userBag->getUsers();

        if ($userBag->isChunked() === false && count($users) > 100) {
            $users = $userBag->chunk(100)->getUsers();
        }

        $message = $message->toArray();

        if ($userBag->isChunked()) {
            foreach ($users as $user) {
                $this->sendNotifications($user, $message, $callback);
            }
        } else {
            $this->sendNotifications($users, $message, $callback);
        }
    }

    private function sendNotifications(array $users, array $message, callable $callback)
    {
        $rolling = new RollingCurl();

        $bodyArray = array_map(function ($user) use ($message) {
            $message['to'] = $user;

            return $message;
        }, $users);


        $rolling->post(self::EXPO_API_URL, json_encode($bodyArray), [
            'accept: application/json',
            'content-type: application/json',
        ]);

        $rolling->setCallback(function (Request $request) use ($callback, $bodyArray) {
            $body = json_decode($request->getResponseText());
            if (isset($body->data)) {

                $data = $body->data;
                foreach ($data as $index => $sent) {
                    $to = $bodyArray[$index]['to'];

                    if ($sent->status === 'ok') {
                        $callback(new ExpoSentMessage($to, true, null, null));
                    } else {
                        $error = isset($this->errors[$sent->details->error]) ?
                            $this->errors[$sent->details->error] :
                            $this->errors['UNKNOWN_ERROR'];
                        $callback(new ExpoSentMessage($to, false, $error, $sent->message));
                    }

                }

            } else {
                $errorResponse = $body->errors[0];
                $errorMessage = $errorResponse['message'];

                throw new RequestErrorException(sprintf('Request has been failed: Code: %s, Message : %s', $errorMessage, $errorResponse['code']));
            }

        });

        $rolling->execute();

    }

}
