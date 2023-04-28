@extends('layouts/contentNavbarLayout')

@section('title', 'Users')

@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/datatables/datatables.min.css')}}">
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

<script type="text/javascript">
  $(function() {

    if ($('#getRegisterUser').length) {
      $('#getRegisterUser').DataTable({
        destroy: true,
        pageLength: 10,
        autoWidth: false,
        bAutoWidth: false,
        ordering: false,
        "bFilter": true,
        "lengthChange": false,
        ajax: {
          "url": "/api/gaming/getRegisterUser"
        },
        columns: [{
            data: "userId",
            "visible": false
          },
          {
            data: "dateRegistered",
            title: "Date Register"
          },
          {
            data: "fullName",
            title: "Full Name"
          },
          {
            data: "userName",
            title: "User Name"
          },
          {
            data: "cellPhone",
            title: "Cellphone No."
          },
          {
            data: "position",
            title: "Position"
          },
          {
            mRender: function(data, type, row) {
              <?php if ($user->position === 'Super Admin' || $user->position === 'Admin') : ?>

                return row['accountStatus'] ?
                  '<div class="form-check form-switch mb-2">' +
                  '<input class="form-check-input" type="checkbox" data-userid="' + row['userId'] + '" data-status="' + row['accountStatus'] + '" title="Active" checked>' +
                  '</div>' :
                  '<div class="form-check form-switch mb-2">' +
                  '<input class="form-check-input" type="checkbox" data-userid="' + row['userId'] + '" data-status="' + row['accountStatus'] + '" title="Inactive">' +
                  '</div>'
              <?php else : ?>
                return row['accountStatus'] ? '<span class="badge bg-label-primary me-1">Active</span>' : '<span class="badge bg-label-warning me-1">Inactive</span>';
              <?php endif; ?>
            }
          },
          {
            mRender: function(data, type, row) {
              return '<a href="/users/edit/' + row['userId'] + '" class="table-delete text-primary" data-id="' + row['userId'] + '"><i class="bx bx-pencil"></i></a>';
            }
          }
        ],
        columnDefs: [{
            targets: 1,
            render: DataTable.render.datetime('D MMM YYYY hh:mm A'),
          },
          {
            targets: 6,
            title: "Status",
          },
          {
            targets: 7,
            "className": "text-center",
          }
        ]
      });

      $("body").on("click", ".form-check-input", function (e) {
        var userId = $(this).data("userid");
        var accountStatus = !$(this).data("status");

        var formJson = {
          userId: userId,
          accountStatus: accountStatus,
          authorId: <?php echo $user->userId ?>
        };
        // console.log(formJson);

        $.ajax({
          url: '/api/gaming/activateUser',
          type: "POST",
          data: JSON.stringify(formJson),
          dataType: 'json',
          contentType: 'application/json',
          processData: false,
          success: function(response) {
            $("[data-userid='"+ userId +"']").data("status", response.data.status);
            var title = (response.data.status) ? 'Active' : 'Inactive';
            
            $("[data-userid='"+ userId +"']").attr('title', title);
          },
          error: function(response) {
            console.log(response)
          }
        });
      });
    }
  });
</script>
@endsection

@section('content')
<h4 class="fw-semibold py-3 mb-4"><span class="text-muted fw-light">Users</h4>
<div class="card">

  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">List of Users</h5> <a href="/users/create" id="previewReport" class="btn btn-primary d-block float-end" type="submit"><i class="bx bx-user-plus bx-sm"></i> Create User</a>
  </div>

  <div class="card-body table-responsive text-nowrap">
    <table id="getRegisterUser" class="table table-hover">
    </table>
  </div>
</div>
@endsection