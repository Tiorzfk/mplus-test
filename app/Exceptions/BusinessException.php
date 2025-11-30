<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
  protected $status;

  public function __construct($message = "Business logic error", $status = 400)
  {
    parent::__construct($message);
    $this->status = $status;
  }

  public function getStatusCode()
  {
    return $this->status;
  }
}
