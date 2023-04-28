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
    <h5 class="card-header">Create expenses</h5>
    <div class="card-body">
      <p><small>Fill up your expenses today.</small></p>
      <div class="row gx-3 gy-2 align-items-center">
        <div class="col-md-4">
          <label class="form-label" for="expenseType">Type</label>
          <div class="col-md-10">
            <small>Select a type</small>
            <?php $expenseType = $expense->expenseType ?? old('expenseType') ?>
            <select id="expenseType" name="expenseType" class="form-select" required>
              <option value="" selected> --- </option>
              @if($expensesType)
              @foreach($expensesType as $i => $type)
              <option value="{{$type->expenseType ?? old('expenseType')}}" <?php echo ($expenseType == $type->expenseType) ? 'selected="selected"' : '' ?>>{{$type->expenseType}}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <label for="html5-date-input" class="form-label">Remarks</label>
          <div class="col-md-12">
            <small>Type remarks</small>
            <input class="form-control" name="remarks" type="text" value="{{$expense->remarks ?? old('remarks')}}" />
          </div>
        </div>
        <div class="col-md-4">
          <label for="html5-date-input" class="form-label">Amount</label>
          <div class="col-md-12">
            <small>Type a number</small>
            <input class="form-control" name="amount" type="number" value="{{$expense->amount ?? old('amount')}}" oninput="javascript: if (this.value.length > this.maxLength) this.value = parseFloat(this.value.slice(0, this.maxLength));" maxlength="20" required />
          </div>
        </div>
      </div>
      <div class="col-md-3 float-end">
        <div class="col-md-12 pt-4">
          <button class="btn btn-primary d-block float-end" type="submit"><i class="bx bx-save bx-sm"></i> Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection