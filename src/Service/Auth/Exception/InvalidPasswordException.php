<?php

namespace WishApp\Service\Auth\Exception;

class InvalidPasswordException extends \Exception
{
    protected $message = 'Password is invalid';
}
