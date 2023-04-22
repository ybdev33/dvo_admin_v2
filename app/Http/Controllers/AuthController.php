<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\{
    App\Services\AuthService,
};
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;

use Validator,Redirect,Response;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use PDF;
 

class AuthController extends ApiBaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $response = ['online' => true];
        return Response::json(['success' => true, 'data' => $response]);
    }
     
    public function getStatus(Request $request)
    {
        $options['json'] = $request->all();

        $validator = Validator::make($options['json'], [
            'username' => 'required',
            'password' => 'required'
        ]);
  
        if ($validator->fails()) {
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        } else {
            $response = AuthService::send('POST', '/api/AppUsers/GetUsers', $options);

            if ($response->getStatusCode() == 200)
            {
                $return['code'] = $response->getStatusCode();
                $return['data'] = json_decode($response->getBody()->getContents());
                $additional['redirect'] = url('/');

                // echo "<pre>";
                // print_r($return['data']);
                // echo "</pre>";
                // die();

                // status not Authorized if position == teller
                if( $return['data']->position === 'Teller' )
                    return response()->json([
                        "status" => false,
                        "errors" => ["Account not authorized."]
                    ]);

                if( $return['data']->accountStatus )
                {
                    // save GetDrawCategory upon login
                    $response = AuthService::send('GET', '/api/Admin/GetDrawCategory');
                    $drawcategory = [];
                    $drawcategory = json_decode($response->getBody()->getContents());
                    if($drawcategory)
                        $request->session()->put('drawcategory', $drawcategory);

                    $request->session()->put('user', $return['data']);
    
                    return $this->sendResponse($return, $additional);
                }
                else
                    return response()->json([
                        "status" => false,
                        "errors" => ["Account deactivated. Please ask admin to activate your account."]
                    ]);
            } 
            else 
            {
                return response()->json([
                    "status" => false,
                    "errors" => ["Invalid credentials"]
                ]);
            }
        }
    }

    public function logout()
    {
        if( session()->has('user') ) {
            session()->pull('user');
            // session()->forget('user');
            // session()->flush();
        }
        
        return redirect('login');
    }

    public function GetDrawCategory()
    {
        $response = AuthService::send('GET', '/api/Admin/GetDrawCategory');

        $return['code'] = $response->getStatusCode();
        $return['data'] = json_decode($response->getBody()->getContents());

        return $this->sendResponse($return);
    }

    public function getReportPerDraw(Request $request)
    {
        $options['json'] = $request->all();
        $print = $options['json']['print'] ?? false;

        if( $options['json']['reportType'] == 'drawMunicipality' )
        {
            $response = AuthService::send('POST', '/api/Report/GetReportPerDraw', $options);

            if (!$response)
                return $this->sendResponse(['success' => false]);

            $return['code'] = $response->getStatusCode();
            $datas = json_decode($response->getBody()->getContents());

            $collection = collect($datas);
            $grouped = $collection->groupBy(['userdashId', 'drawCategory', 'area']);
            $grouped->toArray();
            $return['data'] = $grouped;

            $preview_pdf = 'content.reports.draw-pdf';
        }
        else if( $options['json']['reportType'] == 'tallySheet' ) 
        {
            $response = AuthService::send('POST', '/api/Report/GetReportTallySheet', $options);

            if (!$response)
            return $this->sendResponse(['success' => false]);

            $return['code'] = $response->getStatusCode();
            $datas = json_decode($response->getBody()->getContents());

            $collection = collect($datas);
            $grouped = [];
            $return['data'] = $collection;

            $preview_pdf = 'content.reports.tally-sheet-pdf';
        }

        // echo "<pre>";
        // print_r($return['data']);
        // echo "</pre>";
        // die();

        // view html
        if( empty($datas) )
            return '';
        else
        {
            if( $print == "true" )
            {
                $date = date('Y-m-d');
                $pdf = PDF::loadView($preview_pdf, [
                    'datas' => $datas,
                    'grouped' => $grouped,
                    'options' => $options,
                    'datas_count' => count((array) $datas)
                ]);
                $pdf->setPaper('A4','portrait');
                return $pdf->download("draw_". $options['json']['drawcategory'] ."_$date.pdf");
            }

            return view($preview_pdf, [
                'datas' => $datas,
                'grouped' => $grouped,
                'options' => $options,
                'datas_count' => count((array) $datas)
            ]);
        }

        // return $this->sendResponse($return);
    }
     
    public function getDashboardPerUser(Request $request)
    {
        $options['json'] = $request->all();

        // echo "<pre>";
        // print_r($options);
        // echo "</pre>";
        // die();
        $response = AuthService::send('POST', '/api/Admin/GetDashboardPerUser', $options);

        if ($response->getStatusCode() == 200)
        {
            $return['code'] = $response->getStatusCode();
            $return['data'] = json_decode($response->getBody()->getContents());

            // echo "<pre>";
            // print_r($return['data']);
            // echo "</pre>";
        
            // die();
        
            return view('content.dashboard.dashboards-peruser', ['options' => $options, 'datas' => $return['data']]);
        } 
        else 
        {
            return response()->json([
                "status" => false,
                "errors" => ["Invalid credentials"]
            ]);
        }

        // return $this->sendResponse($return);
    }
     
    public function activateUser(Request $request)
    {
        $options['json'] = $request->all();

        // echo "<pre>";
        // print_r($options);
        // echo "</pre>";
        // die();
        $response = AuthService::send('POST', '/api/Admin/ActivateUser', $options);

        if ($response->getStatusCode() == 200)
        {
            $return['code'] = $response->getStatusCode();
            $return['data'] = json_decode($response->getBody()->getContents());

            // echo "<pre>";
            // print_r($return['data']);
            // echo "</pre>";
        
            // die();

            return $this->sendResponse($return);
        } 
        else 
        {
            return response()->json([
                "status" => false,
                "errors" => ["Invalid credentials"]
            ]);
        }
    }
}
