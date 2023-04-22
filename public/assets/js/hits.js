
$(document).ready(function () {

    $('#form-module').submit(function (e) {
      var button = $(document.activeElement).val();
      console.log(button);
      if (button == 'report')
        return true;

      e.preventDefault();
      return;
      const formJson = JSON.stringify(Object.fromEntries(new FormData(this)));
      // console.log(formJson);

      // only for mobile
      if (Helpers.isMobileDevice()) {
        $(".layout-page .layout-navbar").hide();
        $(".no-print").hide();
        $("footer").hide();
        $(".ui-bg-overlay-container").removeClass('p-4');
        
        $("#wrapper-pdf").removeClass('d-none').addClass('d-block');
      }
      
      var title = document.title;
      document.title = "hits_"+ new Date().toISOString().slice(0, 10);

      $.ajax({
        url: '/api/gaming/getReportHits',
        type: "POST",
        data: formJson,
        dataType: 'html',
        contentType: 'application/json',
        processData: false,
        success: function (response) {
          // console.log(response);
          if (response == '') {
            $("#printReport").addClass('d-none');
          } else {
            $(this).unbind();
            $(this).submit();
            $("#printReport").removeClass('d-none').addClass('d-block');
            $("#report-pdf").html(response);

            let focuser = setInterval(() => window.dispatchEvent(new Event('focus')), 500);

            setTimeout(function () {
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

                      $("#wrapper-pdf").addClass('d-none');
                    }
                }
              });
            }, 500);
          }
        },
        error: function (response) {
          console.log(response)
        }
      });
    });
    
});
    
  // $('#form-module').submit(function (e) {
  //   e.preventDefault();

  //   const formJson = JSON.stringify(Object.fromEntries(new FormData(this)));
  //   // console.log(formJson);

  //   // only for mobile
  //   if (Helpers.isMobileDevice()) {
  //     $(".layout-page .layout-navbar").hide();
  //     $(".no-print").hide();
  //     $("footer").hide();
  //     $(".ui-bg-overlay-container").removeClass('p-4');
      
  //     $("#wrapper-pdf").removeClass('d-none').addClass('d-block');
  //   }
    
  //   var title = document.title;
  //   document.title = "hits_"+ new Date().toISOString().slice(0, 10);

  //   $.ajax({
  //     url: '/api/gaming/getReportHits',
  //     type: "POST",
  //     data: formJson,
  //     dataType: 'html',
  //     contentType: 'application/json',
  //     processData: false,
  //     success: function (response) {
  //       // console.log(response);
  //       if (response == '') {
  //         $("#printReport").addClass('d-none');
  //       } else {
  //         $("#printReport").removeClass('d-none').addClass('d-block');
  //         $("#report-pdf").html(response);

  //         let focuser = setInterval(() => window.dispatchEvent(new Event('focus')), 500);

  //         setTimeout(function () {
  //           printJS({
  //             printable: 'report-pdf',
  //             type: 'html',
  //             onPrintDialogClose: () => {
  //                 // only for mobile
  //                 clearInterval(focuser);
  //                 document.title = title;
                  
  //                 if (Helpers.isMobileDevice()) {
  //                   $(".layout-page .layout-navbar").show();
  //                   $(".no-print").show();
  //                   $("footer").show();
  //                   $(".ui-bg-overlay-container").addClass('p-4');

  //                   $("#wrapper-pdf").addClass('d-none');
  //                 }
  //             }
  //           });
  //         }, 500);
  //       }
  //     },
  //     error: function (response) {
  //       console.log(response)
  //     }
  //   });
  // });