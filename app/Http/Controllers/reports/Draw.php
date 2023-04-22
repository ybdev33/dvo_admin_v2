<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\{
    App\Services\AuthService,
};
use PDF;

class Draw extends Controller
{
  public function index()
  {
    // $response = AuthService::send('GET', '/api/Admin/GetDrawCategory');

    // $drawcategory = [];
    // $drawcategory = json_decode($response->getBody()->getContents());
    $drawcategory = session()->get('drawcategory');
    
    return view('content.reports.draw', ['date' => now()->toDateString(), 'drawcategory' => $drawcategory]);
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

    // return view('content.reports.draw-pdf.blade', ['datas' => $return['data'], 'options' => $options]);
    $pdf = PDF::loadView('content.reports.draw-pdf.blade', ['datas' => $return['data'], 'options' => $options]);
    $pdf->setPaper('A4','portrait');
    return $pdf->download("draw_$date.pdf");
  }
}
