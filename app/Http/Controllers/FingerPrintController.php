<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TADPHP\TADFactory;
use TADPHP\TAD;

class FingerPrintController extends Controller
{
    public function index()
    {
    	$tad_factory = new TADFactory(['ip'=>'192.168.0.101']);
		$tad = $tad_factory->get_instance();
		$dt = $tad->get_date();
		$all_user_info = $tad->get_all_user_info();
		return $all_user_info->to_array();
    }
}

// get_date,
// get_att_log,
// get_user_info,
// get_all_user_info,
// get_user_template,
// get_combination,
// get_option,
// get_free_sizes,
// get_platform,
// get_fingerprint_algorithm,
// get_serial_number,
// get_oem_vendor,
// get_mac_address,
// get_device_name,
// get_manufacture_time,
// get_antipassback_mode,
// get_workcode,
// get_ext_format_mode,
// get_encrypted_mode,
// get_pin2_width,
// get_ssr_mode,
// get_firmware_version,
// set_date,
// set_user_info,
// set_user_template,
// delete_user,
// delete_template,
// delete_data,
// delete_user_password,
// delete_admin,
// enable,
// disable,
// refresh_db,
// restart,
// and poweroff.

