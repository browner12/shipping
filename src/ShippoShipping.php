<?php namespace browner12\shipping;

use browner12\shipping\Contracts\Order;
use browner12\shipping\Contracts\OrderLine;
use Shippo;

class ShippoShipping implements ShippingInterface
{
    /**
     * constructor
     */
    public function __construct()
    {
        Shippo::setApiKey(config('shipping.api_key'));
    }

    /**
     * create a shipment
     *
     * @param mixed $to
     * @param mixed $from
     * @param mixed $parcel
     * @param mixed $customs
     * @return mixed
     */
    public function shipment($to, $from, $parcel, $customs)
    {
        // TODO: Implement shipment() method.
    }

    /**
     * create an address
     *
     * @param string $name
     * @param string $street
     * @param string $street2
     * @param string $city
     * @param string $state
     * @param string $zip
     * @param string $country
     * @return mixed
     */
    public function address($name, $street, $street2, $city, $state, $zip, $country)
    {
        // TODO: Implement address() method.
    }

    /**
     * create a parcel
     *
     * @param float $weight
     * @param float $length
     * @param float $width
     * @param float $height
     * @return mixed
     */
    public function parcel($weight, $length, $width, $height)
    {
        // TODO: Implement parcel() method.
    }

    /**
     * create a customs info
     *
     * @param \browner12\shipping\Contracts\Order $order
     * @return mixed
     */
    public function customsInfo(Order $order)
    {
        // TODO: Implement customsInfo() method.
    }

    /**
     * create a customs item
     *
     * @param \browner12\shipping\Contracts\OrderLine $orderLine
     * @return mixed
     */
    public function customsItem(OrderLine $orderLine)
    {
        // TODO: Implement customsItem() method.
    }

    /**
     * determine if the shipment requires an Exception and Exclusion Legend (EEL)
     * or a Proof of Filing Citation (PFC) and return the appropriate value
     *
     * @param \browner12\shipping\Contracts\Order $order
     * @return string
     */
    public function eecPfc(Order $order)
    {
        // TODO: Implement eecPfc() method.
    }

    /**
     * purchase a shipment
     *
     * @param string $shipmentId
     * @param string $rateId
     * @return mixed
     */
    public function purchase($shipmentId, $rateId)
    {
        // TODO: Implement purchase() method.
    }

    /**
     * create a label
     *
     * @param string $shipmentId
     * @return mixed
     */
    public function label($shipmentId)
    {
        // TODO: Implement label() method.
    }

    /**
     * track the shipment
     *
     * @param int $trackingId
     * @return mixed
     */
    public function track($trackingId)
    {
        // TODO: Implement track() method.
    }
}
