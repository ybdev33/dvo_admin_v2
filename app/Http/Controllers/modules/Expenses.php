<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Facades\{
  App\Services\AuthService,
};

class Expenses extends ApiBaseController
{
  public function index()
  {
    return view('content.modules.expenses');
  }

  public function approval(Request $request)
  {
    $user = session()->get("user");
    $return['code'] = $return['data'] = [];
    $options['json'] = $request->all();
    $options['json']['userId'] = $user->userId;

    if( $user->position !== "Super Admin" && $user->position !== "Admin" ) return false;

    /* USER 1095 */
    $user = session()->get('user');
    $date = $options['json']['date'];
    if( $user->userId >= 1095 )
    {
        $date = ( $date < '2023-04-25' ) ? '2022-01-01': $date;
    }
    $options['json']['date'] = $date;
    /* USER 1095 */

    // APPROVAL EXPENSES
    $response = AuthService::send('POST', '/api/Admin/GetExpensesPerTeller', $options);

    if ($response && $response->getStatusCode() == 200) {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      $return['data'] = $return['data']->dashUser;
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
    $options['json']['userId'] = $options['json']['userId']; // userId of expenses
    $options['json']['approverId'] = session()->get('user')->userId;
    $options['json']['expenseHeaderId'] = $options['json']['id'];
    $options['json']['expenseId'] = (isset($options['json']['expenseId'])) ? $options['json']['expenseId'] : 0;
    $options['json']['approveType'] = (isset($options['json']['approveType'])) ? (string) $options['json']['approveType'] : "na";
    $options['json']['isApprove'] = $options['json']['isApprove'];

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die('ee');
    $response = AuthService::send('POST', '/api/Admin/ApproveExpense', $options);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    // die();

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

      return \Redirect::to('/approval')->with($level, $flash_message);
    } else {
      return \Redirect::to('/approval')->with('error', 'Expense approval not successfully.');
    }
  }

  public function expenses(Request $request)
  {
    $user = session()->get("user");
    $return['code'] = $return['data'] = [];
    $options['json'] = $request->all();
    $options['json']['userId'] = $user->userId;

    $response = AuthService::send('POST', '/api/Common/GetExpenses', $options);

    if ($response && $response->getStatusCode() == 200) {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());
      // $return['data'] = $return['data']->dashUser;
    }

    // echo "<pre>";
    // print_r($return['data']);
    // echo "</pre>";

    // die();

    return $this->sendResponse($return);
  }

  public function expensesForm($id = '')
  {
    $user = session()->get("user");
    $options['json']['expenseId'] = $id;
    $options['json']['userId'] = $user->userId;
    $options['json']['date'] = date('Y-m-d');
    $expense = [];
    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    if ($id) {
      $return = AuthService::send('POST', '/api/Admin/GetExpenseId', $options);
      if ($return && $return->getStatusCode() == 200)
        $expense = json_decode($return->getBody()->getContents());
    }

    // echo "<pre>";
    // print_r($expense);
    // echo "</pre>";
    // die('$');

    $response = AuthService::send('GET', '/api/Common/GetExpensesType');

    $expensesType = [];
    $expensesType = json_decode($response->getBody()->getContents());

    return view('content.modules.expenses-form', ['expensesType' => $expensesType, 'expense' => $expense]);
  }

  public function createOrUpdate(Request $request, $id = '')
  {
    $options['json'] = $request->all();
    $options['json']['userId'] = session()->get('user')->userId;
    $options['json']['date'] = date('Y-m-d');

    if ($id) {
      $options['json']['expenseId'] = $id;
      $request = '/api/Common/UpdateExpense';
      $message = 'Updated successfully.';
    } else {
      $request = '/api/Common/InsertExpense';
      $message = 'Created successfully.';
    }
    
    $response = AuthService::send('POST', $request, $options);

    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die();

    if ($response->getStatusCode() == 200) 
    {
      $return['code'] = $response->getStatusCode();
      $return['data'] = json_decode($response->getBody()->getContents());

      $flash_message = ($return['data']->stat == 'Success') ? $message : 'warning';
      $level = ($return['data']->stat == 'Success') ? 'success' : 'warning';

    // echo "<pre>";
    // print_r($return['data']);
    // echo "</pre>";

    // die();
    
      return \Redirect::to('/expenses')->with($level, $flash_message);
    } else {
      return \Redirect::to('/expenses')->with('error', 'Invalid');
    }
  }
}
