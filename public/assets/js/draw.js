
$( function() {
  $('#reportPreview').submit(function (e) {
    e.preventDefault();

    const formJson = JSON.stringify(Object.fromEntries(new FormData(this)));
    // console.log(formJson);

    $.ajax({
      url: '/api/gaming/getReportPerDraw',
      type: "POST",
      data: formJson,
      dataType: 'html',
      contentType: 'application/json',
      processData: false,
      success: function (response) {
        // console.log(response);
        if (response == '') {
          $("#printReport").addClass('d-none');
          $("#report-pdf").html('No results found.');
        } else {
          $("#printReport").removeClass('d-none').addClass('d-block');
          $("#report-pdf").html(response);
          
          //1px = 0.026458 cm;
          var cm = 0.026458;
          var table_wrapper = $(".table-wrapper").height();
          // console.log(table_wrapper * cm);
          if( 24 > table_wrapper * cm )
            $(".table-column").addClass('min4');
        }
      },
      error: function (response) {
        console.log(response)
      }
    });
  });

  $("body").on("click", "#printReport", function () {
    // only for mobile
    if (Helpers.isMobileDevice()) {
      $(".layout-page .layout-navbar").hide();
      $(".no-print").hide();
      $("footer").hide();
      $(".ui-bg-overlay-container").removeClass('p-4');
    }
    
    var title = document.title;
    document.title = $("#reportType option:selected").text().replace(/ /g,'') +"_"+ $("#drawcategory").val() +"_"+ $("#date_today").val();
    
    let focuser = setInterval(() => window.dispatchEvent(new Event('focus')), 500);
    
    printJS({
      printable: 'report-pdf',
      type: 'html',
      onPrintDialogClose: () => {
          // only for mobile
          clearInterval(focuser);
          document.title = title;
          
          if (Helpers.isMobileDevice()) {
            $(".layout-page .layout-navbar").show();
            $(".no-print").show();
            $("footer").show();
            $(".ui-bg-overlay-container").addClass('p-4');
          }
      }
    });
    // printJS('report-pdf', 'html');
  });

  $("body").on("change", "#reportType", function () {
    const option = $(this).val();
    $("#drawcategory").attr("disabled", false);
    $("#printReport").addClass('d-none');
    $("#report-pdf").html('No results found.');
    $("#reportTypeText").text($("#reportType option:selected").text());
    if (option === 'stallSummary') 
    {
      $("#drawcategory").attr("disabled", true);
      $("#drawcategory").val("");
    }
  });
});