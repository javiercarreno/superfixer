<?php

namespace Superfixer\Fixers;

class FixerFactory
{
    const PHP = "PHP";
    const BEHAT = "FEATURE";

    public static function getFixer($file)
    {
        switch (self::getExtension($file)) {
            case self::PHP:
                return (new PhpFixer())
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
