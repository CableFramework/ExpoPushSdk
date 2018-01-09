<?php

namespace Cable\Expo;

class ExpoSentMessage
{

    /**
     * @var boolean
     */
    private $succeed;

    /**
     * @var integer
     */
    private $error;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var string
     */
    private $token;

    /**
     * ExpoSentMessage constructor.
     * @param string $token
     * @param bool|null $succeed
     * @param null $error
     * @param null $errorMessage
     */
    public function __construct($token, $succeed = null, $error = null, $errorMessage = null)
    {
        $this->token = $token;
        $this->error = $error;
        $this->errorMessage = $errorMessage;
        $this->succeed = $succeed;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return ExpoSentMessage
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }



    /**
     * @return bool
     */
    public function isSucceed()
    {
        return $this->succeed;
    }

    /**
     * @param bool $succeed
     * @return ExpoSentMessage
     */
    public function setSucceed($succeed)
    {
        $this->succeed = $succeed;
        return $this;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param int $error
     * @return ExpoSentMessage
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return ExpoSentMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }
}

