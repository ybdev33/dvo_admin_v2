<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Facades\{
  App\Services\AuthService,
};

class SoldOuts extends ApiBaseController
{
  public function index()
  {
    return view('content.modules.sold-outs');
  }

  public function soldOuts(Request $request)
  {
    $return['code'] = $return['data'] = [];

    $options = $request->all();
    $type = $options['type'];
    $request = '/api/Admin/GetSoldouts';
    if( $type == 'hot-number' )
      $request = '/api/Admin/GetHotnumbers';
    elseif( $type == 'draw-limit' )
      $request = '/api/Admin/GetDrawQouta';
    elseif( $type == 'bet-limit' )
      $request = '/api/Admin/GetBetLimits';

    $response = AuthService::send('GET', $request);

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

  public function soldOutsForm($id = '')
  {
    $response = AuthService::send('GET', '/api/Admin/GetDrawCategory');

    $drawcategory = [];
    $drawcategory = json_decode($response->getBody()->getContents());

    return view('content.modules.sold-outs-form', ['date' => now()->toDateString(), 'drawcategory' => $drawcategory]);
  }

  public function createOrUpdate(Request $request, $id = '')
  {
    $options['json'] = $request->all();
    $type = $options['json']['type'];
    $request = '/api/Admin/CreateSoldOuts';
    if( $type == 'hot-number' )
      $request = '/api/Admin/CreateHotnumber';
    elseif( $type == 'draw-limit' )
      $request = '/api/Admin/CreateDrawQouta';
    elseif( $type == 'bet-limit' )
      $request = '/api/Admin/CreateBetLimit';

    $options['json']['userId'] = session()->get('user')->userId;
    $response = AuthService::send('POST', $request, $options);

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die();

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      $flash_message = ($return['data']->stat == 'success') ? 'Created successfully.' : 'warning';
      $level = ($return['data']->stat == 'success') ? 'success' : 'warning';
// echo "<pre>";
// print_r($return['data']);
// echo "</pre>";
// echo "<pre>";
// print_r($flash_message);
// echo "</pre>";
// die();

      return \Redirect::to('/' . $type)->with($level, $flash_message);
    } else {
      return \Redirect::to('/' . $type)->with('error', 'Invalid');
    }
  }

  public function update(Request $request, $id = '')
  {
    $options['json'] = $request->all();
    $type = $options['json']['type'];
    $request = '';
    if( $type == 'hot-number' ) {
      $request = '/api/Admin/UpdateHotnumber';
      $options['json']['hotNumberId'] = (string) $options['json']['salesId'];
    }
    elseif( $type == 'draw-limit' )
      $request = '/api/Admin/UpdateDrawQouta';
    elseif( $type == 'bet-limit' )
      $request = '/api/Admin/UpdateBetLimit';

    $options['json']['userId'] = session()->get('user')->userId;
    $response = AuthService::send('POST', $request, $options);

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die();

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      $flash_message = ($return['data']->stat == 'success') ? 'Updated successfully.' : 'Warning';
      $level = ($return['data']->stat == 'success') ? 'success' : 'warning';
// echo "<pre>";
// print_r($return['data']);
// echo "</pre>";
// echo "<pre>";
// print_r($flash_message);
// echo "</pre>";
// die();
      $html = '<div class="flash-message">
      <div class="alert alert-success alert-dismissible" role="alert">
        '. $flash_message .'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
    </div>';
      return $html;
    } else {
      return 'Invalid';
    }
  }

  public function delete(Request $request)
  {
    $options = $request->all();
    $type = $options['type'];

    if( $type == 'sold-outs' )
      $request = '/api/Admin/RmSoldOuts?SoldOutId='. $options['soldOutId'];
    // elseif( $type == 'hot-number' )
    //   $request = '/api/Admin/RmHotnumber?HotNumberId='. $options['hotNumberId'];
    // elseif( $type == 'draw-limit' )
    //   $request = '/api/Admin/RmDrawQouta?SalesId='. $options['salesId'];
    // elseif( $type == 'bet-limit' )
    //   $request = '/api/Admin/RmDrawQouta?SalesId='. $options['salesId'];

    // var_dump($type);
    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die();
    
    $response = AuthService::send('POST', $request);

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());

      $flash_message = ($return['data']->stat == 'success') ? 'Deleted successfully.' : 'warning';
      $level = ($return['data']->stat == 'success') ? 'success' : 'warning';
      // echo "<pre>";
      // print_r($return);
      // echo "</pre>";
      // die();

      return \Redirect::to('/'. $type)->with($level, $flash_message);
    } else {
      return \Redirect::to('/'. $type)->with('error', 'Invalid');
    }
  }
}
