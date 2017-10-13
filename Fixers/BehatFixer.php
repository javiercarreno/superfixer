<?php


class BehatFixer implements FixerInterface
{

    /**
     * @var string
     */
    private $file;

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function fix()
    {

    }
}