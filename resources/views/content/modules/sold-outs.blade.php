@extends('layouts/contentNavbarLayout')

@section('title', \Str::title(str_replace('-', ' ', Request::segment(1))))

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
<script src="{{asset('assets/vendor/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.min.js')}}"></script>

<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light">{{ \Str::title(str_replace('-', ' ', Request::segment(1))) }}</h4>

<div class="mb-4">
    <div class="align-items-center">

            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <a href="/sold-outs" class="nav-link <?php echo (Request::segment(1) == 'sold-outs') ? 'active' : '' ?>">Sold Outs</a>
                    </li>
                    <li class="nav-item">
                        <a href="/hot-number" class="nav-link <?php echo (Request::segment(1) == 'hot-number') ? 'active' : '' ?>">Hot Number</a>
                    </li>
                    <li class="nav-item">
                        <a href="/draw-limit" class="nav-link <?php echo (Request::segment(1) == 'draw-limit') ? 'active' : '' ?>">Draw Limit</a>
                    </li>
                    <li class="nav-item">
                        <a href="/bet-limit" class="nav-link <?php echo (Request::segment(1) == 'bet-limit') ? 'active' : '' ?>">Bet Limit</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <?php if( Request::segment(1) == 'sold-outs' ): ?>
                    <div class="tab-pane fade show active" id="navs-sold-outs" role="tabpanel">
                        <a href="/sold-outs/create" id="previewReport" class="btn btn-dark float-end mb-3" type="submit"><i class="bx bx-plus bx-sm"></i> Create</a>
                        <div class="col-12 table-responsive text-nowrap">
                            <table id="getSoldOut" class="table table-hover" data-type="<?php echo Request::segment(1) ?>"></table>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if( Request::segment(1) == 'hot-number' ): ?>
                    <div class="tab-pane fade show active" id="navs-hot-number" role="tabpanel">
                        <a href="/hot-number/create" id="previewReport" class="btn btn-dark float-end mb-3" type="submit"><i class="bx bx-plus bx-sm"></i> Create</a>
                        <div class="col-12 table-responsive text-nowrap">
                            <table id="getSoldOut" class="table table-hover" data-type="<?php echo Request::segment(1) ?>"></table>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if( Request::segment(1) == 'draw-limit' ): ?>
                    <div class="tab-pane fade show active" id="navs-draw-limit" role="tabpanel">
                        <a href="/draw-limit/create" id="previewReport" class="btn btn-dark float-end mb-3" type="submit"><i class="bx bx-plus bx-sm"></i> Create</a>
                        <div class="col-12 table-responsive text-nowrap">
                            <table id="getSoldOut" class="table table-hover" data-type="<?php echo Request::segment(1) ?>"></table>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if( Request::segment(1) == 'bet-limit' ): ?>
                    <div class="tab-pane fade show active" id="navs-draw-limit" role="tabpanel">
                        <a href="/bet-limit/create" id="previewReport" class="btn btn-dark float-end mb-3" type="submit"><i class="bx bx-plus bx-sm"></i> Create</a>
                        <div class="col-12 table-responsive text-nowrap">
                            <table id="getSoldOut" class="table table-hover" data-type="<?php echo Request::segment(1) ?>"></table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
    </div>

</div>
@endsection