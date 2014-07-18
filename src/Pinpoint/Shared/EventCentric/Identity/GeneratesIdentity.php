<?php

namespace Pinpoint\Shared\EventCentric\Identity;

interface GeneratesIdentity
{
    /**
     * @return Identity
     */
    public static function generate();
}
