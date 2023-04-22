<?php 
  $tootltip = (\Request::get('date')) ? "Check Areas" : "<span>Check Areas</span> <i class='bx bx-area bx-xs' ></i>";
  $date_request = date_create(\Request::get('date'));
?>
<div class="row">

  @if ($user->position === 'Super Admin' || $user->position === 'Admin')
  <div class="col-lg-4 mb-4 col-md-4 order-0">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">Monthly Gross</h5>
              <span class="badge bg-label-success rounded-pill"><?php echo date_format($date_request, "F") ?></span>
            </div>
            <div class="mt-sm-auto">
              <h3 class="mb-0">₱<span id="totalMonth"><?php echo isset($data->dashboardDetail->totalPerMonth) ? number_format($data->dashboardDetail->totalPerMonth) : '0' ?></span></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="col-lg-4 mb-4 col-md-4 order-1">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">Total Gross</h5>
              <span class="badge bg-label-warning rounded-pill"><?php echo (\Request::get('date') && \Request::get('date') != date('Y-m-d')) ? date_format($date_request, "M d") : "Today" ?></span>
            </div>
            <div class="mt-sm-auto">
              <h3 class="mb-0">₱<span id="totalGross"><?php echo isset($data->dashboardDetail->totalGross) ? number_format($data->dashboardDetail->totalGross) : '0' ?></span></h3>
            </div>
          </div>
          <div id="profileReportChart"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="<?php echo ($user->position === 'Super Admin' || $user->position === 'Admin') ? "col-lg-4" : "col-lg-8" ?> mb-4 order-2">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-12">
          <div class="card-body">
            <h5 class="card-title text-primary mb-3">Howdy, <?php echo $user->fullName ?>! 🎉</h5>
            <p class="float-start col-sm-8 position-absolute">You have done <span id="Totalpercentage" class="fw-bold"></span> more sales today.</p>
            <img class="float-end" src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" style="margin-top: -33px; margin-right: -45px;">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-8 col-lg-4 order-2 order-md-2">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-0">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-success"><i class='bx bx-pie-chart-alt-2'></i></span>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Net</span>
            <h5 class="card-title text-nowrap mb-0">₱<?php echo isset($data->dashboardDetail->net) ? $data->dashboardDetail->net : '0' ?></h5>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-0">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-info"><i class='bx bx-receipt'></i></span>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Tickets</span>
            <h3 class="card-title text-nowrap mb-0"><?php echo isset($data->dashboardDetail->totalTickets) ? $data->dashboardDetail->totalTickets : '0'  ?></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-0">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-user'></i></span>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Active Users</span>
            <h3 class="card-title text-nowrap mb-0"><?php echo isset($data->dashboardDetail->activeUsers) ? $data->dashboardDetail->activeUsers : '0' ?></h3>
          </div>
        </div>
      </div>
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-0">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-credit-card'></i></span>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Void Sales</span>
            <h3 class="card-title mb-0"><?php echo isset($data->dashboardDetail->voidTransaction) ? $data->dashboardDetail->voidTransaction : '0' ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Grand Total -->
  <div class="col-12 col-lg-8 order-3 order-md-3 order-lg-2 mb-4">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col-md-8">
          <div class="card-header d-flex align-items-center justify-content-between pb-3">
            <h5 class="card-title m-0 col-5">Grand Total</h5>
            <label class="card-header m-0 p-0 text-end col-5 w-auto"><?php echo (\Request::get('date')) ? date_format($date_request, "D, M d Y") : date('D, M d Y') ?></label>
            <form class="card-form">
              <input type="hidden" name="userId" value="<?php echo $user->userId ?>">
              <input type="hidden" name="drawcategory" value="All">
              <input type="hidden" name="date" value="<?php echo (\Request::get('date')) ? \Request::get('date') : date('Y-m-d') ?>">
              <input type="hidden" name="datefrom" value="<?php echo date('Y-m-d') ?>">
              <input type="hidden" name="dateto" value="<?php echo date('Y-m-d') ?>">
              <button class="btn p-0" type="submit" data-type="card-content" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="left" data-bs-html="true" title="<?php echo $tootltip ?>">
                <i class="bx bx-windows text-dark"></i>
              </button>
            </form>
          </div>

          <div class="card-body h-235">
            <ul class="p-0 mt-3">
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-bar-chart-alt'></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Gross</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 id="grossTotal" class="mb-0"><?php echo isset($data->total) ? number_format($data->total, 2) : '0.00' ?></h6> <span class="text-muted">PHP</span>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-danger"><i class='bx bx-wallet'></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Hits</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 id="hitsTotal" class="mb-0"><?php echo isset($data->total_hits) ? number_format($data->total_hits, 2) : '0.00' ?></h6> <span class="text-muted">PHP</span>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-3 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class='bx bx-pie-chart-alt'></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Net</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 id="netTotal" class="mb-0"><?php echo isset($data->net_total) ? number_format($data->net_total, 2) : '0.00' ?></h6> <span class="text-muted">PHP</span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-content d-none h-235" id="all-content">
          </div>
        </div>
        <div class="col-md-4">
          <div class="text-center pt-2 m-3">
            <div class="dropdown">
              <a href="/reports" class="btn btn-sm btn-outline-primary" type="button" id="growthReportId">
                Report
              </a>
            </div>
          </div>
          <div id="growthChart"></div>
          <div class="text-center fw-semibold pt-3 mb-2">Grand Total</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$drawcategory = session()->get('drawcategory')->draws;
