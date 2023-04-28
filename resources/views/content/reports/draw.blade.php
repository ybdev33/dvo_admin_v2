@extends('layouts/contentNavbarLayout')

@section('title', 'Reports')

@section('page-script')
<script src="{{asset('assets/js/draw.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4 no-print"><span class="text-muted fw-light">Reports /</span> <span id="reportTypeText"></span></h4>

<form id="reportPreview" class="form-horizontal" method="POST" role="form">
  @csrf
  <!-- Bootstrap Draw -->
  <input id="date_today" type="hidden" value="<?php echo date('Y-m-d') ?>" />
  <div class="card mb-4 no-print">
    <h5 class="card-header">Select a date range</h5>
    <div class="card-body">
      <p><small>Tell us the dates to be included in your draw report.</small></p>
      <div class="row gx-3 gy-2 align-items-center">
        <div class="col-md-3">
          <label class="form-label" for="reportType">Report Type</label>
          <div class="col-md-10">
            <small>Select a type</small>
            <select id="reportType" name="reportType" class="form-select" required>
              <option value="" selected> --- </option>
              <option value="tallySheet">Tally Sheet</option>
              <option value="drawMunicipality">Draw per Municipality</option>
              <option value="stallSummary" >Stall Summary</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="drawcategory">Category</label>
          <div class="col-md-10">
            <small>Select a category</small>
            <select id="drawcategory" name="drawcategory" class="form-select" required>
              <option value="" selected> --- </option>
              @if($drawcategory)
              @foreach($drawcategory->draws as $i => $cat)
              <option value="{{$cat->draws}}">{{$cat->draws}}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <label for="html5-date-input" class="form-label">Date From</label>
          <div class="col-md-10">
            <small>Select a start date</small>
            <input class="form-control datepicker" id="datefrom" name="datefrom" type="date" value="<?php echo $date ?>" />
          </div>
        </div>
        <div class="col-md-3">
          <label for="html5-date-input" class="form-label">Date To</label>
          <div class="col-md-10">
            <small>Select an end date</small>
            <input class="form-control datepicker" name="dateto" type="date" value="<?php echo $date ?>" />
          </div>
        </div>
      </div>
      <div class="col-md-3 float-end">
        <div class="col-md-12 pt-4">
          <button id="previewReport" class="btn btn-primary d-block float-end" type="submit"><i class="bx bx-file-find bx-sm"></i> Preview</button>
        </div>
      </div>
    </div>
  </div>
  <!--/ Bootstrap Draw -->

  <!-- Bootstrap Draw Preview -->
  <div class="card mb-4">
    <div class="row no-print">
      <div class="col-md-6">
        <h5 class="card-header">Preview Report</h5>
      </div>
      <div class="col-md-6">
        <button id="printReport" class="btn btn-dark d-block float-end m-3 d-none" type="submit" value="report"><i class="bx bx-printer bx-sm"></i> Print Report</button>
      </div>
    </div>

    <div class="row g-0">
      <div class="col-md-12 ui-bg-overlay-container p-4">
        <div class="ui-bg-overlay bg-dark opacity-75 rounded-end-bottom"></div>
        <div id="wrapper-pdf" class="fw-semibold text-center overflow-hidden p-3 bg-light">
          <div id="report-pdf">Loading PDF...</div>
        </div>

      </div>
    </div>
  </div>
</form>

<!--/ Bootstrap Toasts Styles -->
@endsection