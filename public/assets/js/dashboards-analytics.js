/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor, redColor, greenColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;
  redColor = config.colors.danger;
  greenColor = config.colors.success;

  // Profit Report Line Chart
  // --------------------------------------------------------------------
  if ($('#profileReportChart').length)
    profileReportChart();

  function profileReportChart() {
    var totalGross = $("#totalGross").text().replaceAll(',', '');
    // console.log($("#totalGross").text() +" "+ totalGross);

    const profileReportChartEl = document.querySelector('#profileReportChart'),
      profileReportChartConfig = {
        chart: {
          height: 40,
          // width: 175,
          type: 'line',
          toolbar: {
            show: false
          },
          dropShadow: {
            enabled: true,
            top: 10,
            left: 5,
            blur: 3,
            color: config.colors.success,
            opacity: 0.15
          },
          sparkline: {
            enabled: true
          }
        },
        grid: {
          show: false,
          padding: {
            right: 8
          }
        },
        colors: [config.colors.success],
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: 5,
          curve: 'smooth'
        },
        series: [
          {
            data: [110, 270, 145, 245, 205, 285, totalGross]
          }
        ],
        xaxis: {
          show: false,
          lines: {
            show: false
          },
          labels: {
            show: false
          },
          axisBorder: {
            show: false
          }
        },
        yaxis: {
          show: false
        }
      };
    if (typeof profileReportChartEl !== undefined && profileReportChartEl !== null) {
      const profileReportChart = new ApexCharts(profileReportChartEl, profileReportChartConfig);
      profileReportChart.render();
    }
  }

  function checkNegativeTotal(category) {
    var textColor = greenColor;
    var net = Math.sign($("#net" + category).text().replaceAll(',', ''));

    if (net == "-1") {
      textColor = redColor;
    }

    return textColor;
  }

  function growthChart() {
    // Growth Chart - Radial Bar Chart
    // --------------------------------------------------------------------
    var grosstotal = parseNumberString($("#grossTotal").text().replaceAll('-', ''));
    var hitstotal = parseNumberString($("#hitsTotal").text().replaceAll('-', ''));
    var nettotal = parseNumberString($("#netTotal").text().replaceAll('-', ''));

    var Totalpercentage;
    var gradientColor = config.colors.primary;

    if (grosstotal == 0) {
      Totalpercentage = "0";
    }

    else {

      Totalpercentage = "100";
      var netall = Math.sign($("#netTotal").text().replaceAll(',', ''));

      if (netall == "-1") {

        var hitall = parseInt($("#hitsTotal").text().replaceAll(',', ''));
        var expenseall = parseInt($("#expenseTotal").text().replaceAll(',', ''));
        var netsall = parseInt($("#netTotal").text().replaceAll(',', ''));

        Totalpercentage = parseFloat((netsall / (hitall + expenseall)) * 100).toFixed(0);
        gradientColor = redColor;
      } else {
        var grossall = $("#grossTotal").text().replaceAll(',', '');
        var netsall = $("#netTotal").text().replaceAll(',', '');

        Totalpercentage = parseFloat((netsall / grossall) * 100).toFixed(2);
      }
    }

    $("#Totalpercentage").text(Totalpercentage + "%");

    const growthChartEl = document.querySelector('#growthChart'),
      growthChartOptions = {
        series: [Totalpercentage.replaceAll('-', '')],
        labels: ['Total'],
        chart: {
          height: 240,
          type: 'radialBar'
        },
        plotOptions: {
          radialBar: {
            inverseOrder: true,
            startAngle: -360,
            endAngle: 0,
            size: 150,
            offsetY: 10,
            startAngle: -150,
            endAngle: 150,
            hollow: {
              size: '55%'
            },
            track: {
              background: cardColor,
              strokeWidth: '100%'
            },
            dataLabels: {
              name: {
                offsetY: 15,
                color: headingColor,
                fontSize: '15px',
                fontWeight: '600',
                fontFamily: 'Public Sans'
              },
              value: {
                offsetY: -10,
                color: checkNegativeTotal("Total"),
                fontSize: '22px',
                fontWeight: '500',
                fontFamily: 'Public Sans'
              },
              total: {
                show: true,
                label: '',
                color: '#373d3f',
                fontSize: '16px',
                fontWeight: 600,
                formatter: function (w) {
                  return Totalpercentage + '%';
                }
              }
            }
          }
        },
        colors: [config.colors.primary],
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            shadeIntensity: 0.5,
            gradientToColors: [gradientColor],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 0.6,
            stops: [30, 70, 100]
          }
        },
        stroke: {
          dashArray: 5
        },
        grid: {
          padding: {
            top: -35,
            bottom: -10
          }
        },
        states: {
          hover: {
            filter: {
              type: 'none'
            }
          },
          active: {
            filter: {
              type: 'none'
            }
          }
        }
      };
    if (typeof growthChartEl !== undefined && growthChartEl !== null) {
      const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
      growthChart.render();
    }
  }

  growthChart();

  parseNumberString('0.00');
  function parseNumberString(number_string) {
    var new_number;
    if (number_string.indexOf(",") >= 0 && number_string.indexOf(".") >= 0)
      var new_number = (parseInt(number_string.replace(/[^0-9\.]/g, '')));
    if (number_string.indexOf(".") >= 0 && number_string.indexOf(",") < 0)
      var new_number = Math.floor(number_string);
    if (number_string.indexOf(",") >= 0 && number_string.indexOf(".") < 0)
      var new_number = number_string.substr(0, number_string.indexOf(','));

    // console.log('Before==> ' + number_string + ' , After==> ' + new_number);
    return new_number;
  }

  function chartRender(category) {
    var grossDB = parseNumberString($("#gross" + category).text().replaceAll('-', ''));
    var hitsDB = parseNumberString($("#hits" + category).text().replaceAll('-', ''));
    var netDB = parseNumberString($("#net" + category).text().replaceAll('-', ''));

    // console.log($("#gross2DB").text(), parseNumberString($("#gross2DB").text()));
    // console.log(grossDB, hitsDB, netDB, category);
    // console.log(parseNumberString(grossDB), parseNumberString(hitsDB), parseNumberString(netDB), category);
    const chartDB = document.querySelector('#chart' + category),
      orderChartConfig = {
        chart: {
          height: 135,
          width: 100,
          type: 'donut'
        },
        labels: ['Gross', 'Hits', 'Net'],
        series: [grossDB, hitsDB, netDB],
        colors: [config.colors.primary, config.colors.danger, config.colors.info],
        stroke: {
          width: 5,
          colors: cardColor
        },
        dataLabels: {
          enabled: false,
        },
        legend: {
          show: false
        },
        grid: {
          padding: {
            top: 0,
            bottom: 0,
            right: 15
          }
        },
        plotOptions: {
          pie: {
            donut: {
              size: '75%',
              labels: {
                show: true,
                value: {

                  fontSize: '1.1rem',
                  fontFamily: 'Public Sans',
                  color: checkNegativeTotal(category),
                  offsetY: -15,
                  formatter: function (val) {
                    return parseInt(val) + '%';
                  }
                },
                name: {
                  offsetY: 20,
                  fontFamily: 'Public Sans'
                },
                total: {
                  show: true,
                  showAlways: true,
                  fontSize: '0.8125rem',
                  color: axisColor,

                  formatter: function (w) {
                    //console.log(grossDB);
                    if (grossDB == 0) {
                      return "0 %"
                    }

                    else {
                      var percentage = "100 %";
                      var net = Math.sign($("#net" + category).text().replaceAll(',', ''));

                      if (net == "-1") {

                        var hit = $("#hits" + category).text().replaceAll(',', '');
                        var nets = $("#net" + category).text().replaceAll(',', '');

                        percentage = parseFloat((nets / hit) * 100).toFixed(2) + "%";
                      } else {
                        var gross = $("#gross" + category).text().replaceAll(',', '');
                        var nets = $("#net" + category).text().replaceAll(',', '');

                        percentage = parseFloat((nets / gross) * 100).toFixed(2) + "%";
                      }

                      return percentage;
                    }

                  }
                }
              }
            }
          }
        }
      };
    if (typeof chartDB !== undefined && chartDB !== null) {
      const chartDBstats = new ApexCharts(chartDB, orderChartConfig);
      chartDBstats.render();
    }
  }

  if ($('#chart2s2').length)
    chartRender('2s2');
  if ($('#chart5s2').length)
    chartRender('5s2');
  if ($('#chart9s2').length)
    chartRender('9s2');

  if ($('#chart2s3').length)
    chartRender('2s3');
  if ($('#chart5s3').length)
    chartRender('5s3');
  if ($('#chart9s3').length)
    chartRender('9s3');

  if ($('#chart9L2').length)
    chartRender('9L2');
  if ($('#chart4D').length)
    chartRender('4D');

  function loadDashbord(date_change, draw) {

    $.ajax({
      url: '/api/gaming/load?date='+ date_change +'&draw=' + draw,
      type: "GET",
      // timeout: 10000,
      success: function (response) {
        // console.log(response);
        $("#dashboard").html(response);

        if ($('#profileReportChart').length)
          profileReportChart();

        if ($('#growthChart').length)
          growthChart();

        if ($('#chart2s2').length)
          chartRender('2s2');
        if ($('#chart5s2').length)
          chartRender('5s2');
        if ($('#chart9s2').length)
          chartRender('9s2');

        if ($('#chart2s3').length)
          chartRender('2s3');
        if ($('#chart5s3').length)
          chartRender('5s3');
        if ($('#chart9s3').length)
          chartRender('9s3');

        if ($('#chart9L2').length)
          chartRender('9L2');
        if ($('#chart4D').length)
          chartRender('4D');

        const cardContent = document.getElementById('loadTop20');
        if (cardContent) {
          new PerfectScrollbar(cardContent, {
            wheelPropagation: false
          });
        }
      },
      error: function (response) {
        console.log(response)
      }
    });
  }

  $("body").on("change", "#datedash", function (e) {
    var date_change = $(this).val();
    var draw = $("#drawCategory").text();
    loadDashbord(date_change, draw);
  });

  var alertIntervalId = null;

  var alertInterval = function () {
    return setInterval(function () {
      // console.log("trigger loading");
      var card_content = $("[data-type='card-content']").data("clicked"); // check areas button clicked
      if ($('.card-content.d-show').length || $('.card-content.d-show:hover').length || card_content || $("#loadTop20:hover").length || $("[data-type='card-content']:hover").length || $("button#drawCategory:hover").length || $("#drawCategories:hover").length)
        return;

      var date_change = $("#datedash").val();
      var date_now = $("#date_now").val();
      var draw = $("#drawCategory").text();
      if (date_change == date_now) // live only on same date
      {
        // console.log("live: your_func every 10 second if tab is active");
        loadDashbord(date_change, draw);
      }

    }, 10000);
  };

  function handleVisibilityChange() {
    if (document.hidden) {
      clearInterval(alertIntervalId)
      alertIntervalId = null;
    } else {
      alertIntervalId = alertIntervalId || alertInterval();
    }
  }

  document.addEventListener("visibilitychange", handleVisibilityChange, false);
  handleVisibilityChange();

  // var draw = $("#drawCategory").text();
  // loadTop20(draw);
  const cardContent = document.getElementById('loadTop20');
  if (cardContent) {
    new PerfectScrollbar(cardContent, {
      wheelPropagation: false
    });
  }

  $("body").on("click", "#drawCategories a", function (e) {
    var draw = $(this).text();
    // console.log(draw);
    $("#drawCategory").text(draw);
    loadTop20(draw);
  });

  function loadTop20(draw) {
    var date_change = $("#datedash").val();

    $.ajax({
      url: '/api/gaming/loadTop20?date='+ date_change +'&draw=' + draw,
      type: "GET",
      // timeout: 10000,
      success: function (response) {
        // console.log(response);

        $("#loadTop20").html(response);
        
        const cardContent = document.getElementById('loadTop20');
        if (cardContent) {
          new PerfectScrollbar(cardContent, {
            wheelPropagation: false
          });
        }
      },
      error: function (response) {
        console.log(response)
      }
    });
  }

})();
