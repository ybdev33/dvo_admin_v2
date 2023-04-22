@extends('layouts/contentNavbarLayout')

@section('title', \Str::title(str_replace('-', ' ', Request::segment(1))))

@section('page-script')
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light"><a href="/<?php echo Request::segment(1) ?>">{{ \Str::title(str_replace('-', ' ', Request::segment(1))) }}</a> /</span> Create</h4>

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
        <div class="col-md-4">
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
        <?php if( Request::segment(1) != 'draw-limit' && Request::segment(1) != 'bet-limit' ): ?>
        <div class="col-md-4">
          <label for="html5-date-input" class="form-label">Combination</label>
          <div class="col-md-12">
            <small>Type a number</small>
            <input class="form-control" name="combination" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="0" required />
          </div>
        </div>
        <?php endif; ?>
        <div class="col-md-4">
          <label for="html5-date-input" class="form-label"><?php echo (Request::segment(1) == 'sold-outs') ? 'Win Rate' : 'Sales Limit' ?></label>
          <div class="col-md-12">
            <small>Type a number</small>
            <input class="form-control" name="<?php echo (Request::segment(1) == 'sold-outs') ? 'winrate' : 'salesLimit' ?>" type="number" value="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = parseFloat(this.value.slice(0, this.maxLength));" maxlength="30" required />
          </div>
        </div>
      </div>
      <div class="col-md-3 float-end">
        <div class="col-md-12 pt-4">
          <input type="hidden" name="type" value="<?php echo Request::segment(1) ?>" /> 
          <button id="previewReport" class="btn btn-primary d-block float-end" type="submit"><i class="bx bx-plus bx-sm"></i> Create</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection