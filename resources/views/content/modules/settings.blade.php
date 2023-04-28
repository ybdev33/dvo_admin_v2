@extends('layouts/contentNavbarLayout')

@section('title', \Str::title(str_replace('-', ' ', Request::segment(1))))

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light">{{ \Str::title(str_replace('-', ' ', Request::segment(1))) }}</h4>

<div class="mb-4">
    <div class="align-items-center">

            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <a href="/settings" class="nav-link <?php echo (Request::segment(1) == 'settings') ? 'active' : '' ?>">General</a>
                    </li>
                    <li class="nav-item">
                        <a href="/settings" class="nav-link <?php echo (Request::segment(1) == 'expenses') ? 'active' : '' ?>">Other</a>
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