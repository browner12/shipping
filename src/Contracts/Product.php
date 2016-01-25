<?php namespace browner12\shipping\Contracts;

interface Product
{
    /**
     * get a description of the product
     *
     * @return string
     */
    public function getDescription();

    /**
     * get tariff number
     *
     * @return string
     */
    public function getTariffNumber();

    /**
     * get origin country
     *
     * @return string
     */
    public function getOriginCountry();
}
