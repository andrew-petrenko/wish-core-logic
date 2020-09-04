<?php

namespace WishApp\Service\Auth\Exception;

class EmailAlreadyInUseException extends \Exception
{
    protected $message = 'Email already in use';
}
