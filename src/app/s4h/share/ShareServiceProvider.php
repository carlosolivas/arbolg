<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 12/11/14
 * Time: 0:08
 */

namespace s4h\share;

use Illuminate\Support\ServiceProvider;

class ShareServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
            'sharing',
            's4h\share\Sharing'
        );

        $this->app->bind(
            's4h\share\ShareRepositoryInterface',
            's4h\share\DbShareRepository'
        );

        $this->app->events->subscribe(new ShareEventHandler());
    }
} 