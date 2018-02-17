<?php
namespace Capture\Config;

use Aura\Di\Config;
use Aura\Di\Container;
use GuzzleHttp\Client;

class Common extends Config
{
    public function define(Container $container)
    {
        try {
            $datetime = new \DateTimeImmutable();
            $filename = hash_hmac('md5', $datetime->getTimestamp(), 'capture');

            // ScreenShot
            $container->set(
                'screenshot',
                $container->lazyNew(
                    'Capture\Module\ScreenShot',
                    [sys_get_temp_dir(), $filename, 'gif']
                )
            );

            // Upload
            $container->set(
                'upload',
                $container->lazyNew(
                    'Capture\Module\BitbucketUpload',
                    [
                        $container->newInstance(Client::class),
                        $datetime->format('YmdHis') . 'capture.gif'
                    ]
                )
            );

            $container->params['Capture\Capture'] = [
                'context' => $container->lazyGet('aura/cli-kernel:context'),
                'stdio' => $container->lazyGet('aura/cli-kernel:stdio'),
                'shot' => $container->lazyGet('screenshot'),
                'upload' => $container->lazyGet('upload'),
            ];
        } catch (\Exception $e) {
            throw new \LogicException();
        }
    }

    public function modify(Container $container)
    {
        try {
            $dispatcher = $container->get('aura/cli-kernel:dispatcher');
            $dispatcher->setObject('capture', $container->lazyNew('Capture\Capture'));
        } catch (\Exception $e) {
            throw new \LogicException();
        }
    }
}
