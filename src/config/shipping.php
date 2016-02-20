<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Shipping Service
    |--------------------------------------------------------------------------
    |
    | Select the third party shipping service you will be using.
    |
    | Supported: 'easypost', 'shippo'
    |
    */

    'default' => '',

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Set the API key of your selected shipping service.
    |
    */

    'api_key' => env('YOUR_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | From Address
    |--------------------------------------------------------------------------
    |
    | The address where your orders are shipping from.
    |
    */

    'from_street' => '',
    'from_city'   => '',
    'from_state'  => '',
    'from_zip'    => '',

    /*
    |--------------------------------------------------------------------------
    | Contents Type
    |--------------------------------------------------------------------------
    |
    | The default type of item you are sending.
    |
    | Supported: 'merchandise', 'returned_goods', 'documents', 'gift', 'sample', 'other'
    |
    */

    'contents_type' => 'merchandise',

    /*
    |--------------------------------------------------------------------------
    | Customs Signer
    |--------------------------------------------------------------------------
    |
    | This is the name of the person who is certifying that the information
    | provided on the customs form is accurate. Use a name of the person
    | in your organization who is responsible for this.
    |
    */

    'customs_signer' => '',

    /*
    |--------------------------------------------------------------------------
    | Non Delivery Option
    |--------------------------------------------------------------------------
    |
    | In case the shipment cannot be delivered, this option tells the carrier
    | what you want to happen to the package.  If you pass ‘abandon’, you
    | will not receive the package back if it cannot be delivered.
    |
    | Supported: 'return', 'abandon'
    |
    */

    'non_delivery_option' => 'return',

    /*
    |--------------------------------------------------------------------------
    | Internal Transaction Number
    |--------------------------------------------------------------------------
    |
    | An ITN is required for any international shipment valued over $2,500
    | and/or requires an export license unless exemptions apply. Visit
    | http://aesdirect.census.gov/ to obtain one.
    |
    */

    'internal_transaction_number' => '',

];
