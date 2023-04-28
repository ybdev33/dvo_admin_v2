<div class="col-md-6 col-lg-4 col-xl-4">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0 row col-12">
          <h5 class="m-0 col-4" type="submit" data-type="card-content"><a href="#">{{ Str::upper($draw) }}</a></h5>
          <small class="fw-semibold col-5 text-center badge <?php echo (str_contains($net_val, '-')) ? 'text-danger bg-label-danger' : 'text-success bg-label-success' ?>">Draw <?php echo isset($draw_val) ? $draw_val : '_' ?></small>
        </div>
        <form class="card-form">
          <input type="hidden" name="userId" value="<?php echo $user->userId ?>">
          <input type="hidden" name="drawcategory" value="<?php echo Str::upper($draw) ?>">
          <input type="hidden" name="date" value="<?php echo (\Request::get('date')) ? \Request::get('date') : date('Y-m-d') ?>">
          <input type="hidden" name="datefrom" value="<?php echo date('Y-m-d') ?>">
          <input type="hidden" name="dateto" value="<?php echo date('Y-m-d') ?>">
          <button class="btn p-0" type="submit" data-type="card-content" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="left" data-bs-html="true" title="<?php echo $tootltip ?>">
            <i class="bx bx-windows text-dark"></i>
          </button>
        </form>
      </div>
      <div class="card-body h-235">
        <div class="d-flex justify-content-between align-items-center my-3">
          <div class="d-flex flex-column align-items-center gap-1">
            <h2 class="mb-2"><?php echo isset($net_val) ? $net_val : '___' ?></h2>
            <span>Total Net</span>
          </div>
          <div id="chart<?php echo $draw ?>"></div>
        </div>
        <div class="row gy-3">
          <div class="col-4 text-center">
            <div class="avatar-initial rounded bg-label-primary"><i class='bx bx-money'></i></div>
            <small class="fw-semibold">Gross</small><br />
            <small id="gross<?php echo $draw ?>"><?php echo isset($amount_val) ? number_format($amount_val, 2) : '0.00' ?></small>
          </div>
          <div class="col-4 text-center">
            <div class="avatar-initial rounded bg-label-warning"><i class='bx bx-crosshair'></i></div>
            <small class="fw-semibold">Hits</small><br />
            <small id="hits<?php echo $draw ?>"><?php echo isset($amount_Hits_val) ? number_format($amount_Hits_val, 2) : '0.00' ?></small>
          </div>
          <div class="col-4 text-center">
            <div class="avatar-initial rounded bg-label-info"><i class='bx bx-pie-chart-alt'></i></div>
            <small class="fw-semibold">Net</small><br />
            <small id="net<?php echo $draw ?>"><?php echo isset($net_val) ? number_format($net_val, 2) : '0.00' ?></small>
          </div>
        </div>
      </div>
      <div class="card-content d-none" id="<?php echo $draw ?>-content">
      </div>
    </div>
  </div>