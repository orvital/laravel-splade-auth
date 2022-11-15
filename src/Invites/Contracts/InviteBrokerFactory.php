<?php

namespace Orvital\Authority\Invites\Contracts;

interface InviteBrokerFactory
{
    /**
     * Get a invite broker instance by name.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function broker($name = null);
}
