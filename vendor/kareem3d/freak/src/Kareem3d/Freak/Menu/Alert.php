<?php namespace Kareem3d\Freak\Menu;

class Alert {

    const HIGH_PRIORITY = 3;
    const MEDIUM_PRIORITY = 2;
    const LOW_PRIORITY = 1;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @param $message
     * @param $priority
     */
    public function __construct( $message, $priority = self::LOW_PRIORITY )
    {
        $this->message = $message;
        $this->priority = $priority;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMessage();
    }
}