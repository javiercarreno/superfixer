<?php

namespace Superfixer;

use Superfixer\Fixers\FixerFactory;
use Superfixer\Fixers\FixerInterface;
use Superfixer\Fixers\FixResult;

class Application
{
    const COLOR_FIXING = "\033[1;33m";

    const COLOR_DEFAULT = "\033[0m";

    const COLOR_SUCCESSFUL = "\033[32m";

    const COLOR_FAILURE = "\033[33m";

    public function run()
    {
        $fixers = $this->getFixersFromGitStatus();

        if(count($fixers)>0) {
            $this->fixFiles($fixers);
        }
        else {
            echo 'It seems that no file has changed (git status)';
        }
    }

    /**
     * @return FixerInterface[]
     */
    private function getFixersFromGitStatus()
    {
        $fixers=[];
        $output = shell_exec('git status -s -uno');
        $outputLines = explode("\n",$output);
        foreach($outputLines as $line) {
            $line = substr($line,3,strlen($line)-3);
            $fixer = FixerFactory::getFixer($line);
            if($fixer) {
                $fixers[] = $fixer;
            }
        }
        return $fixers;
    }

    /**
     * @param FixerInterface[] $fixers
     */
    private function fixFiles($fixers)
    {
        /**
         * @var $results FixResult[]
         */
        foreach ($fixers as $fixer){
            echo "" . self::COLOR_FIXING . "fixing " .$fixer->getFile(). "" . self::COLOR_DEFAULT . "\n**\n";
            $result = $fixer->fix();
            $outputColor = self::COLOR_SUCCESSFUL;
            if($result->isError()) {
                $outputColor = self::COLOR_FAILURE;
            }
            echo $outputColor.$result->getMessage(). self::COLOR_DEFAULT . "**\n";
        }
    }
}