<?php namespace browner12\shipping;

use browner12\shipping\Contracts\Order;
use browner12\shipping\Contracts\OrderLine;
use EasyPost\Address;
use EasyPost\CustomsInfo;
use EasyPost\CustomsItem;
use EasyPost\EasyPost;
use EasyPost\Error as EasyPostException;
use EasyPost\Parcel;
use EasyPost\Rate;
use EasyPost\Shipment;
use EasyPost\Tracker;

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
     * @param mixed $to
     * @param mixed $from
     * @param mixed $parcel
     * @param mixed $customs
     * @return \EasyPost\Shipment
     * @throws \browner12\shipping\ShippingException
     */
    public function shipment($to, $from, $parcel, $customs)
    {
        //shipment
        try {
            $shipment = Shipment::create([
                'to_address'   => $to,
                'from_address' => $from,
                'parcel'       => $parcel,
                'customs'      => $customs,
            ]);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Unable to create shipment.', 0, $e);
        }

        //return
        return $shipment;
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
     * @return \EasyPost\Address
     * @throws \browner12\shipping\ShippingException
     */
    public function address($name, $street, $street2, $city, $state, $zip, $country)
    {
        //create address object
        try {
            $address = Address::create([
                'name'    => $name,
                'street'  => $street,
                'street2' => $street2,
                'city'    => $city,
                'state'   => $state,
                'zip'     => $zip,
                'country' => $country,
            ]);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Unable to create address.', 0, $e);
        }

        //return address object
        return $address;
    }

    /**
     * create a parcel
     *
     * weight needs to be in ounces (oz)
     * length, width, and height need to be inches (in)
     *
     * @param float $weight
     * @param float $length
     * @param float $width
     * @param float $height
     * @return \EasyPost\Parcel
     * @throws \browner12\shipping\ShippingException
     */
    public function parcel($weight, $length, $width, $height)
    {
        //try to create parcel
        try {
            $parcel = Parcel::create([
                'predefined_package' => null,
                'weight'             => round($weight, 1),
                'length'             => round($length, 1),
                'width'              => round($width, 1),
                'height'             => round($height, 1),
            ]);
        }

            //easypost exception
        catch (EasyPostException $e) {
            throw new ShippingException('Unable to create parcel.', 0, $e);
        }

        //return parcel object
        return $parcel;
    }

    /**
     * create a customs info
     *
     * @param \browner12\shipping\Contracts\Order $order
     * @return mixed
     */
    public function customsInfo(Order $order)
    {
        //initialize customs items
        $customsItems = [];

        //loop through order lines
        foreach ($order->getOrderLines() as $orderLine) {
            $customsItems[] = $this->customsItem($orderLine);
        }

        //create and return customs info
        return CustomsInfo::create([
            'eel_pfc'         => 'NOEEI 30.37(a)',
            'customs_certify' => true,
            'customs_signer'  => config('SHIPPING_CUSTOMS_SIGNER'),
            'contents_type'   => 'gift',
            'customs_items'   => $customsItems,
        ]);
    }

    /**
     * create a customs item
     *
     * @param \browner12\shipping\Contracts\OrderLine $orderLine
     * @return mixed
     */
    public function customsItem(OrderLine $orderLine)
    {
        return CustomsItem::create([
            'description'      => $orderLine->getProduct()->getDescription(),
            'quantity'         => $orderLine->getQuantity(),
            'weight'           => $orderLine->getWeight(),
            'value'            => $orderLine->getValue(),
            'hs_tariff_number' => $orderLine->getProduct()->getTariffNumber(),
            'origin_country'   => $orderLine->getProduct()->getOriginCountry(),
        ]);
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
        //value is over 2500 USD so we need a Internal Transaction Number
        if ($order->getValue() > 250000) {
            return config('SHIPPING_INTERNAL_TRANSACTION_NUMBER');
        }

        //value is less than 2500 USD
        return 'NOEEI 30.37(a)';
    }

    /**
     * purchase a shipment
     *
     * @param string $shipmentId
     * @param string $rateId
     * @return null
     * @throws \browner12\shipping\ShippingException
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
            throw new ShippingException('Unable to purchase label.' . $e->getMessage(), 0, $e);
        }

        //return
        return $purchase;
    }

    /**
     * get label for shipment
     *
     * @param string $shipmentId
     * @return string
     * @throws \browner12\shipping\ShippingException
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
            throw new ShippingException('Unable to retrieve label.', 0, $e);
        }
    }

    /**
     * track a shipment
     *
     * @param string $trackingId
     * @return \EasyPost\Tracker
     * @throws \browner12\shipping\ShippingException
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
            throw new ShippingException('Unable to track shipment.', 0, $e);
        }
    }

}
