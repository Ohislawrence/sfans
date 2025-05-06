<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Services\VisitorService;

class AgeVerificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
    
        return $next($request);
    }
}