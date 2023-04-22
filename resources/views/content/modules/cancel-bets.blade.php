@extends('layouts/contentNavbarLayout')

@section('title', 'Cancel Bets')

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
<script src="{{asset('assets/js/draw.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.min.js')}}"></script>

<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-semibold py-0 mb-4"><span class="text-muted fw-light">Cancel Bets</h4>

<div class="card mb-4">
    <div class="card-body pb-0">
        <div class="row gx-3 gy-2 align-items-center">
            <div class="col-md-3">
                <div class="col-md-12">
                    <small>Date From</small>
                    <input class="form-control datepicker" id="datefrom" name="datefrom" type="date" value="<?php echo date('Y-m-d') ?>" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12">
                    <small>Date To</small>
                    <input class="form-control datepicker" id="dateto" name="dateto" type="date" value="<?php echo date('Y-m-d') ?>" />
                </div>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive text-nowrap">
        <table id="getBetCancel" class="table table-hover">
        </table>
    </div>
</div>
@endsection