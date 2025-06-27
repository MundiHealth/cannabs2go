<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockIpAddressMiddleware
{

    public $blockListIps = [];

    public function handle(Request $request, Closure $next)
    {
        if (in_array(request()->ip(), $this->blockListIps)) {
            abort(403, 'Acesso bloqueado!!!');
        }

        foreach ($this->blockListIps as $ip) {
            if (strpos(request()->ip(), $ip) === 0) {
                abort(403, 'Acesso bloqueado!!!');
            }
        }

        return $next($request);
    }

    private function rangeIps()
    {

    }
}