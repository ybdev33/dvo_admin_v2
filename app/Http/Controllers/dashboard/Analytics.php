<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\{
    App\Services\AuthService,
};

class Analytics extends Controller
{
  public function index(Request $request)
  {
    $user = session()->get('user');
    $options = $request->all();
    $return['code'] = $return['data'] = [];

    $options['json'] = [
      'userId' => (string) $user->userId,
      'position' => (string) $user->position,
      'date' => (isset($options['date'])) ? $options['date'] : date('Y-m-d'),
    ];

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die('ee');
    
    $response = AuthService::send('POST', '/api/Admin/GetDashboard', $options);

    if( $response && $response->getStatusCode() == 200 ) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      if( isset($return['data']->dashboardDetail) )
        $return['data']->dashboardDetail = $return['data']->dashboardDetail[0];
    }

    // echo "<pre>";
    // print_r($return['data']);
    // echo "</pre>";

    // die();
    if( $request->all() )
      return view('content.dashboard.dashboards-load', ['user' => $user, 'data' => (object) $return['data']]);
    else
      return view('content.dashboard.dashboards-analytics', ['user' => $user, 'data' => (object) $return['data']]);
  }

  public function hits()
  {
    return view('content.hits');
  }

  public function cancelBets()
  {
    return view('content.modules.cancel-bets');
  }
}
