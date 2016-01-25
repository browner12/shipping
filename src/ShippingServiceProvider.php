<?php namespace browner12\shipping;

use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * register bindings
     */
    public function register()
    {
        $this->app->bind('browner12\shipping\ShippingInterface', 'browner12\shipping\EasypostShipping');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/shipping.php' => config_path('shipping.php'),
        ]);
    }
}
