<?php

namespace Superfixer\Fixers;

class PhpFixer implements FixerInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @return FixResult
     */
    public function fix()
    {
        if (!file_exists($this->file)) {
            return new FixResult(true,'File not found: '.$this->file);
        }
        $output = shell_exec($this->phpCsFixerPath." fix ".$this->file);

        return new FixResult(false, $output);
    }

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}