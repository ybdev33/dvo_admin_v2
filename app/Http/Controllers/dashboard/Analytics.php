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
    $return['code'] = $return['data'] = $top20['data'] = [];

    $drawcategory = session()->get('drawcategory');
    // echo "<pre>";
    // print_r($drawcategory);
    // echo "</pre>";
    // die('ee');
    $options['json'] = [
      'userId' => (string) $user->userId,
      'position' => (string) $user->position,
      'date' => (isset($options['date'])) ? $options['date'] : date('Y-m-d'),
      'drawCategory' => (isset($options['draw'])) ? $options['draw'] : (string) $drawcategory->draws[0]->draws,
      // 'drawCategory' => (isset($options['draw'])) ? $options['draw'] : "9S3",
    ];

    /* USER 1095 */
    $user = session()->get('user');
    $date = $options['json']['date'];
    if( $user->userId >= 1095 )
    {
        $date = ( $date < '2023-04-25' ) ? '2022-01-01': $date;
    }
    $options['json']['date'] = $date;
    /* USER 1095 */

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

    unset($options['json']['position']);
    $optionsBets = $options;
    $return1 = AuthService::send('POST', '/api/Admin/GetTopBets', $optionsBets);
    if ($return1 && $return1->getStatusCode() == 200)
      $top20['data'] = json_decode($return1->getBody()->getContents());

    // $top20['data'] = 
    //     [
    //       (object)
    //       [
    //           "betCount" => rand(1, 20),
    //           "winCombination" => rand(1, 9999),
    //           "amount" => rand(1, 9999)
    //       ],
    //     ];
    // echo "<pre>";
    // print_r($top20['data']);
    // echo "</pre>";

    // die();
    if( $request->all() )
      return view('content.dashboard.dashboards-load', ['user' => $user, 'data' => (object) $return['data'], 'top20' => $top20['data']]);
    else
      return view('content.dashboard.dashboards-analytics', ['user' => $user, 'data' => (object) $return['data'], 'top20' => $top20['data']]);
  }

  public function hits()
  {
    return view('content.hits');
  }

  public function cancelBets()
  {
    return view('content.modules.cancel-bets');
  }

  public function loadTop20(Request $request, $id = '')
  {
    $user = session()->get('user');
    $options = $request->all();
    $top20['data'] = [];

    $optionsBets['json'] = [
      'userId' => (string) $user->userId,
      'position' => (string) $user->position,
      'date' => (isset($options['date'])) ? $options['date'] : date('Y-m-d'),
      'drawCategory' => (string) $options['draw'],
    ];    

    /* USER 1095 */
    $user = session()->get('user');
    $date = $optionsBets['json']['date'];
    if( $user->userId >= 1095 )
    {
        $date = ( $date < '2023-04-25' ) ? '2022-01-01': $date;
    }
    $optionsBets['json']['date'] = $date;
    /* USER 1095 */
    
    // echo "<pre>";
    // print_r($optionsBets);
    // echo "</pre>";
    // die('ee');

    $return1 = AuthService::send('POST', '/api/Admin/GetTopBets', $optionsBets);
    if ($return1 && $return1->getStatusCode() == 200)
      $top20['data'] = json_decode($return1->getBody()->getContents());

    // $top20['data'] = 
    //     [
    //       (object)
    //       [
    //           "betCount" => rand(1, 20),
    //           "winCombination" => rand(1, 9999),
    //           "amount" => rand(1, 9999)
    //       ],
    //     ];

    // echo "<pre>";
    // print_r($top20['data']);
    // echo "</pre>";

    // die();
    return view('content.dashboard.dashboards-loadTop20', ['top20' => $top20['data']]);
  }
}
