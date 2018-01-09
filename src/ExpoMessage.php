<?php

namespace Cable\Expo;

class ExpoMessage
{
    /**
     * The message body.
     *
     * @var string
     */
    protected $body;
    /**
     * The sound to play when the recipient receives this notification.
     *
     * @var string|null
     */
    protected $sound = 'default';
    /**
     * The number to display next to the push notification (iOS).
     * Specify zero to clear the badge.
     *
     * @var int
     */
    protected $badge = 0;
    /**
     * The number of seconds for which the message may be kept around for redelivery if it has not been delivered yet.
     *
     * @var int
     */
    protected $ttl = 0;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @param string $title
     * @param string $body
     *
     * @return static
     */
    public static function create($title = '', $body = '')
    {
        return new static($title, $body);
    }

    /**
     * ExpoMessage constructor.
     * @param string $title
     * @param string $body
     */
    public function __construct($title = '', $body = '')
    {
        $this->body = $body;
        $this->title = $title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the message body.
     *
     * @param string $value
     *
     * @return $this
     */
    public function body($value)
    {
        $this->body = $value;
        return $this;
    }

    /**
     * Enable the message sound.
     *
     * @return $this
     */
    public function enableSound()
    {
        $this->sound = 'default';
        return $this;
    }

    /**
     * Disable the message sound.
     *
     * @return $this
     */
    public function disableSound()
    {
        $this->sound = null;
        return $this;
    }

    /**
     * Set the message badge (iOS).
     *
     * @param int $value
     *
     * @return $this
     */
    public function badge($value)
    {
        $this->badge = $value;
        return $this;
    }

    /**
     * Set the time to live of the notification.
     *
     * @param int $ttl
     *
     * @return $this
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Get an array representation of the message.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'body' => $this->body,
            'sound' => $this->sound,
            'badge' => $this->badge,
            'ttl' => $this->ttl,
            'title' => $this->title,
        ];
    }
}