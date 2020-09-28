<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadLogAbsensiController extends Controller
{
    public function index()
    {
    	return view('page.upload-log-user.index');
    }

    public function store(Request $request)
    {
    	if ($request->ajax()) {
    		try {
	    		$tad_factory = new TADFactory(['ip'=> $request->get('ip')]);
				$user_info = $tad->get_user_info(['pin'=>1000])->to_array()['Row'];
				$get_att_log = $tad->get_att_log(['pin'=>1000])->to_array()['Row'];
				return $get_att_log;
				$data = array(
					'get_all_user_info' => $tad->get_all_user_info()->to_array()['Row'], 
					'get_att_log'       => $tad->get_att_log()->to_array()['Row'], 
				);

				return response()->json([
					'success' => true, 
					'message' => 'Upload log user berhasil', 
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
