<?php namespace browner12\shipping;

use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * register bindings
     */
    public function register()
    {
        $this->app->bind('App\Shipping\ShippingInterface', 'App\Shipping\EasypostShipping');
    }

}
