$( function() {
  
  $(".datepicker").datepicker({
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    showOn: "focus"
  });

  $(".datepicker").attr('type', 'text');
});