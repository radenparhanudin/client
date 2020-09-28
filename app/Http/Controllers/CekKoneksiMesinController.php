<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TADPHP\TADFactory;
use TADPHP\TAD;


class CekKoneksiMesinController extends Controller
{
    public function index()
    {
    	return view('page.cek-koneksi.index');
    }

    public function store(Request $request)
    {
    	if ($request->ajax()) {
    		try {
                $tad_factory = new TADFactory(['ip'=>$request->get('ip')]);
				$tad = $tad_factory->get_instance();
				$data = array(
                    'platform'         => $tad->get_platform()->to_array()['Row']['Information'], 
                    'serial_number'    => $tad->get_serial_number()->to_array()['Row']['Information'], 
                    'oem_vendor'       => $tad->get_oem_vendor()->to_array()['Row']['Information'], 
                    'mac_address'      => $tad->get_mac_address()->to_array()['Row']['Information'], 
                    'device_name'      => $tad->get_device_name()->to_array()['Row']['Information'], 
                    'manufacture_time' => $tad->get_manufacture_time()->to_array()['Row']['Information'], 
                    'firmware_version' => $tad->get_firmware_version()->to_array()['Row']['Information']
				);

				return response()->json([
					'success' => true, 
					'message' => 'Permintaan informasi mesin berhasil', 
					'data'    => $data, 
				]);
    			
    		} catch (\Exception $e) {
    			return response()->json($e->getMessage(), 422);
    		}
    	}
    	else{
    	    return abort(404);
    	}
    }
}
