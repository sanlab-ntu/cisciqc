<?php
    session_start();
    //echo "Welcome back ".$_SESSION["email"]; 
    if(!isset($_SESSION['email'])){
        header('Location: ../login.html');
        die();
    }

    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>cisciqc</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.html">cisciqc</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item"> <!-- class="nav-link" -->
      <a href="../instructions.html" style='padding-right: 10px;color: rgba(255, 255, 255, .5);'>Instructions</a>
      <a href="functions/logout.php" style="color: rgba(255, 255, 255, .5);">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
      
    <main role="main" class="col-sm-12 col-md-10 offset-md-1">
                  <p>
        <?php
            include('functions/loadToRate.php'); 
        ?></p>
        <style>
            .mt-4, .my-4 {
                margin: 0 !important;
            }
        </style>
    </main>
  </div>
</div>
      <script src="../js/jquery-3.3.1.slim.min.js" ></script>
      <script src="../js/jquery-3.3.1.min.js" ></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-slim.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
      <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.4"></script>
      <script>
          var rating = "";
          var time1 = new Date();
          
          function updateScore(updateNote){
              rating = updateNote;
              console.log('something going one');
              if( document.getElementsByClassName('disabled').length > 0){
                  for(i = 0; i < 5; i++){
                      element = document.getElementsByClassName('disabled')[0];
                      element.className = element.className.replace(/.disabled/, "");  
                  }   
              }

            var time2 = new Date();

            Date.msBetween = function( date1, date2 ) {
              //Get 1 day in milliseconds
              var one_day=1000*60*60*24;

              // Convert both dates to milliseconds
              var date1_ms = date1.getTime();
              var date2_ms = date2.getTime();

              // Calculate the difference in milliseconds
              var difference_ms = date2_ms - date1_ms;

              // Convert back to days and return
              return Math.round(difference_ms); 
            }

            diff = Date.msBetween(time1, time2);
            jQuery.get('functions/updateScore.php', { fileID: signalID, score: rating, rt: diff }).done(function(data){
            location.reload();})
            }
          

          
      </script>
      <script >
      /* globals Chart:false, feather:false */

    (function () {
      'use strict'

      feather.replace()

      // Graphs
      var ctx = document.getElementById('myChart1')
      var labels = [];
      for (var i = 1; i <= 100; i++) {
            labels.push(i / 10);
        }
      
      // eslint-disable-next-line no-unused-vars
      if (ctx !== null) {
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            data: data1,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff',
            radius: 0
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false
          },
            plugins: {
	zoom: {
		// Container for pan options
		pan: {
			// Boolean to enable panning
			enabled: false,

			// Panning directions. Remove the appropriate direction to disable
			// Eg. 'y' would only allow panning in the y direction
			// A function that is called as the user is panning and returns the
			// available directions can also be used:
			//   mode: function({ chart }) {
			//     return 'xy';
			//   },
			mode: 'xy',

			rangeMin: {
				// Format of min pan range depends on scale type
				x: null,
				y: null
			},
			rangeMax: {
				// Format of max pan range depends on scale type
				x: null,
				y: null
			},

			// Function called while the user is panning
			onPan: function({chart}) { console.log(`I'm panning!!!`); },
			// Function called once panning is completed
			onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
		},

		// Container for zoom options
		zoom: {
			// Boolean to enable zooming
			enabled: true,

			// Enable drag-to-zoom behavior
			drag: true,

			// Drag-to-zoom effect can be customized
			// drag: {
			// 	 borderColor: 'rgba(225,225,225,0.3)'
			// 	 borderWidth: 5,
			// 	 backgroundColor: 'rgb(225,225,225)',
			//   animationDuration: 0
			// },

			// Zooming directions. Remove the appropriate direction to disable
			// Eg. 'y' would only allow zooming in the y direction
			// A function that is called as the user is zooming and returns the
			// available directions can also be used:
			//   mode: function({ chart }) {
			//     return 'xy';
			//   },
			mode: 'xy',

			rangeMin: {
				// Format of min zoom range depends on scale type
				x: null,
				y: null
			},
			rangeMax: {
				// Format of max zoom range depends on scale type
				x: null,
				y: null
			},

			// Speed of zoom via mouse wheel
			// (percentage of zoom on a wheel event)
			speed: 0.1,
		}
	}
}
        }
      })
      }
        
        $('#resetChart1').click(function(){
            myChart.resetZoom();
        });
    }())
          
      </script>
           <script >
      /* globals Chart:false, feather:false */

    (function () {
      'use strict'

      feather.replace()

      // Graphs
      var ctx = document.getElementById('myChart2')
      var labels = [];
      for (var i = 1; i <= 100; i++) {
            labels.push(i/10);
        }
      
      // eslint-disable-next-line no-unused-vars
      if (ctx !== null) {
      var myChart = new Chart(ctx, {
        type: 'line',

        data: {
          labels: labels,
          datasets: [{
            data: data2,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff',
            radius: 0
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false
          },
            plugins: {
	zoom: {
		// Container for pan options
		pan: {
			// Boolean to enable panning
			enabled: false,

			// Panning directions. Remove the appropriate direction to disable
			// Eg. 'y' would only allow panning in the y direction
			// A function that is called as the user is panning and returns the
			// available directions can also be used:
			//   mode: function({ chart }) {
			//     return 'xy';
			//   },
			mode: 'xy',

			rangeMin: {
				// Format of min pan range depends on scale type
				x: null,
				y: null
			},
			rangeMax: {
				// Format of max pan range depends on scale type
				x: null,
				y: null
			},

			// Function called while the user is panning
			onPan: function({chart}) { console.log(`I'm panning!!!`); },
			// Function called once panning is completed
			onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
		},

		// Container for zoom options
		zoom: {
			// Boolean to enable zooming
			enabled: true,

			// Enable drag-to-zoom behavior
			drag: true,

			// Drag-to-zoom effect can be customized
			// drag: {
			// 	 borderColor: 'rgba(225,225,225,0.3)'
			// 	 borderWidth: 5,
			// 	 backgroundColor: 'rgb(225,225,225)',
			//   animationDuration: 0
			// },

			// Zooming directions. Remove the appropriate direction to disable
			// Eg. 'y' would only allow zooming in the y direction
			// A function that is called as the user is zooming and returns the
			// available directions can also be used:
			//   mode: function({ chart }) {
			//     return 'xy';
			//   },
			mode: 'xy',

			rangeMin: {
				// Format of min zoom range depends on scale type
				x: null,
				y: null
			},
			rangeMax: {
				// Format of max zoom range depends on scale type
				x: null,
				y: null
			},

			// Speed of zoom via mouse wheel
			// (percentage of zoom on a wheel event)
			speed: 0.1,
		}
	}
}
        }
      })
      }
                
        $('#resetChart2').click(function(){
            myChart.resetZoom();
        });
    }())
      </script>
    </body>
</html>
