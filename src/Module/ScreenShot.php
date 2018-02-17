<?php
namespace Capture\Module;

use Symfony\Component\Process\Process;

/**
 * Class ScreenShot
 *
 * @package Capture\Module
 */
class ScreenShot
{
    private $tmpDir;
    private $name;
    private $format;

    /**
     * ScreenShot constructor.
     *
     * @param string $tmpDir temporary dir
     * @param string $name   capture name
     * @param string $format format type (png,jpg,gif,tiff,pdf)
     */
    public function __construct($tmpDir, $name, $format = 'png')
    {
        $this->tmpDir = $tmpDir;
        $this->name = $name;
        $this->format = $format;
    }

    /**
     * Execute.
     * TODO オプションをコントロールせな
     *
     * @return bool
     */
    public function __invoke()
    {
        $process = new Process(['/usr/sbin/screencapture', '-ai', '-t', $this->format, $this->filename()]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('ScreenShot failed to be processed.');
        }

        return $process->isSuccessful();
    }

    /**
     * FileName.
     *
     * @return string
     */
    public function filename()
    {
        return $this->tmpDir . $this->name . '.' . $this->format;
    }
}
