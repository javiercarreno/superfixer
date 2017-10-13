<?php

namespace Superfixer\Fixers;

interface FixerInterface
{

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file);

    /**
     * @return string
     */
    public function getFile();

    /**
     * @param string $file
     *
     * @return FixResult
     */
    public function fix();
}