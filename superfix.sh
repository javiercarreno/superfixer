#!/usr/bin/env php
<?php
$x=1;
$csFixerPath = getFixerPath();
if ($csFixerPath=="") {
    echo "No php-cs-fixer found";
    die();
}
$files = $files = getFilesFromGitStatus();

if(count($files)>0) {
    fixFiles($csFixerPath,$files);
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

function getFilesFromGitStatus()
{
    $files=[];
    $output = shell_exec('git status -s -uno');
    $outputLines = explode("\n",$output);
    foreach($outputLines as $line) {
        $line = substr($line,3,strlen($line)-3);
        if (substr($line, strlen($line) - 4, 4) == ".php") {
            $files[] = $line;
        }
    }
    return $files;
}

function fixFiles($command, $files)
{
    foreach ($files as $file){
        echo "\033[1;33mfixing ".$file."\033[0m\n**\n";
        $output = shell_exec($command." fix ".$file);
        echo "\033[32m".$output."\033[0m**\n";
    }
}
