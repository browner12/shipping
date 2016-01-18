<?php namespace browner12\shipping;

use EasyPost\Address;
use EasyPost\EasyPost;
use EasyPost\Error as EasyPostException;
use EasyPost\Parcel;
use EasyPost\Rate;
use EasyPost\Shipment;
use EasyPost\Tracker;
use Exception;

class EasyPostShipping implements ShippingInterface
{
    /**
     * constructor
     */
    public function __construct()
    {
        //set easypost api key
        EasyPost::setApiKey(env('EASYPOST_SECRET_KEY'));
    }

    /**
     * create a shipment
     *
     * @param \EasyPost\Address $to
     * @param \EasyPost\Parcel  $parcel
     * @return \EasyPost\Shipment
     * @throws \App\Shipping\ShippingException
     */
    public function shipment(Address $to, Parcel $parcel)
    {
        //from address
        $from = $this->fromAddress();

        //shipment
        try {
            $shipment = Shipment::create([
                "to_address"   => $to,
                "from_address" => $from,
                "parcel"       => $parcel,
            ]);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Unable to create shipment.', 0, $e);
        }

            //exception
        catch (Exception $e) {
            throw new ShippingException('Unable to create shipment.', 0, $e);
        }

        //return
        return $shipment;
    }

    /**
     * address
     *
     * @param array $input
     * @return \EasyPost\Address
     * @throws \App\Shipping\ShippingException
     */
    public function address(array $input)
    {
        //address
        $inputAddress['name'] = (isset($input['name'])) ? $input['name'] : null;
        $inputAddress['street1'] = (isset($input['street'])) ? $input['street'] : null;
        $inputAddress['street2'] = (isset($input['street2'])) ? $input['street2'] : null;
        $inputAddress['city'] = (isset($input['city'])) ? $input['city'] : null;
        $inputAddress['state'] = (isset($input['state'])) ? $input['state'] : null;
        $inputAddress['zip'] = (isset($input['zip'])) ? $input['zip'] : null;
        $inputAddress['country'] = (isset($input['country']) ? $input['country'] : null);

        //try to create address object
        try {
            $address = Address::create($inputAddress);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Easypost exception creating address.', 0, $e);
        }

        //return address object
        return $address;
    }

    /**
     * snb from address
     *
     * @return \EasyPost\Address
     * @throws \App\Shipping\ShippingException
     */
    public function fromAddress()
    {
        //address
        $fromAddress = [
            'company' => config('snb.name'),
            'street1' => config('snb.street'),
            'street2' => config('snb.street2'),
            'city'    => config('snb.city'),
            'state'   => config('snb.state'),
            'zip'     => config('snb.zip'),
            'phone'   => config('snb.phone'),
            'email'   => config('snb.orderEmail'),
        ];

        //try to create address object
        try {
            $address = Address::create($fromAddress);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Easypost exception creating from address.', 0, $e);
        }

        //return address object
        return $address;
    }

    /**
     * parcel
     *
     * weight needs to be in ounces (oz)
     * length, width, and height need to be inches (in)
     *
     * @param float $weight
     * @return \EasyPost\Parcel
     * @throws \App\Shipping\ShippingException
     */
    public function parcel($weight)
    {
        //try to create parcel
        try {
            $parcel = Parcel::create([
                'predefined_package' => null,
                'weight'             => round($weight, 1),
                'length'             => null,
                'width'              => null,
                'height'             => null,
            ]);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Unable to create Easypost parcel.', 0, $e);
        }

        //return parcel object
        return $parcel;
    }

    /**
     * purchase shipment
     *
     * @param string $shipmentId
     * @param string $rateId
     * @return null
     * @throws \App\Shipping\ShippingException
     */
    public function purchase($shipmentId, $rateId)
    {
        //try to buy label
        try {

            //retrieve shipment
            $shipment = Shipment::retrieve($shipmentId);

            //retrieve rate
            $rate = Rate::retrieve($rateId);

            //buy
            $purchase = $shipment->buy($rate);
        }

            //easypost exception
        catch (EasypostException $e) {

            //throw shipping exception
            throw new ShippingException('Problem purchasing label.' . $e->getMessage(), 0, $e);
        }

        //return
        return $purchase;
    }

    /**
     * get label for shipment
     *
     * @param string $shipmentId
     * @return string
     * @throws \App\Shipping\ShippingException
     */
    public function label($shipmentId)
    {
        //try to retrieve the label
        try {

            //retrieve shipment
            $shipment = Shipment::retrieve($shipmentId);

            //retrieve label
            $label = $shipment->label(['file_format' => 'zpl']);

            return $label->postage_label->label_url;
        }

            //easypost exception
        catch (EasyPostException $e) {

            //throw shipping exception
            throw new ShippingException('Problem retrieving label.', 0, $e);
        }
    }

    /**
     * track a shipment
     *
     * @param string $trackingId
     * @return \EasyPost\Tracker
     * @throws \App\Shipping\ShippingException
     */
    public function track($trackingId)
    {
        //try
        try {

            //retrieve tracker
            return $tracker = Tracker::retrieve($trackingId);
        }

            //easypost exception
        catch (EasyPostException $e) {

            //throw shipping exception
            throw new ShippingException('Problem tracking shipment.', 0, $e);
        }
    }

}
