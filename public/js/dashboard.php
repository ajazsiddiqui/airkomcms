<?php 

function thousandsCurrencyFormat($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}

?>

(function($) {
    /* "use strict" */

 var dzChartlist = function(){
	let draw = Chart.controllers.line.__super__.draw; //draw shadow
	var screenWidth = $(window).width();
	var pieChart = function(){
		 var options = {
          series: [<?= $_GET['Early'] ?>, <?= $_GET['Active'] ?>, <?= $_GET['Close'] ?>, <?= $_GET['Offline'] ?>],
          chart: {
          type: 'donut',
		  
        },
		dataLabels: {
          enabled: false
        },
		stroke: {
          width: 0,
        },
		colors:['#1EAAE7', '#FF7A30', '#2BC155', '#FF2E2E'],
		legend: {
              position: 'bottom',
			  show:false
            },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom',
			  show:false
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#pieChart"), options);
        chart.render();
    
	}
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				pieChart();
			},
			
			resize:function(){
				
			}
		}
	
	}();

	jQuery(document).ready(function(){
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     

})(jQuery);



(function($) {
    /* "use strict" */

 
		
	function nFormatter(num, digits) {
	  var si = [
		{ value: 1E18, symbol: "E" },
		{ value: 1E15, symbol: "P" },
		{ value: 1E12, symbol: "T" },
		{ value: 1E9,  symbol: "G" },
		{ value: 1E6,  symbol: "M" },
		{ value: 1E3,  symbol: "k" }
	  ], i;
	  for (i = 0; i < si.length; i++) {
		if (num >= si[i].value) {
		  return (num / si[i].value).toFixed(digits).replace(/\.?0+$/, "") + si[i].symbol;
		}
	  }
	  return num;
	}
		
 var fbvchartdraw = function(){
	let draw = Chart.controllers.line.__super__.draw; //draw shadow
	var screenWidth = $(window).width();
	var fbvchart = function(){
		var options = {
          series: [{
          data: [<?= isset($_GET['f_Early'])?$_GET['f_Early']:0 ?>, <?= isset($_GET['f_Active'])?$_GET['f_Active']:0 ?>, <?= isset($_GET['f_Close'])?$_GET['f_Close']:0 ?>, <?= isset($_GET['f_Offline'])?$_GET['f_Offline']:0 ?>]
        }],
          chart: {
          height: 150,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: ['#1EAAE7', '#FF7A30', '#2BC155', '#FF2E2E'],
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false,
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: ['Early','Active','Close','Offline'],
          labels: {
            style: {
              colors: ['#1EAAE7', '#FF7A30', '#2BC155', '#FF2E2E'],
              fontSize: '12px'
            }
          }
        },
		yaxis: {
		  labels: {
			formatter: function (value) {
			  return nFormatter(value);
			}
		  },
		},

        };

        var chart = new ApexCharts(document.querySelector("#fbvchart"), options);
        chart.render();
    
	}
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				fbvchart();
			},
			
			resize:function(){
				
			}
		}
	
	}();

	jQuery(document).ready(function(){
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			fbvchartdraw.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     

})(jQuery);

