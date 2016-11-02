<?php

namespace JobBundle\State;


trait StateTrait
{
    public function setPending()
    {
        $state = new State();
        return $state->pending()->__toString();
    }

    public function setPublished()
    {
        $state = new State();
        return $state->published()->__toString();
    }

    public function setSpam()
    {
        $state = new State();
        return $state->spam()->__toString();
    }
}