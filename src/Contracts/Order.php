<?php namespace browner12\shipping\Contracts;

interface Order
{
    /**
     * get the value of the order
     *
     * @return int
     */
    public function getValue();

    /**
     * get the order lines
     *
     * @return array
     */
    public function getOrderLines();
}
