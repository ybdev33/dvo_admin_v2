
$(document).ready(function () {

  if (localStorage.checkBoxValidation && localStorage.checkBoxValidation != '') {
      $('#remember-me').attr('checked', 'checked');
      $('#email').val(localStorage.username);
      $('#password').val(localStorage.password);
  } else {
      $('#remember-me').removeAttr('checked');
      $('#email').val('');
      $('#password').val('');
  }

  $('#formAuthentication').submit(function (e) {
    e.preventDefault();

    if ($('#remember-me').is(':checked')) {
      // save username and password
      localStorage.username = $('#email').val();
      localStorage.password = $('#password').val();
      localStorage.checkBoxValidation = $('#remember-me').val();
    } else {
      localStorage.username = '';
      localStorage.password = '';
      localStorage.checkBoxValidation = '';
    }

    const formJson = JSON.stringify(Object.fromEntries(new FormData(this)));
    // console.log(formJson);

    $.ajax({
      url: '/api/gaming/authorize',
      type: "POST",
      data: formJson,
      dataType: 'json',
      contentType: 'application/json',
      processData: false,
      success: function (response) {
        if (response.success)
          window.location = response.redirect;
        else
        {
          $.each(response.errors, function(k, v) {
            $('.'+k+'-error').text(v);
          });
        }

      },
      error: function (response) {
        console.log(response)
      },
      xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = ((evt.loaded / evt.total) * 100);
                  $(".progress-bar").width(percentComplete + '%');
              }
          }, false);
          return xhr;
      },
    });
  });
});