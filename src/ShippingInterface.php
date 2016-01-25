<?php namespace browner12\shipping;

use browner12\shipping\Contracts\Order;
use browner12\shipping\Contracts\OrderLine;

interface ShippingInterface
{
    /**
     * create a shipment
     *
     * @param mixed $to
     * @param mixed $from
     * @param mixed $parcel
     * @param mixed $customs
     * @return mixed
     */
    public function shipment($to, $from, $parcel, $customs);

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
    public function address($name, $street, $street2, $city, $state, $zip, $country);

    /**
     * create a parcel
     *
     * @param float $weight
     * @param float $length
     * @param float $width
     * @param float $height
     * @return mixed
     */
    public function parcel($weight, $length, $width, $height);

    /**
     * create a customs info
     *
     * @param \browner12\shipping\Contracts\Order $order
     * @return mixed
     */
    public function customsInfo(Order $order);

    /**
     * create a customs item
     *
     * @param \browner12\shipping\Contracts\OrderLine $orderLine
     * @return mixed
     */
    public function customsItem(OrderLine $orderLine);

    /**
     * determine if the shipment requires an Exception and Exclusion Legend (EEL)
     * or a Proof of Filing Citation (PFC) and return the appropriate value
     *
     * @param \browner12\shipping\Contracts\Order $order
     * @return string
     */
    public function eecPfc(Order $order);

    /**
     * purchase a shipment
     *
     * @param string $shipmentId
     * @param string $rateId
     * @return mixed
     */
    public function purchase($shipmentId, $rateId);

    /**
     * create a label
     *
     * @param string $shipmentId
     * @return mixed
     */
    public function label($shipmentId);

    /**
     * track the shipment
     *
     * @param int $trackingId
     * @return mixed
     */
    public function track($trackingId);
}
