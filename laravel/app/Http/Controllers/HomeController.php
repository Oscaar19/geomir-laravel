<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $message = 'Loading home page';
        $request->session()->flash('info', $message);
        return view('home');
    }

    public function language($locale)
    { 
        $default = config('app.locale', 'en');
        $locales = config('app.available_locales', ['en' => 'English']);
        
        if (!array_key_exists($locale, $locales)) {
            Log::error("Locale '{$locale}' not exists");
            abort(400);
        }

        // Session storage
        $current = Session::get('locale', $default);
        Log::debug("Change locale '{$current}' to '{$locale}'");
        Session::put('locale', $locale);
        
        // Set locale
        App::setLocale($locale);

        // Go to homepage
        return redirect()->route('home');
    }

}
