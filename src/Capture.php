<?php
namespace Capture;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Capture\Module\ScreenShot;
use Capture\Module\BitbucketUpload;

/**
 * Class Capture
 *
 * @package Capture
 */
class Capture
{
    private $context;
    private $stdio;
    private $shot;
    private $upload;

    /**
     * Capture constructor.
     *
     * @param Context         $context
     * @param Stdio           $stdio
     * @param ScreenShot      $shot
     * @param BitbucketUpload $upload
     */
    public function __construct(Context $context, Stdio $stdio, ScreenShot $shot, BitbucketUpload $upload)
    {
        $this->context = $context;
        $this->stdio = $stdio;
        $this->shot = $shot;
        $this->upload = $upload;
    }

    /**
     * execute.
     *
     * @return void
     */
    public function __invoke()
    {
        $screenCapture = $this->shot;
        if ($screenCapture()) {
            $this->upload->setContents($screenCapture->filename());
            $this->upload->execute();
        }

        $this->stdio->outln($this->upload->getRawUrl());
    }
}
