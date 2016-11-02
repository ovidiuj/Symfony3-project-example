<?php

namespace JobBundle\State;

/**
 * Class State
 * @package JobBundle\State
 */
class State implements StateInterface
{
    /**
     * @var string
     */
    private $state;

    /**
     * State constructor.
     * @param $state
     */
    public function __construct($state = null)
    {
        if ($state && !$this->isAValidState($state)) {
            throw new \Exception('Invalid state ...');
        }
        $this->state = $state;
    }

    /**
     * @return State
     */
    public function pending()
    {
        return new self(self::STATE_PENDING);
    }

    /**
     * @return State
     */
    public function published()
    {
        return new self(self::STATE_PUBLIC);
    }

    /**
     * @return State
     */
    public function spam()
    {
        return new self(self::STATE_SPAM);
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return ($this->state == self::STATE_PUBLIC);
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return ($this->state == self::STATE_PENDING);
    }

    /**
     * @return bool
     */
    public function isSpam()
    {
        return ($this->state == self::STATE_SPAM);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->state;
    }

    /**
     * @param $state
     * @return bool
     */
    private function isAValidState($state)
    {
        if ($state !== self::STATE_PUBLIC && $state !== self::STATE_PENDING && $state !== self::STATE_SPAM)
        {
            return false;
        }
        return true;
    }
}