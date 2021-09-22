<?php

namespace App\Http\Middleware;

use App\Models\Tendent;
use App\Models\usersubscription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSubscriptionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->user_type_id == 1)
        {    
            $select = usersubscription::where([
                ['user_id',Auth::user()->id],
                ['status',1]
            ])
            ->first();
            if(!$select)
            {
                return response()->json([
                    "status" => false,
                    "message" => "not subscribed"
                ]);
            }
        }
        return $next($request);
    }
}
