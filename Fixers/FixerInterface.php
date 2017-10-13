<?php

interface FixerInterface
{

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file);

    /**
     * @param string $file
     *
     * @return FixResult
     */
    public function fix();
}