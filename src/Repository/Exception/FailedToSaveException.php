<?php

namespace WishApp\Repository\Exception;

class FailedToSaveException extends \Exception
{
    protected $message = 'Failed to store in database';
}
