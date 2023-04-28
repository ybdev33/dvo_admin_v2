@extends('layouts/contentNavbarLayout')

@section('title', 'Expenses')

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/datatables/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.min.css')}}">
<style>
    .form-check.form-switch input {
        cursor: pointer;
    }
</style>
@endsection

@section('page-script')
<script src="{{asset('assets/js/expenses.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.min.js')}}"></script>

<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light">Expenses</h4>
<?php 
    $user = session()->get("user");
?>
<div class="mb-4">
    <div class="align-items-center">

        <div class="nav-align-top mb-4">
            <?php if ($user->position === 'Super Admin' || $user->position === 'Admin') : ?>
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <a href="/approval" class="nav-link <?php echo (Request::segment(1) == 'approval') ? 'active' : '' ?>">For Approval</a>
                </li>
                <li class="nav-item">
                    <a href="/expenses" class="nav-link <?php echo (Request::segment(1) == 'expenses') ? 'active' : '' ?>">Expenses</a>
                </li>
            </ul>
            <?php endif; ?>
            <div class="tab-content">
                <?php if (Request::segment(1) == 'approval') : ?>
                    <div class="tab-pane fade show active" id="navs-sold-outs" role="tabpanel">

                        <div class="d-flex justify-content-between align-items-start pb-0">
                            <div class="nav-item d-flex align-items-center">
                                <small>Date&nbsp;&nbsp;&nbsp;</small>
                                <input class="form-control datepicker" id="date" name="date" type="date" value="<?php echo date('Y-m-d') ?>" />
                                <!-- <input class="form-control datepicker" id="date" name="date" type="date" value="2023-04-14" /> -->
                            </div>
                        </div>
                        <div class="col-12 table-responsive text-nowrap">
                            <table id="getApproval" class="table table-hover table-reponsive" data-type="<?php echo Request::segment(1) ?>">
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (Request::segment(1) == 'expenses') : ?>
                    <div class="tab-pane fade show active" id="navs-hot-number" role="tabpanel">

                        <div class="d-flex justify-content-between align-items-start pb-0">
                            <div class="nav-item d-flex align-items-center">
                                <small>Date&nbsp;&nbsp;&nbsp;</small>
                                <input class="form-control datepicker" id="date" name="date" type="date" value="<?php echo date('Y-m-d') ?>" />
                            </div>

                            <div>
                                <a href="/expenses/create" class="btn btn-primary d-flex float-end mb-2"><i class="bx bx-plus bx-sm"></i> Create</a>
                            </div>
                        </div>
                        <div class="col-12 table-responsive text-nowrap">
                            <table id="getExpenses" class="table table-hover table-striped table-reponsive" data-type="<?php echo Request::segment(1) ?>">
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
@endsection