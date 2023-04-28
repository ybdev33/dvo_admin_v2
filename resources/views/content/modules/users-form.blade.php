@extends('layouts/contentNavbarLayout')

<?php
$segment2 = \Request::segment('2');
$sub_title = \Str::title($segment2);
?>
@section('title', 'Users '.$sub_title.'')

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light"><a href="/users">Users</a> /</span> {{$sub_title}}</h4>

@section('page-script')

<script type="text/javascript">
  $(document).ready(function() {

    $('.dropdown-toggle').dropdown();

    $('input[name=accountStatus]').change(function() {
      checkValidity();
    });

    var $form = $("#form-module");
    var $submitbutton = $("#form-module button[type='submit']");

    if ($('#password').length && $('#confirm_password').length) {
      var password = document.getElementById("password"),
        confirm_password = document.getElementById("confirm_password");

      function validatePassword() {
        if (password.value && confirm_password.value) {
          if (password.value == confirm_password.value) {
            $('#password_message').html('Matching').addClass('text-success').removeClass('text-danger');
            confirm_password.setCustomValidity('');
          } else {
            $('#password_message').html('Not Matching').addClass('text-danger').removeClass('text-success');
            $submitbutton.attr("disabled", "disabled");
            confirm_password.setCustomValidity("Passwords Don't Match");
          }
        }

        checkValidity();
      }
      password.onkeyup = validatePassword;
      confirm_password.onkeyup = validatePassword;
    }

    $form.on("input", () => {
      checkValidity();
    });

    function checkValidity() {
      if ($('form')[0].checkValidity())
        $submitbutton.removeAttr("disabled");
      else
        $submitbutton.attr("disabled", "disabled");

      <?php if( $user->position === 'Super Admin' || $user->position === 'Admin' ): ?>
        <?php if ( $segment2 == 'edit' ): ?>
          if (password.value == confirm_password.value)
            $submitbutton.removeAttr("disabled");
          else
            $submitbutton.attr("disabled", "disabled");
          // else if (password.value == "" && confirm_password.value == "")

        <?php endif; ?>
      <?php endif; ?>
    }

    $.ajax({
      url: '/api/gaming/getTellerUsers',
      method: 'GET',
      success: function(response) {
        var ulist = response.data;
        ulist = ulist.map(item => {
          return {
            areaId: item.areaId,
            value: item.completename
          };
        });

        populateList(ulist);
      }
    });

    function populateList(ulist) {
      var input = document.querySelector('input[name="tagUser"]');

        if(input) {
          // init Tagify script on the above inputs
          tagify = new Tagify(input, {
            whitelist: ulist,
            enforceWhitelist: true, 
            dropdown: {
              maxItems: 20, // <- mixumum allowed rendered suggestions
              classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
              enabled: 0, // <- show suggestions on focus
              closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
            }
          });

          input.addEventListener('change', onChange);

          tagify.addTags(<?php echo $tagUser ?>)
        }

        function onChange(e){
          checkValidity();
        }
    }

    $('body').on('change','#locationId', function() {
      var locationId = this.value;
      areaLocation(locationId);
    });

    var locationId = "<?php echo $locationId = $userId->locationId ?? old('locationId') ?>";
    if (locationId)
      areaLocation(locationId);

    function areaLocation(locationId) {
      var areaId = "<?php echo $areaLocationId = $userId->areaLocationId ?? old('areaLocationId') ?>";
      
      $.ajax({
        url: '/api/gaming/getMasterAreaLocation?LocationId='+locationId,
        method: 'GET',
        success: function(response) {
          let area = response.data;

          $('#areaLocationId option').remove();
          $('#areaLocationId').append('<option value="" selected>Select area</option>');
          for (var index = 0; index <= area.length; index++) {
            if( area[index] && typeof area[index].areaLocationId !== undefined ) 
            {
              var selectedArea = ( area[index].areaLocationId == areaId ) ? 'selected="selected"' : '';
              $('#areaLocationId').append('<option value="' + area[index].areaLocationId + '" '+ selectedArea +'>' + area[index].areaLocation + '</option>');
            }
          }
        }
      });
    }
  });
</script>

<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.polyfills.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}">
@endsection

