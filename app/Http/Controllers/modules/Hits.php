<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Facades\{
  App\Services\AuthService,
};
use PDF;

class Hits extends ApiBaseController
{
  public function index()
  {
    return view('content.modules.hits');
  }

  public function hits(Request $request)
  {
    $options = $request->all();
    $date = $options['Date'];

    $return['code'] = $return['data'] = [];

    $response = AuthService::send('GET', '/api/Admin/GetGenerateHits?Date='. $date);

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

  public function hitsForm($id = '')
  {
    $response = AuthService::send('GET', '/api/Admin/GetDrawCategory');

    $drawcategory = [];
    $drawcategory = json_decode($response->getBody()->getContents());

    return view('content.modules.hits-form', ['date' => now()->toDateString(), 'drawcategory' => $drawcategory]);
  }

  public function createOrUpdate(Request $request, $id = '')
  {
    $options['json'] = $request->all();

    $options['json']['userId'] = session()->get('user')->userId;
    $response = AuthService::send('POST', '/api/Admin/GenerateHits', $options);

// echo "<pre>";
// print_r($options);
// echo "</pre>";
// die();

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      $flash_message = $return['data']->stat;
      $level = ($flash_message == 'Successfully Generated.') ? 'success' : 'warning';
// echo "<pre>";
// print_r($return['data']);
// echo "</pre>";
// echo "<pre>";
// print_r($flash_message);
// echo "</pre>";
// die();

      return \Redirect::to('/hits')->with($level, $flash_message);
    } else {
      return \Redirect::to('/hits')->with('error', 'Invalid');
    }
  }

  public function reset(Request $request)
  {
    $options = $request->all();
    $date = $options['date'];

    $response = AuthService::send('POST', '/api/Admin/ResetHits?date='. $date);

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());

      $flash_message = $return['data']->stat;
      $level = ($flash_message == 'Success') ? 'success' : 'warning';
      // echo "<pre>";
      // print_r($return);
      // echo "</pre>";
      // die();

      return \Redirect::to('/hits')->with($level, $flash_message);
    } else {
      return \Redirect::to('/hits')->with('error', 'Hits reset not successfully.');
    }
  }

  public function report(Request $request)
  {
    $options = $request->all();
    $date = $options['date'];

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die('ee');

    $return['code'] = $return['data'] = [];

    $response = AuthService::send('GET', '/api/Admin/GetGenerateHits?Date='. $date);

    if ($response && $response->getStatusCode() == 200) {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
    }

    // echo "<pre>";
    // print_r($return['data']);
    // echo "</pre>";
    // die('ee');

    // $datas =
    //     [
    //         [
    //             "hitsId" => rand(1, 9999),
    //             "date" => "2023-01-23T00:00:00",
    //             "userId" => "2028",
    //             "drawCategory" => "9S3",
    //             "generatedId" => rand(0, 999999),
    //             "winCombination" => rand(1, 999),
    //             "amount" => rand(1, 999),
    //             "winAmount" => rand(1, 999),
    //             "generateBy" => "James G. Cedeño",
    //         ],
    //         [
    //             "hitsId" => rand(1, 9999),
    //             "date" => "2023-01-23T00:00:00",
    //             "userId" => "2027",
    //             "drawCategory" => "9S3",
    //             "generatedId" => rand(0, 999999),
    //             "winCombination" => rand(1, 999),
    //             "amount" => rand(1, 999),
    //             "winAmount" => rand(1, 999),
    //             "generateBy" => "James G. Cedeño",
    //         ],
    //         [
    //             "hitsId" => rand(1, 9999),
    //             "date" => "2023-01-23T00:00:00",
    //             "userId" => "2027",
    //             "drawCategory" => "9S3",
    //             "generatedId" => rand(0, 999999),
    //             "winCombination" => rand(1, 999),
    //             "amount" => rand(1, 999),
    //             "winAmount" => rand(1, 999),
    //             "generateBy" => "James G. Cedeño",
    //         ],
    //     ];

    // $collection = collect($datas);
    // $collection->all();
    // for static datas
    // $return['data'] = json_decode($collection);

    return view('content.reports.hits', ['datas' => $return['data'], 'options' => $options]);
    // $pdf = PDF::loadView('content.reports.hits', ['datas' => $return['data'], 'options' => $options]);
    // $pdf->setPaper('A4','portrait');
    // return $pdf->download("hits_$date.pdf");
  }
}
