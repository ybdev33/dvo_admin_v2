<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($params, $additional = [])
    {
        $code = $params['code'] ?? 404;
    	$response['success'] = !isset($params['success']) ? false : (bool) $params['success']; // set default false
        if( $code == 200 )
    	    $response['success'] = true; // set true if 200
        $response['data']= $params['data'] ?? [];

        // add message if exist and success false
        if( !$response['success'] && isset($params['message']) )
            $response['message']= $params['message'];

        //additional response
        $response = array_merge($response, $additional);

        return response()->json($response, $code);
    }
}
