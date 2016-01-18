<?php namespace browner12\shipping;

use EasyPost\Address;
use EasyPost\Parcel;

interface ShippingInterface
{
    /**
     * create a shipment
     *
     * @param \EasyPost\Address $to
     * @param \EasyPost\Parcel  $parcel
     * @return
     */
    public function shipment(Address $to, Parcel $parcel);

    /**
     * create an address
     *
     * @param array $input
     * @return mixed
     */
    public function address(array $input);

    /**
     * create a parcel
     *
     * @param float $weight
     * @return mixed
     */
    public function parcel($weight);

    /**
     * purchase
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
