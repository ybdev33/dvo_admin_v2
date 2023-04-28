@extends('layouts/contentNavbarLayout')

@section('title', 'Hits')

@section('page-script')
<script src="{{asset('assets/js/draw.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light"><a href="/hits">Hits</a> /</span> Generate</h4>

<?php
// echo "<pre>";
// print_r($drawcategory->draws);
// echo "</pre>";
// die();
?>

<form id="form-module" class="form-horizontal" action="/<?php echo \Request::path() ?>" method="POST" role="form">
  @csrf
  <div class="card mb-4">
    <h5 class="card-header">Select a date range</h5>
    <div class="card-body">
      <p><small>Tell us the dates to be included in your draw report.</small></p>
      <div class="row gx-3 gy-2 align-items-center">
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
          <label for="html5-date-input" class="form-label">Date</label>
          <div class="col-md-10">
            <small>Select a date</small>
            <input class="form-control datepicker" name="date" type="date" value="<?php echo $date ?>" required />
          </div>
        </div>
        <div class="col-md-6">
          <label for="html5-date-input" class="form-label">Win Combination</label>
          <div class="col-md-12">
            <small>Type a number</small>
            <input class="form-control" name="wincombination" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" required />
          </div>
        </div>
      </div>
      <div class="col-md-3 float-end">
        <div class="col-md-12 pt-4">
          <button id="previewReport" class="btn btn-primary d-block float-end" type="submit"><i class="bx bx-cog bx-sm"></i> Generate</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection