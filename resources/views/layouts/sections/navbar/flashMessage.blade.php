@if ($message = Session::get('success'))
<div class="flash-message">
  <div class="alert alert-success alert-dismissible" role="alert">
  	{{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif


@if ($message = session('error'))
<div class="flash-message">
  <div class="alert alert-danger alert-dismissible" role="alert">
  	{{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="flash-message">
  <div class="alert alert-warning alert-dismissible" role="alert">
  	{{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif


@if ($message = Session::get('info'))
<div class="flash-message">
  <div class="alert alert-info alert-dismissible" role="alert">
  	{{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif


@if ($errors->any())
<div class="flash-message">
  <div class="alert alert-danger alert-dismissible" role="alert">
  	{{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif