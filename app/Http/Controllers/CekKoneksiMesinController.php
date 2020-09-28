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
                $options = [
                    'ip' => $request->get('ip'),   // '169.254.0.1' by default (totally useless!!!).
                    // 'internal_id' => 1,    // 1 by default.
                    // 'com_key' => 0,        // 0 by default.
                    // 'description' => 'N/A', // 'N/A' by default.
                    'soap_port' => 80,     // 80 by default,
                    'udp_port' => 5005,      // 4370 by default.
                    // 'encoding' => 'utf-8'    // iso8859-1 by default.
                  ];
              
                 $tad_factory = new TADFactory($options);
                // $tad_factory = new TADFactory(['ip'=>$request->get('ip')]);
				$tad = $tad_factory->get_instance();
                $get_all_user_info = $tad->get_all_user_info()->to_array();
                $get_att_log = $tad->get_att_log();
                $get_date = $tad->get_date();
                return $get_date;
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
