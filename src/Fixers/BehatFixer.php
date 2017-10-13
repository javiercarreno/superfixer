<?php

namespace Superfixer\Fixers;

class BehatFixer implements FixerInterface
{
    private $behatIndentations = [
        'Feature' => 0,
        'Background' => 2,
        'Scenario' => 2,
        'Given' => 4,
        'When' => 5,
        'Then' => 5,
        'And' => 6,
        '|' => 8
    ];
    /**
     * @var string
     */
    private $file;

    public function fix()
    {
        $lines = [];
        if (!file_exists($this->file)) {
            return new FixResult(true, 'File does not exist: '.$this->file);
        }

        $handle = fopen($this->file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lines[] = $this->formatLine($line);
            }
            fclose($handle);
            $handle = fopen($this->file, "w");
            if ($handle) {
                foreach ($lines as $line) {
                    fwrite($handle, $line);
                }
            }
            fclose($handle);
            return new FixResult(false, 'File formatted correctly.'."\n");
        } else {
            return new FixResult(true, 'Error opening file: '.$this->file);
        }
    }

    /**
     * @param string $line
     *
     * @return string
     */
    private function formatLine($line)
    {
        $line = ltrim($line, ' ');
        foreach ($this->behatIndentations as $key=>$value) {
            if (0===strpos($line, $key)) {
                return str_pad($line, $value +strlen($line), " ", STR_PAD_LEFT);
            }
        }
        return $line;
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
