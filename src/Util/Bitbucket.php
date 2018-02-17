<?php
namespace Capture\Util;

class Bitbucket
{
    private static $master = 'https://bitbucket.org/';
    private static $endpoint = 'https://api.bitbucket.org/2.0/repositories/';

    /**
     * [GET] This endpoint redirects the client to the directory listing of the root directory on the main branch.
     * [POST] This endpoint is used to create new commits in the repository by uploading files.
     *
     * @return string
     */
    public static function src()
    {
        return self::$endpoint .
            getenv('BITBUCKET_USER_NAME') .
            '/' . getenv('BITBUCKET_REPOSITORY_NAME') . '/src';
    }

    /**
     * Raw.
     *
     * @return string
     */
    public static function raw()
    {
        return self::$master .
            getenv('BITBUCKET_USER_NAME') .
            '/' . getenv('BITBUCKET_REPOSITORY_NAME') . '/raw/master/';
    }

    /**
     * Auth.
     *
     * @return array
     */
    public static function auth()
    {
        return [
            getenv('BITBUCKET_USER_NAME'),
            getenv('BITBUCKET_APP_PASSWORD')
        ];
    }
}
