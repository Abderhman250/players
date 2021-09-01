<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Language
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
     
        if(isset($request->lang)){
            
            if($request->lang =="ar"){
                app()->setlocale('ar');
            }elseif('en'){
                app()->setlocale('en');
            }else{
                app()->setlocale('fr');

                
            }
        }  
        return $next($request);
    }
}
