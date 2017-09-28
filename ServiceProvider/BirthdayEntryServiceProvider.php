<?php

namespace Plugin\BirthdayEntry\ServiceProvider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Plugin\BirthdayEntry\Form\Extension\EntryTypeExtension;

/**
 * Class BirthdayEntryServiceProvider
 * @package Plugin\FormExtension\ServiceProvider
 */
class BirthdayEntryServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->extend(
            'form.type.extensions',
            function ($extensions) use ($app) {
                $extensions[] = new EntryTypeExtension($app);

                return $extensions;
            }
        );
    }
}
