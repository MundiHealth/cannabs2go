<?php


namespace Store\Microbiome\Http\Controllers;


class HomeController extends \Webkul\Shop\Http\Controllers\HomeController
{

    /**
     * loads the home page for the storefront
     */
    public function notFound()
    {
        return view($this->_config['view']);
    }

}