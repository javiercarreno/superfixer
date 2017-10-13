<?php


class FixerFactory
{
    const PHP = "PHP";
    const BEHAT = "FEATURE";
    /**
     * @var string
     */
    private static $phpCsFixerPath;

    /**
     * @param string $path
     */
    public static function setPhpCsFixerPath($path) {
        self::$phpCsFixerPath = $path;
    }

    public static function getFixer($file) {
        switch(self::getExtension($file)) {
            case self::PHP:
                return (new PhpFixer(self::$phpCsFixerPath))
                    ->setFile($file);
            case self::BEHAT:
                return (new BehatFixer())
                    ->setFile($file);
        }
        return null;
    }

    /**
     * @param string $file
     *
     * @return string
     */
    private static function getExtension($file)
    {
        return strtoupper(pathinfo($file, PATHINFO_EXTENSION));
    }
}