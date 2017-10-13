<?php

namespace Superfixer\Fixers;

use PhpCsFixer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\StreamOutput;

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
            return new FixResult(true, 'File not found: '.$this->file);
        }
        $params = ['fix',__DIR__.'/'.$this->file];
        $input = new ArrayInput($params);
        $output = new BufferedOutput();
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        try {
            $application->run($input, $output);
            return new FixResult(false, $output->fetch());
        } catch (\Exception $ex) {
            return new FixResult(true, "Error while fixing php: ".$ex->getMessage());
        }
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
