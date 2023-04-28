
      <div class="col-6 mb-4">
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
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-0">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-info"><i class='bx bx-receipt'></i></span>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Tickets</span>
            <h5 class="card-title text-nowrap mb-0"><?php echo isset($data->dashboardDetail->totalTickets) ? $data->dashboardDetail->totalTickets : '0'  ?></h5>
          </div>
        </div>
      </div>
      <div class="col-6 mb-4">
        <div class="card">
          <a href="/users">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-0">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-user'></i></span>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Active Users</span>
              <h3 class="card-title text-nowrap mb-0"><?php echo isset($data->dashboardDetail->activeUsers) ? $data->dashboardDetail->activeUsers : '0' ?></h3>
            </div>
          </a>
        </div>
      </div>
      <div class="col-6 mb-4">
        <div class="card">
          <a href="/cancel-bets">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-0">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-secondary"><i class='bx bx-credit-card'></i></span>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Void Sales</span>
              <h3 class="card-title mb-0"><?php echo isset($data->dashboardDetail->voidTransaction) ? $data->dashboardDetail->voidTransaction : '0' ?></h3>
            </div>
          </a>
        </div>
      </div>