<form id="form-module" class="form-horizontal" action="/<?php echo \Request::path() ?>" method="POST" role="form">
  @csrf
  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Basic Info</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label" for="completename">Complete Name</label>
            <div class="input-group input-group-merge">
              <span id="completename2" class="input-group-text"><i class="bx bx-user"></i></span>
              <input type="text" class="form-control" name="completename" value="{{$userId->completename ?? old('completename')}}" id="completename" aria-describedby="completename2" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <div class="input-group input-group-merge">
              <span id="username2" class="input-group-text"><i class="bx bx-at"></i></span>
              <input type="text" id="username" name="username" value="{{$userId->username ?? old('username')}}" class="form-control" required>
            </div>
          </div>
          @if( $segment2 == 'create' || $user->position === 'Super Admin' || $user->position === 'Admin' )
          <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge form-password-toggle">
              <span class="input-group-text"><i class="bx bx-shield"></i></span>
              <input type="password" id="password" name="password" class="form-control" <?php echo ( $segment2 == 'create' ) ? "required" : "" ?>>
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <small id="password_message" class="float-end"></small>
            <div class="input-group input-group-merge form-password-toggle">
              <span class="input-group-text"><i class="bx bx-shield"></i></span>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" <?php echo ( $segment2 == 'create' ) ? "required" : "" ?>>
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
          </div>
          @endif
          <div class="mb-3">
            <label class="form-label" for="mobileNo">Phone No</label>
            <div class="input-group input-group-merge">
              <span id="mobileNo2" class="input-group-text"><i class="bx bx-phone"></i></span>
              <input type="number" id="mobileNo" name="mobileNo" value="{{$userId->mobileNo ?? old('mobileNo')}}" class="form-control phone-mask" placeholder="09451234567" aria-label="09451234567" aria-describedby="mobileNo2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" required>
            </div>
          </div>
        </div>
      </div>

      @if( $segment2 === 'edit' && $userId->positionId == 4 )
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Assigned Teller</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label" for="tagUser">Tag</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-user"></i></span>
              <input id="tagUser" name="tagUser" class="form-control" placeholder="Please tag users" value="">
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Area</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label" for="areaname">Area Name</label>
            <div class="input-group input-group-merge">
              <span id="area_name2" class="input-group-text"><i class="bx bx-map-pin"></i></span>
              <input type="text" class="form-control" name="areaname" value="{{$userId->areaname ?? old('areaname')}}" id="areaname" aria-describedby="area_name2" autocomplete="off" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="locationId">Location</label>
            <div class="input-group input-group-merge">
              <select id="locationId" name="locationId" class="form-select" required>
                <option value="" selected>Select a location</option>
                @if($location)
                @foreach($location as $i => $loc)
                <option value="{{$loc->locationId}}" <?php echo ($locationId == $loc->locationId) ? 'selected="selected"' : '' ?>>{{$loc->locationName}}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="areaLocationId">Area</label>
            <div class="input-group input-group-merge">
              <select id="areaLocationId" name="areaLocationId" class="form-select" required>
                <option value="" selected>Select area</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <?php $positionId = $userId->positionId ?? old('positionId') ?>
      @if( $user->position === 'Super Admin' || $user->position === 'Admin' || $user->position === 'Coordinator' || $user->position === 'Collector' )
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Settings</h5>
        </div>
        <div class="card-body">

          @if( $segment2 === 'edit' )
          <div class="mb-3">
            <small class="text-light fw-semibold d-block">Status</small>
            <div class="form-check form-check-inline mt-3">
              <input class="form-check-input" type="radio" name="accountStatus" id="status1" value="1" <?php echo (!empty($userId->positionId) && $userId->accountStatus) ? 'checked="checked"' : '' ?> />
              <label class="form-check-label" for="status1">Active</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="accountStatus" id="status2" value="0" <?php echo (!empty($userId->positionId) && $userId->accountStatus) ? '' : 'checked="checked"' ?> />
              <label class="form-check-label" for="status2">Inactive</label>
            </div>
          </div>
          @endif
          
          <div class="mb-3">
            <label class="form-label" for="positionId">Position</label>
            <div class="input-group input-group-merge">
              <select id="positionId" name="positionId" class="form-select" required>
                <option value="" selected>Select position</option>
                @if($positions)
                @foreach($positions as $i => $position)
                <option value="{{$position->positionId ?? old('positionId')}}" <?php echo ($positionId == $position->positionId) ? 'selected="selected"' : '' ?>>{{$position->position}}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
      </div>
      @else
        <input type="hidden" name="positionId" value="<?php echo $positionId ?>">
      @endif

      <button type="submit" class="btn btn-primary float-end" disabled>Save</button>
    </div>
  </div>
</form>

@endsection