// echo "<pre>";
// print_r($drawcategory);
// echo "</pre>";
// var_dump(in_array('2S1', array_column($drawcategory, 'draws')));
?>
<div class="row">
@if( in_array('2S2', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "2s2",
    'draw_val'        => $data->draw_2s2,
    'net_val'         => $data->net_2S2,
    'amount_val'      => $data->amount_2S2,
    'amount_Hits_val' => $data->amount_Hits_2S2,
  ])
@endif

@if( in_array('2S3', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "2s3",
    'draw_val'        => $data->draw_2s3,
    'net_val'         => $data->net_2S3,
    'amount_val'      => $data->amount_2S3,
    'amount_Hits_val' => $data->amount_Hits_2S3,
  ])
@endif

@if( in_array('5S2', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "5s2",
    'draw_val'        => $data->draw_5s2,
    'net_val'         => $data->net_5S2,
    'amount_val'      => $data->amount_5S2,
    'amount_Hits_val' => $data->amount_Hits_5S2,
  ])
@endif

@if( in_array('5S3', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "5s3",
    'draw_val'        => $data->draw_5s3,
    'net_val'         => $data->net_5S3,
    'amount_val'      => $data->amount_5S3,
    'amount_Hits_val' => $data->amount_Hits_5S3,
  ])
@endif

@if( in_array('9S2', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "9s2",
    'draw_val'        => $data->draw_9s2,
    'net_val'         => $data->net_9S2,
    'amount_val'      => $data->amount_9S2,
    'amount_Hits_val' => $data->amount_Hits_9S2,
  ])
@endif

@if( in_array('9S3', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "9s3",
    'draw_val'        => $data->draw_9s3,
    'net_val'         => $data->net_9S3,
    'amount_val'      => $data->amount_9S3,
    'amount_Hits_val' => $data->amount_Hits_9S3,
  ])
@endif

@if( in_array('9L2', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "9L2",
    'draw_val'        => $data->draw_9L2,
    'net_val'         => $data->net_9L2,
    'amount_val'      => $data->amount_9L2,
    'amount_Hits_val' => $data->amount_Hits_9L2,
  ])
@endif

@if( in_array('4D', array_column($drawcategory, 'draws')) )
  @include('content/dashboard/dashboards-widget-draw', [
    'draw'            => "4D",
    'draw_val'        => $data->draw_4D,
    'net_val'         => $data->net_4D,
    'amount_val'      => $data->amount_4D,
    'amount_Hits_val' => $data->amount_Hits_4D,
  ])
@endif
</div>