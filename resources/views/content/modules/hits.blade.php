@extends('layouts/contentNavbarLayout')

@section('title', 'Hits')

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
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
<script src="{{asset('assets/vendor/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.min.js')}}"></script>

<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4 no-print"><span class="text-muted fw-light">Hits</h4>

<form id="form-module" class="form-horizontal" action="<?php echo url('hits/reset') ?>" method="GET" role="form">
  @csrf
  <div class="card">

    <div class="no-print">
      <div class="card-header d-flex justify-content-between align-items-start pb-0">
        <div class="nav-item d-flex align-items-center">
          <small>Date&nbsp;&nbsp;&nbsp;</small>
          <input class="form-control cursor-pointer datepicker" id="date" name="date" type="date" value="<?php echo date('Y-m-d') ?>" />
        </div>

        <div>
          <a href="/hits/create" class="btn btn-primary d-block btn-sm float-end mb-2 btn-gen"><i class="bx bx-cog bx-sm"></i> Generate</a>&nbsp;
          <button class="btn btn-danger d-block float-end btn-sm" type="submit" value="reset"><i class="bx bx-refresh bx-sm"></i> Reset</button>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-start px-4 py-2">
        <small>&nbsp;&nbsp;&nbsp;</small>
        <div>
          <button id="printReport" class="btn btn-dark float-end btn-sm ms-2 d-none" type="submit" value="report"><i class="bx bx-printer bx-sm"></i> Print Report</button>

        </div>
      </div>

      <div class="card-body table-responsive text-nowrap">
        <table id="getGenerateHits" class="table table-hover">
        </table>
      </div>

    </div>

    <div id="wrapper-pdf" class="fw-semibold text-center overflow-hidden p-3 bg-light d-none">
      <div id="report-pdf"></div>
    </div>
  </div>
</form>
@endsection