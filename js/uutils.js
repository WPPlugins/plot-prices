window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(231,233,237)'
};

window.randomScalingFactor = function() {
	return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
}

jQuery(document).ready( function($) {
         var regtext=$('#reg').val();
          var saletext=$('#sale').val();
          var titlechart=$('#title-chart').val();
          var pole=$('#pole').val();
          var ti=$('#title-pro').val();
          var dates=$('#dates-product').val();
          var regularprice=$('#regular-price').val();
          regularprice=regularprice.split(',');
          var saleprice=$('#sale-price').val();
          saleprice=saleprice.split(',');
          var dates=$('#dates-product').val();
          dates=dates.split(',');
 var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var config = {
            type: 'line',
            data: {
                labels:dates,
                datasets: [{
                    label: regtext,
                    data:regularprice,
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    fill: false,
                    borderDash: [5, 5],
                    pointRadius: 15,
                    pointHoverRadius: 10,
                }, {
                    label: saletext,
                    data:saleprice,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    fill: false,
                    borderDash: [5, 5],
                    pointRadius: [2, 4, 6, 18, 0, 12, 20],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '$(price)'
                        }
                    }]
                },
                title: {
                    display: true,
                    text: titlechart+"        "+ti
                }
            }
        };



        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };

               $('#showchart').click(function(){
                        $(".remodal").remodal().open();
                         $("#Bargraph").SimpleChart(
                            'ChartType', "StackedHybrid");
                          $("#Bargraph").SimpleChart('reload', 'true');
                      });


  });//end jquery