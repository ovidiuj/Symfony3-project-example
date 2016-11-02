<?php

namespace JobBundle\State;


interface StateInterface
{
    /**
     *
     */
    const STATE_PENDING = 'pending';

    /**
     *
     */
    const STATE_PUBLIC = 'public';

    /**
     *
     */
    const STATE_SPAM = 'spam';

    /**
     * @return string
     */
    public function pending();

    /**
     * @return State
     */
    public function published();

    /**
     * @return State
     */
    public function spam();

    /**
     * @return bool
     */
    public function isPublic();

    /**
     * @return bool
     */
    public function isPending();

    /**
     * @return bool
     */
    public function isSpam();
}