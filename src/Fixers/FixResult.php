<?php

namespace Superfixer\Fixers;

class FixResult
{
    /**
     * @var bool
     */
    private $error;

    /**
     * @var string
     */
    private $message;

    /**
     * @param bool $error
     * @param string $message
     *
     */
    public function __construct($error, $message)
    {
        $this->error = $error;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
