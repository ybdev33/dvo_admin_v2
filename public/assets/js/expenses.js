
$(function () {

  var date = $('#date').val();

  if ($('#getApproval').length) {
    var table = $('#getApproval').DataTable({
      destroy: true,
      pageLength: 10,
      autoWidth: false,
      bAutoWidth: false,
      ordering: false,
      "bFilter": true,
      "lengthChange": false,
      ajax: {
        "url": "/api/gaming/getApproval?date=" + date
      },
      columns: [
        {
          className: 'dt-control',
          orderable: false,
          data: null,
          defaultContent: '',
        },
        {
          data: "userId",
          "visible": false
        },
        {
          data: "completeName",
          title: "Name"
        },
        {
          data: "areas",
          title: "Area"
        },
        {
          title: "Gross",
          mRender: function (data, type, row) {
            var computation = Math.round(row['totalGross'] * .15);
            return ''+ row['totalGross'] + '&nbsp;—&nbsp;<span class="text-dark"><abbr title="'+ row['totalGross'] + ' * 0.15 = '+ computation + '">' + computation + '</abbr></span>';
          }
        },
        {
          mRender: function (data, type, row) {
            return row['isApprove'] === 1
              ? '<span class="text-danger"><u>'+ row['totalExpense'] +'</u></span>'
              : row['amount'];
          }
        },
        {
          mRender: function (data, type, row) {
            return row['isApprove'] === 1
              ? '<span class="badge bg-label-success ms-2">Approved</span>'
              : ( row['isApprove'] === 2 ) ? '<span class="badge bg-label-primary ms-2">Disapproved</span>'
                                          : '<span class="badge bg-label-secondary ms-2">Pending</span>';
          }
        },
        {
          mRender: function (data, type, row) {
            var lie_dislike;
            if( row['isApprove'] === 0 )
            {
              lie_dislike = '<a href="/approval/approve?id=' + row['expenseHeaderId'] + '&userId=' + row['userId'] + '&approveType=All&isApprove=1" class="btn btn-outline-success btn-sm btn-approve" title="Approve"><i class="bx bx-like"></i> <span class="badge rounded-pill">'+ row['expenseList'].length +'</span></a>';
              lie_dislike += '&nbsp;&nbsp;';
              lie_dislike += '<a href="/approval/approve?id=' + row['expenseHeaderId'] + '&userId=' + row['userId'] + '&approveType=All&isApprove=2" class="btn btn-outline-primary btn-sm btn-approve" title="Disapprove"><i class="bx bx-dislike"></i> <span class="badge rounded-pill">'+ row['expenseList'].length +'</span></a>';
            }
            else
              lie_dislike = '<i class="bx bx-sm w-65">&nbsp;</i><a href="/approval/approve?id=' + row['expenseHeaderId'] + '&userId=' + row['userId'] + '&approveType=All&isApprove=0" class="btn btn-outline-danger btn-sm btn-approve" title="Revert"><i class="bx bx-minus-circle"></i> <span class="badge rounded-pill">'+ row['expenseList'].length +'</span></a>';

            return lie_dislike;
          }
        }
      ],
      columnDefs: [
        {
          targets: 2,
          width: "180",
        },
        {
          targets: 4,
          width: "180",
          className: 'dt-body-right dt-head-right'
        },
        {
          targets: 5,
          title: "Expenses",
          width: "180",
          className: 'dt-body-right dt-head-right'
        },
        {
          targets: 6,
          title: "Status",
          width: "180",
          className: 'dt-body-right dt-head-right'
        },
        {
          targets: 7,
          title: "Action",
          width: "180",
          className: 'dt-body-right dt-head-right'
        },
      ]
    });

    function format(d) {
      var objJson = d.expenseList;

      var tablaTarea = '<table width="100%" class="table-reponsive">';
      tablaTarea += '<thead>' +
        '<tr>' +
            '<th style="width: 65px;">&nbsp;</th>' +
            '<th width="180">Type</th>' +
            '<th>Remarks</th>' +
            '<th class="dt-body-right dt-head-right dt-child" rowspan="1" colspan="1" style="width: 180px;">Amount</th>' +
            '<th class="dt-body-right dt-head-right dt-child" rowspan="1" colspan="1" style="width: 180px;">&nbsp;</th>' +
            '<th class="dt-body-right dt-head-right dt-child" rowspan="1" colspan="1" style="width: 170px;">&nbsp;</th>' +
        '</tr>' +
      '</thead>';
      tablaTarea += '<tbody>';
      $.each(objJson, function (i, item) {
        
        var amountEl = ( objJson[i].isApprove ) ? '<span class="text-danger">'+ objJson[i].amount +'</span>' : objJson[i].amount;
        
        var amountEl = ( objJson[i].isApprove === 1 )
        ? '<span class="text-danger">'+ objJson[i].amount +'</span>'
        : ( objJson[i].isApprove === 2 ) ? '<span class="text-light">'+ objJson[i].amount +'</span>'
                                    : objJson[i].amount;

        var isApproveEl = ( objJson[i].isApprove === 1 )
        ? '<span class="badge bg-label-success">Approved</span>'
        : ( objJson[i].isApprove === 2 ) ? '<span class="badge bg-label-primary">Disapproved</span>'
                                    : '<span class="badge bg-label-secondary">Pending</span>';

        var isApproveElAction = '<a href="/approval/approve?id=' + objJson[i]['expenseHeaderId'] + '&userId=' + objJson[i]['userId'] + '&expenseId=' + objJson[i]['expenseId'] + '&isApprove=1" class="table-delete text-success" title="Approve"><i class="bx bx-check bx-sm w-55"></i></a>';
        isApproveElAction += '&nbsp;&nbsp;';
        isApproveElAction += '<a href="/approval/approve?id=' + objJson[i]['expenseHeaderId'] + '&userId=' + objJson[i]['userId'] + '&expenseId=' + objJson[i]['expenseId'] + '&isApprove=2" class="table-delete text-danger" title="Disapprove"><i class="bx bx-x bx-sm w-55"></i></a>';

        tablaTarea += 
          '<tr>' +
              '<td class="">&nbsp;</td>' +
              '<td width="180">' + objJson[i].expenseType + '</td>' +
              '<td>' + objJson[i].remarks + '</td>' +
              '<td class="dt-body-right dt-head-right">' + amountEl + '</td>' + 
              '<td class="dt-body-right dt-head-right">' + isApproveEl + '</td>' + 
              '<td class="dt-body-right dt-head-right">' + isApproveElAction + '</td>' + 
          '</tr>';
        });
      tablaTarea += '</tbody>';
      tablaTarea += '</table>';

      return (tablaTarea);
    }

    $("body").on("change", "#date", function (e) {
      var date = $(this).val();
      $('#getApproval').DataTable().ajax.url("/api/gaming/getApproval?date=" + date).load();
    });

    $('#getApproval tbody').on('click', 'tr', function () {
      var tr = $(this);
      var row = table.row(tr);
      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
      }
      $('#getApproval tbody tr.table-active').remove();
      $('#getApproval tbody tr').removeClass("dt-hasChild");
      $('#getApproval tbody tr').removeClass("table-secondary");

      // Open this row
      row.child(format(row.data())).show();
      tr.addClass("table-secondary");
      tr.next('tr').addClass("table-active");
    });
  }

  if ($('#getExpenses').length) {
    var table = $('#getExpenses').DataTable({
      destroy: true,
      pageLength: 10,
      autoWidth: false,
      bAutoWidth: false,
      ordering: false,
      "bFilter": true,
      "lengthChange": false,
      ajax: {
        "url": "/api/gaming/getExpenses?date=" + date
      },
      columns: [
        {
          data: "userId",
          "visible": false
        },
        {
          data: "expenseType",
          title: "Type"
        },
        {
          data: "remarks",
          title: "Remarks"
        },
        {
          data: "amount",
          title: "Amount"
        },
        {
          mRender: function (data, type, row) {
            return row['isApprove'] === 1
              ? '<span class="badge bg-label-success ms-2">Approved</span>'
              : ( row['isApprove'] === 2 ) ? '<span class="badge bg-label-primary ms-2">Disapproved</span>'
                                          : '<span class="badge bg-label-secondary ms-2">Pending</span>';
          }
        }
      ],
      columnDefs: [
        {
          targets: 4,
          title: "Status",
          width: "180",
          className: 'dt-body-right dt-head-right px-0'
        },
        {
          targets: 5,
          title: "Action",
          width: "180",
          className: 'dt-body-right dt-head-right',
          mRender: function (data, type, row) {
            if ( row['isApprove'] === 0 )
              return '<a href="/expenses/edit/'+ row['expenseId'] +'" class="text-primary"><i class="bx bx-pencil"></i></a>';
          }
        },
      ]
    });

    $("body").on("change", "#date", function (e) {
      var date = $(this).val();
      $('#getExpenses').DataTable().ajax.url("/api/gaming/getExpenses?date=" + date).load();
    });
  }

});