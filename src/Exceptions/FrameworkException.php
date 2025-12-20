<?php

namespace Src\Exceptions;
use Exception;

class FrameworkException extends Exception{

    protected int $statusCode;
    protected string $title;
    protected string $description;

    public function getStatusCode():int 
    {
        return $this->statusCode;
    }

    public function getTitle():string 
    {
        return $this->title;
    }

    public function getDescription():string 
    {
        return $this->description;
    }

}