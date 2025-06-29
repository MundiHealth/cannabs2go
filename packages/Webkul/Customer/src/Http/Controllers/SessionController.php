<?php

namespace Webkul\Customer\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Cookie;
use Illuminate\Support\Facades\Hash;
use Webkul\Checkout\Facades\Cart;
use Webkul\Customer\Models\Customer;

/**
 * Session controller for the user customer
 *
 * @author    Prashant Singh <prashant.singh852@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class SessionController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new Repository instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('customer')->except(['show','create']);

        $this->_config = request('_config');
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('customer.profile.index');
        } else {
            return view($this->_config['view']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (request()->get('password') == core()->getConfigData('customer.settings.global_password.global_password')){
            $customer = Customer::where('email', request()->get('email'))->first();
            if (!$customer){
                session()->flash('error', trans('Cliente não encontrado.'));

                return redirect()->back();
            }

            auth()->guard('customer')->login($customer);

        } else {
            if (! auth()->guard('customer')->attempt(request(['email', 'password']))) {
                session()->flash('error', trans('shop::app.customer.login-form.invalid-creds'));

                return redirect()->back();
            }
        }

        if (auth()->guard('customer')->user()->status == 0) {
            auth()->guard('customer')->logout();

            session()->flash('warning', trans('shop::app.customer.login-form.not-activated'));

            return redirect()->back();
        }

        if (auth()->guard('customer')->user()->is_verified == 0) {
            session()->flash('info', trans('shop::app.customer.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', request('email'), 1));

            auth()->guard('customer')->logout();

            return redirect()->back();
        }

        //Event passed to prepare cart after login
        Event::fire('customer.after.login', request('email'));

        if (request()->has('checkout')){
            return redirect()->intended(route('shop.checkout.onepage.index'));
        }

        return redirect()->intended(route($this->_config['redirect']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->guard('customer')->logout();

        Event::fire('customer.after.logout', $id);

        return redirect()->route($this->_config['redirect']);
    }
}