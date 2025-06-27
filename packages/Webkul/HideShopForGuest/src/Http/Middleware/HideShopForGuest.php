<?php

namespace Webkul\HideShopForGuest\Http\Middleware;

use Closure;

class HideShopForGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $moduleEnabled = core()->getConfigData('hideshopforguest.settings.settings.hide-shop-before-login');

        $notification = core()->getConfigData('hideshopforguest.settings.settings.hide-shop-before-login.notification');

        $group = core()->getConfigData('hideshopforguest.settings.settings.hide-shop-before-login.group');

        if ($moduleEnabled) {
            if (! auth()->guard('customer')->check() && ! request()->is('customer/*') && ! request()->is('admin/*')) {
                return $this->notify($notification);
            } else {
                if ($group){
                    if ($customer = auth()->guard('customer')->user()) {
                        if ($customer->customer_group_id != $group) {
                            auth()->guard('customer')->logout();
                            return $this->notify($notification);
                        }
                    }
                }
            }
        }

        return $next($request);
    }

    private function notify($notification)
    {
        if (isset($notification)) {
            session()->flash('warning', $notification);
        }

        return redirect()->route('customer.session.index');
    }
}