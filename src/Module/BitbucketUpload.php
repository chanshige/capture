<?php
namespace Capture\Module;

use Capture\Util\Bitbucket;
use GuzzleHttp\Client as Guzzle;

/**
 * Class Upload
 *
 * @package Capture\Module
 */
class BitbucketUpload
{
    /** @var Guzzle */
    private $client;
    private $name;
    private $contents;

    /**
     * BitbucketUpload constructor.
     *
     * @param Guzzle $client
     * @param string $name filename
     */
    public function __construct(Guzzle $client, $name)
    {
        $this->client = $client;
        $this->name = $name;
    }

    /**
     * @param $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    public function execute()
    {
        $parameters = [
            'auth' => Bitbucket::auth(),
            'multipart' => [
                [
                    'name' => $this->name,
                    'contents' => fopen($this->contents, 'r')
                ]
            ]
        ];

        if (empty($this->contents)) {
            throw new \InvalidArgumentException();
        }

        $this->client->request('POST', Bitbucket::src(), $parameters);
    }

    /**
     * @return string
     */
    public function getRawUrl()
    {
        return Bitbucket::raw() . $this->name;
    }
}
