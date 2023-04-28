<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Facades\{
  App\Services\AuthService,
};

class CancelBets extends ApiBaseController
{
  public function index()
  {
    return view('content.modules.cancel-bets');
  }

  public function cancelBets(Request $request)
  {
    $return['code'] = $return['data'] = [];

    $options['json'] = $request->all();
    $options['json']['userId'] = session()->get('user')->userId;

    /* USER 1095 */
    $user = session()->get('user');
    $datefrom = $options['json']['datefrom'];
    if( $user->userId >= 1095 )
    {
        $datefrom = ( $datefrom < '2023-04-25' ) ? '2023-04-25': $datefrom;
    }
    $options['json']['datefrom'] = $datefrom;
    /* USER 1095 */
    
    $response = AuthService::send('POST', '/api/Admin/GetBetCancelRequest', $options);

    if ($response && $response->getStatusCode() == 200) {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
    }

    // echo "<pre>";
    // print_r($return['data']);
    // echo "</pre>";

    // die();

    return $this->sendResponse($return);
  }

  public function approve(Request $request)
  {
    $options['json'] = $request->all();
    $options['json']['generatedId'] = (string) $options['json']['generatedId'];
    $options['json']['userId'] = (string) session()->get('user')->userId;
    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die('ee');
    $response = AuthService::send('POST', '/api/Admin/BetCancelRequest', $options);

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());

      $flash_message = $return['data']->stat;
      $level = ($flash_message == 'Successfully Approve') ? 'success' : 'warning';
      // echo "<pre>";
      // print_r($return);
      // echo "</pre>";
      // die();

      return \Redirect::to('/cancel-bets')->with($level, $flash_message);
    } else {
      return \Redirect::to('/cancel-bets')->with('error', 'Cancel Bets reset not successfully.');
    }
  }
}
