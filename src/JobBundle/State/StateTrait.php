<?php

namespace JobBundle\State;

/**
 * Class StateTrait
 * @package JobBundle\State
 */
trait StateTrait
{
    /**
     * @return string
     */
    public function setPending()
    {
        $state = new State();
        return $state->pending()->__toString();
    }

    /**
     * @return string
     */
    public function setPublished()
    {
        $state = new State();
        return $state->published()->__toString();
    }

    /**
     * @return string
     */
    public function setSpam()
    {
        $state = new State();
        return $state->spam()->__toString();
    }
}