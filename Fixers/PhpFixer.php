<?php


class PhpFixer implements FixerInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $phpCsFixerPath;

    /**
     * @param string $phpCsFixerPath
     */
    public function __construct($phpCsFixerPath)
    {
        $this->phpCsFixerPath = $phpCsFixerPath;
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
     * @param string $file
     *
     * @return FixResult
     */
    public function fix()
    {
        if (!file_exists($this->file)) {
            return new FixResult(true,'File not found: '.$this->file);
        }

        echo 'fixing '.$this->file."\n**\n";
        $output = shell_exec($this->phpCsFixerPath." fix ".$this->file);
        echo $output."**\n";

        return new FixResult(false, null);
    }
}