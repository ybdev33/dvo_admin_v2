<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Facades\{
  App\Services\AuthService,
};

class Settings extends ApiBaseController
{
  public function index()
  {
    return view('content.modules.settings');
  }
}
