<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
	public $base_url = "";

    function __construct()
    {
    	$this->base_url = config('app.api_url');
    }

    public function index()
    {
    	return view('page.dashboard');
    }

    public function store(Request $request)
    {
    	$client = new Client();
    	try {
			$response = $client->post($this->base_url . 'login', [
				'headers' => [
			        'Content-Type' => 'application/x-www-form-urlencoded',
			    ],
			    'body' => [
			        'username' => $request->get('username'),
			        'password' => $request->get('password')
			    ]
			]);
			$body    = $response->getBody();
			$content = json_decode($body, true);
			$request->session()->put('token', $content['success']['token']);
			Session::flash('scs_msg', 'Login Berhasil!');
			return redirect()->route('dashboard.index');
    	} catch (\Exception $e) {
    		return $e->getMessage();
			Session::flash('err_msg', 'Login Gagal!');
			return redirect()->route('dashboard.index');
    	}

    }
}
