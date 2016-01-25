<?php namespace browner12\shipping\Contracts;

interface OrderLine
{
    /**
     * get the value of this order line
     *
     * @return int
     */
    public function getValue();

    /**
     * get the quantity of this order line
     *
     * @return int
     */
    public function getQuantity();

    /**
     * get the weight of the order line
     *
     * @return float
     */
    public function getWeight();

    /**
     * get the product
     *
     * @return \browner12\shipping\Contracts\Product
     */
    public function getProduct();
}
