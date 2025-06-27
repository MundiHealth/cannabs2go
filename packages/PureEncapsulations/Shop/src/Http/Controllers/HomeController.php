<?php


namespace PureEncapsulations\Shop\Http\Controllers;


class HomeController extends \Webkul\Shop\Http\Controllers\HomeController
{

    /**
     * @var array|\Illuminate\Foundation\Application|\Illuminate\Http\Request|string
     */
    protected $_config;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * loads the home page for the storefront
     */
    public function notFound()
    {
        return view($this->_config['view']);
    }

    public function faq()
    {
        return view($this->_config['view']);
    }

    public function quality()
    {
        return view($this->_config['view']);
    }

    public function ciencia()
    {
        return view($this->_config['view']);
    }

    public function razoes()
    {
        return view($this->_config['view']);
    }

    public function funciona()
    {
        return view($this->_config['view']);
    }

    public function videos()
    {
        return view($this->_config['view']);
    }

    public function teste_microbioma()
    {
        return view($this->_config['view']);
    }

    public function educacao()
    {
        return view($this->_config['view']);
    }

    public function cbd()
    {
        return view($this->_config['view']);
    }

    public function contatos()
    {
        return view($this->_config['view']);
    }

    public function cannabis_educacao()
    {
        return view($this->_config['view']);
    }

    public function cannabis_code()
    {
        return view($this->_config['view']);
    }

    public function cannabis_faq()
    {
        return view($this->_config['view']);
    }

    public function pendulum_akkermansia()
    {
        return view($this->_config['view']);
    }

    public function pendulum_glucose()
    {
        return view($this->_config['view']);
    }

    public function pendulum_gi()
    {
        return view($this->_config['view']);
    }

    public function diagnostico_dao()
    {
        return view($this->_config['view']);
    }

    public function what_dao()
    {
        return view($this->_config['view']);
    }

    public function neuroaid()
    {
        return view($this->_config['view']);
    }

    public function testes_geneticos()
    {
        return view($this->_config['view']);
    }

    public function lojas()
    {
        return view($this->_config['view']);
    }

    public function promocao()
    {
        return view($this->_config['view']);
    }

    public function procare()
    {
        return view($this->_config['view']);
    }

    public function procare_pesquisa()
    {
        return view($this->_config['view']);
    }

    public function procare_cervix()
    {
        return view($this->_config['view']);
    }

    public function truniagen()
    {
        return view($this->_config['view']);
    }

    public function azo_complete()
    {
        return view($this->_config['view']);
    }

    public function azo_dual()
    {
        return view($this->_config['view']);
    }

    public function azo_utd()
    {
        return view($this->_config['view']);
    }

    public function azo_bladder()
    {
        return view($this->_config['view']);
    }

    public function peels()
    {
        return view($this->_config['view']);
    }

    public function sparkia_neuronutricao()
    {
        return view($this->_config['view']);
    }

    public function sparkia_mulher()
    {
        return view($this->_config['view']);
    }

    public function calocurb_science()
    {
        return view($this->_config['view']);
    }
    public function calocurb_taking()
    {
        return view($this->_config['view']);
    }
    public function calocurb_why()
    {
        return view($this->_config['view']);
    }
}