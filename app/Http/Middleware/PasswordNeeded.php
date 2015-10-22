<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class PasswordNeeded
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!is_null($request->input('password'))) 
        {
            if ($request->ajax()) 
            {
                return response('Unauthorized.', 401);
            } 
            else 
            {
                $check                      = Auth::attempt(['email' => Auth::user()->email, 'password' => $request->input('password')]);

                if ($check)
                {
                    return $next($request);
                }
        
                return redirect()->back()->withErrors('Password tidak valid')->with('msg-type', 'danger');
            }
        }
        else
        {
            return redirect()->back()->withErrors('Harus mengisi password')->with('msg-type', 'danger');
        }

    }
}
