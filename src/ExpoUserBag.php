<?php

namespace Cable\Expo;


use Cable\Expo\Exceptions\ChunkSizeException;

class ExpoUserBag
{

    /**
     * @var array
     */
    private $users;

    /**
     * @var bool
     */
    private $chunked = false;

    /**
     * ExpoUserBag constructor.
     * @param array $users
     */
    public function __construct(array $users = [])
    {
        $this->users = $users;
    }

    /**
     * @param int $size
     * @throws ChunkSizeException
     * @return ExpoUserBag
     */
    public function chunk($size = 100){
        if ($size>100) {
            throw new ChunkSizeException('Maximum chunk size is 100');
        }

        $this->users =  array_chunk($this->users, $size);

        $this->chunked = true;

        return $this;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param array $users
     * @return ExpoUserBag
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return bool
     */
    public function isChunked()
    {
        return $this->chunked;
    }

    /**
     * @param bool $chunked
     * @return ExpoUserBag
     */
    public function setChunked($chunked)
    {
        $this->chunked = $chunked;
        return $this;
    }



}