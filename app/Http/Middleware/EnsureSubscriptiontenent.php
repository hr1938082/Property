<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendent;
use App\Models\usersubscription;

class EnsureSubscriptiontenent
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
        if(Auth::user()->user_type_id ==2)
        {
            $select = Tendent::select('properties.user_id')
            ->join('properties','tendent_to_property.property_id','properties.id')
            ->where([
                ['tendent_id',Auth::user()->id],
                ['is_live',1]
            ])
            ->first();
            if($select)
            {
                $check_subs = usersubscription::where([
                    ['user_id',$select->user_id],
                    ['status',1]
                ])
                ->first();
                if(!$check_subs)
                {
                    return response()->json([
                        "status" => false,
                        "message" => "Unauthenticated Contact to your landlord"
                    ]);
                }
            }
        }
        return $next($request);
    }
}
