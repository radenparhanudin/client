<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TADPHP\TADFactory;
use TADPHP\TAD;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class RegisterMesinController extends Controller
{
    public $base_url = "";

    function __construct()
    {
    	$this->base_url = config('app.api_url');
    }

    public function index()
    {
    	return view('page.register-mesin.index');
    }

    public function store(Request $request)
    {
    	if ($request->ajax()) {

            try {
                $tad_factory = new TADFactory(['ip'=> $request->get('ip')]);
                $tad         = $tad_factory->get_instance();
                $dataBody    = array(
                    'ip'               => $request->get('ip'), 
                    'nama'             => $request->get('nama'), 
                    'platform'         => $tad->get_platform()->to_array()['Row']['Information'], 
                    'serial_number'    => $tad->get_serial_number()->to_array()['Row']['Information'], 
                    'oem_vendor'       => $tad->get_oem_vendor()->to_array()['Row']['Information'], 
                    'mac_address'      => $tad->get_mac_address()->to_array()['Row']['Information'], 
                    'device_name'      => $tad->get_device_name()->to_array()['Row']['Information'], 
                    'manufacture_time' => $tad->get_manufacture_time()->to_array()['Row']['Information'], 
                    'firmware_version' => $tad->get_firmware_version()->to_array()['Row']['Information']
                );
            } catch (\Exception $e) {
                return response()->json([
                    'errors' => true, 
                    'message' => 'Tidak dapat memulai koneksi dengan perangkat ' .$request->get('ip'), 
                ], 422);
            }

            $client = new Client();
            try {
                $response = $client->post($this->base_url . 'mdl/mesin/register', [
                    'headers' => [
                        'Content-Type'  => 'application/x-www-form-urlencoded',
                        'Accept'        => 'application/json', 
                        'Authorization' => 'Bearer ' . session()->get('token'), 
                    ],
                    'body' => $dataBody
                ]);
                $body    = $response->getBody();
                $content = json_decode($body, true);

                if ($content['success']) {
                    return response()->json([
                        'success' => true, 
                        'message' => $content['message'], 
                    ]);
                }

                if ($content['errors']) {
                    return response()->json([
                        'errors' => true, 
                        'message' => $content['message'], 
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'errors' => true, 
                    'message' => $e->getMessage(), 
                ], 422);
            }
    	}
    	else{
    	    return abort(404);
    	}
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
             $client = new Client();
            try {
                $response = $client->post($this->base_url . 'mdl/mesin/register/data', [
                    'headers' => [
                        'Content-Type'  => 'application/x-www-form-urlencoded',
                        'Accept'        => 'application/json', 
                        'Authorization' => 'Bearer ' . session()->get('token'), 
                    ],
                ]);
                $body    = $response->getBody();
                $content = json_decode($body, true);

                return response()->json($content);
            } catch (\Exception $e) {
                return response()->json([
                    'errors' => true, 
                    'message' => $e->getMessage(), 
                ], 422);
            }
        }
        else{
            return abort(404);
        }
    }
}
