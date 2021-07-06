var windowLoadAjax = {

  initA: function ()
  {
    //G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': 30
    };


    var jsonDataOrder = $.ajax( {
      url: BASE_URL + '/getHighcartUsersAddedMonthly',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;

    var colors = [];
    colors[ 0 ] = '#16426b';
    colors[ 1 ] = '#C70039';

    //ajax call
    //containerTotalOrderMonthly
    Highcharts.chart( 'containerUserData', {
      chart: {
        type: 'column',
        options3d: {
          enabled: false,
          alpha: 10,
          beta: 25,
          depth: 10
        }
      },
      title: {
        text: 'Monthly Users Graph'
      },
      colors: colors,
      subtitle: {
        text: '==========================================='
      },
      plotOptions: {
        column: {
          depth: 25
        },

      },
      xAxis: {
        categories: jsonDataOrder.MonthName,
        labels: {
          skew3d: false,
          style: {
            fontSize: '16px'
          }
        }
      },
      yAxis: {
        title: {
          text: null,
          color: '#16426B'
        }
      },
      series: [ {
        name: 'month wise',
        data: jsonDataOrder.monthlyValue
      } ]
    } );

    //containerTotalOrderMonthly



    //G1.=============================


  },
  initB: function ()
  {
    //G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': 30
    };


    var jsonDataOrder = $.ajax( {
      url: BASE_URL + '/getHighcartUsersAddedMonthly',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;

    var colors = [];
    colors[ 0 ] = '#16426b';
    colors[ 1 ] = '#C70039';

    //ajax call
    //containerTotalOrderMonthly
    Highcharts.chart( 'containerSchoolPerformanceData', {
      chart: {
        type: 'column',
        options3d: {
          enabled: false,
          alpha: 10,
          beta: 25,
          depth: 10
        }
      },
      title: {
        text: 'Monthly School Performance Graph'
      },
      colors: colors,
      subtitle: {
        text: '==========================================='
      },
      plotOptions: {
        column: {
          depth: 25
        },

      },
      xAxis: {
        categories: jsonDataOrder.MonthName,
        labels: {
          skew3d: false,
          style: {
            fontSize: '16px'
          }
        }
      },
      yAxis: {
        title: {
          text: null,
          color: '#16426B'
        }
      },
      series: [ {
        name: 'month wise',
        data: jsonDataOrder.monthlyValue
      } ]
    } );

    //containerTotalOrderMonthly



    //G1.=============================


  },
  initC: function ()
  {
    Highcharts.chart('containerUserA', {
      chart: {
          type: 'line'
      },
      title: {
          text: 'Monthly User Line Grapgh'
      },
      subtitle: {
          text: 'ZELOS'
      },
      xAxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      yAxis: {
          title: {
              text: 'NO'
          }
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: false
          }
      },
      series: [{
          name: 'Weekly',
          data: [7, 6, 9, 14, 18, 21, 25, 26, 23, 18, 13, 9]
      }, {
          name: 'Monthly',
          data: [3, 4, 5, 8, 11, 15, 17, 16, 14, 10, 6, 4]
      },
      {
        name: 'Yearly',
        data: [3, 4, 5, 8, 2, 14, 17, 16, 14, 10, 6, 19]
    }
    ]
  });

  },

}




jQuery( document ).ready( function ()
{
  windowLoadAjax.initA();
  windowLoadAjax.initB();
  windowLoadAjax.initC();






} );














