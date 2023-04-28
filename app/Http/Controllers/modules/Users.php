<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Facades\{
  App\Services\AuthService,
};

class Users extends ApiBaseController
{
  public function index()
  {
    $user = session()->get('user');

    return view('content.modules.users', ['user' => $user]);
  }

  public function users()
  {
    $user = session()->get('user');
    $return['code'] = $return['data'] = [];

    $response = AuthService::send('GET', '/api/AppUsers/GetRegisterUser?userId=' . $user->userId);

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

  public function userForm($id = '')
  {
    $user = session()->get('user');

    $userId = $return['code'] = $location['data'] = $area['data'] = $positions['data'] = $tagUser = [];

    if ($id) {
      $return = AuthService::send('GET', '/api/AppUsers/GetRegisterUserId?userId=' . $id);
      if ($return && $return->getStatusCode() == 200)
        $userId = json_decode($return->getBody()->getContents());
    }
    // echo "<pre>";
    // print_r($user);
    // echo "</pre>";

    // die();

    $return1 = AuthService::send('GET', '/api/Common/GetLocation');
    if ($return1 && $return1->getStatusCode() == 200)
      $location['data'] = json_decode($return1->getBody()->getContents());

    $return2 = AuthService::send('GET', '/api/Common/GetMasterAreaLocation');
    if ($return2 && $return2->getStatusCode() == 200)
      $area['data'] = json_decode($return2->getBody()->getContents());

    if ($user->position === 'Super Admin' || $user->position === 'Admin' || $user->position === 'Coordinator' || $user->position === 'Collector') {
      $return3 = AuthService::send('GET', '/api/Admin/GetPosition?positionId='.$user->positionId);
      if ($return3 && $return3->getStatusCode() == 200)
        $positions['data'] = json_decode($return3->getBody()->getContents());
    }
    
    if (isset($userId->positionId) && $userId->positionId == 4) { // Collector
      $return4 = AuthService::send('GET', 'api/Admin/GetTagTellerUsers?userId=' . $id);
      if ($return4 && $return4->getStatusCode() == 200)
        $tagUsers['data'] = json_decode($return4->getBody()->getContents());

      foreach ($tagUsers['data'] as $key => $value) {
        $tagUser[] = [
          'areaId' => (int) $value->areaId,
          'value' => $value->completename,
        ];
      }
    }

    // echo "<pre>";
    // print_r($location['data']);
    // echo "</pre>";

    // die();

    return view('content.modules.users-form', ['user' => $user, 'userId' => $userId, 'location' => $location['data'], 'areas' => $area['data'], 'positions' => $positions['data'], 'tagUser' => json_encode($tagUser)]);
  }

  public function createOrUpdate(Request $request, $id = '')
  {
    $options['json'] = $request->all();

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";

    if ($id) {
      $options['json']['userId'] = $id;
      $options['json']['authorId'] = session()->get('user')->userId;
      if (isset($options['json']['accountStatus']))
        $options['json']['accountStatus'] = (bool) $options['json']['accountStatus'];

      // echo "<pre>";
      // print_r($options);
      // echo "</pre>";
      // var_dump($options['json']['password']);
      // var_dump($options['json']['confirm_password']);

      unset($options['json']['confirm_password']);
      if ( empty($options['json']['password']) && empty($options['json']['confirm_password']))
        unset($options['json']['password']);

      // echo "<pre>";
      // print_r($options);
      // echo "</pre>";
      // die("X");

      $response = AuthService::send('PUT', '/api/AppUsers/UpdateUser', $options);
    } else {
      $options['json']['registerById'] = session()->get('user')->userId;
      $response = AuthService::send('POST', '/api/AppUsers/RegisterUser', $options);
    }
    
    if( isset($options['json']['positionId']) && $options['json']['positionId'] == 4 ) // Collector
    {
      $tagOptions['json'] = [
        'userId' => (int) $id,
        'area' => [["areaId" => 0]]
      ];
      if ( isset($options['json']['tagUser']) ) {
        $tagUser = json_decode($options['json']['tagUser']);
        $areaIds = [];
        foreach ($tagUser as $key => $value) {
          $areaIds[]['areaId'] = (int) $value->areaId;
        }
        $tagOptions['json'] = [
          'userId' => (int) $id,
          'area' => $areaIds
        ];
      }
        
      $tag = AuthService::send('POST', '/api/Admin/TagTellerDash', $tagOptions);
      // echo "<pre>";
      // print_r($tag);
      // echo "</pre>";

      if ($tag->getStatusCode() == 200) {
        $returnTag['code'] = $tag->getStatusCode();
        $returnTag['data'] = json_decode($tag->getBody()->getContents());
      }
      // echo "<pre>";
      // print_r(json_encode($tagOptions['json']));
      // echo "</pre>";
      // die('$');
    }

    if ($response->getStatusCode() == 200) {

      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());

      // echo "<pre>";
      // print_r($return['data']);
      // echo "</pre>";
      // die();

      $level = 'success';
      $redirect = request()->path();
      $flash_message = $return['data']->response;
      if ( empty($id) ) {
        $redirect = 'users';
      }

      if ($return['data']->response != 'User created successfully.' && $return['data']->response != 'User updated successfully.') {
        $level = 'warning';
        return redirect()->back()->withInput()->with($level, $flash_message);
      }

      return \Redirect::to('/' . $redirect)->with($level, $flash_message);
    } else {
      return \Redirect::to('/users')->with('error', 'Invalid');
    }
  }

  public function delete($id = '')
  {
    $response = AuthService::send('DELETE', '/api/AppUsers/Deleteuser?userId=' . $id);

    if ($response->getStatusCode() == 200) {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      $additional['redirect'] = url('/users');

      return \Redirect::to('/users')->with('success', 'User deleted successfully.');
    } else {
      return response()->json([
        "status" => false,
        "errors" => ["Invalid"]
      ]);
    }
  }

  // tag Users
  public function getTellerUsers()
  {
    $user = session()->get('user');
    $return['code'] = $return['data'] = [];

    $response = AuthService::send('GET', '/api/Admin/GetTellerUsers');

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

  public function getMasterAreaLocation(Request $request, $id = '')
  {
    $response = AuthService::send('GET', '/api/Common/GetMasterAreaLocation?LocationId='. $request->LocationId);

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
}
