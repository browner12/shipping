<?php namespace browner12\shipping;

use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('browner12\shipping\ShippingInterface', $this->getShippingService());
    }

    /**
     * boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        //publish config
        $this->publishes([
            __DIR__ . '/config/shipping.php' => config_path('shipping.php'),
        ]);
    }

    /**
     * determine the shipping service to use
     *
     * @return string
     */
    private function getShippingService()
    {
        switch (config('shipping.default')) {

            //easypost
            case 'easypost':

                return 'browner12/shipping/EasypostShipping';
                break;

            //shippo
            case 'shippo':

                return 'browner12/shipping/ShippoShipping';
                break;

            //default
            default:

                return '';
                break;
        }
    }
}
