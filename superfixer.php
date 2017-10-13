<?php
$x=1;
$csFixerPath = getFixerPath();
if ($csFixerPath=="") {
    echo "No php-cs-fixer found";
    die();
}
$fixers = getFixersFromGitStatus($csFixerPath);

if(count($fixers)>0) {
    fixFiles($fixers);
}
else {
    echo 'It seems that no php file has changed (git status)';
}

function getFixerPath()
{
    $possiblePaths = [
        "/vendor/bin/php-cs-fixer",
        "/oms/bin/php-cs-fixer",
        "/bin/php-cs-fixer",
        "/php-cs-fixer",
        "/vendor/friendsofphp/php-cs-fixer/php-cs-fixer"
    ];
    $path = getcwd();
    foreach($possiblePaths as $possiblePath) {
        if (file_exists($path.$possiblePath)) {
            return $path.$possiblePath;
        }
    }
    return "";
}

/**
 * @param string $phpCsFixerPath
 * @return FixerInterface[]
 */
function getFixersFromGitStatus($phpCsFixerPath)
{
    FixerFactory::setPhpCsFixerPath($phpCsFixerPath);
    $fixers=[];
    $output = shell_exec('git status -s -uno');
    $outputLines = explode("\n",$output);
    foreach($outputLines as $line) {
        $line = substr($line,3,strlen($line)-3);
        $fixers[] = FixerFactory::getFixer($line);
    }
    return $fixers;
}

/**
 * @param FixerInterface[] $fixers
 */
function fixFiles($fixers)
{
    /**
     * @var $results FixResult[]
     */
    $results = [];
    foreach ($fixers as $fixer){
        $results[] = $fixer->fix();
    }

    foreach ($results as $result) {
        if ($result->isError()) {
            echo 'FIX ERROR: '.$result->getMessage();
        }
    }
}