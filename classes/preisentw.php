<?php
echo "<html>";
echo "<head>";
echo "    <title>Stepped Line Chart</title>";
echo "    <script src='../includes/chartjs/dist/Chart.bundle.js'></script>";
echo "    <script src='../includes/chartjs/utils.js'></script>";
echo "	<style>";
echo "	canvas {";
echo "		-moz-user-select: none;";
echo "		-webkit-user-select: none;";
echo "		-ms-user-select: none;";
echo "	}";
echo "	.chart-container {";
echo "		width: 500px;";
echo "		margin-left: 20px;";
echo "		margin-right: 40px;";
echo "		margin-bottom: 40px;";
echo "  }";
echo "	.container {";
echo "		display: flex;";
echo "		flex-direction: row;";
echo "		flex-wrap: wrap;";
echo "		justify-content: left;";
echo "	}";
echo "	</style>";
echo "</head>";

echo "<body>";
echo "<a href='showtab.php?menu=shopping' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
echo "	<div class='container'>";
echo "	</div>";
echo "    <canvas id='myChart1' height='300' width='500'></canvas>";	
	
$arrwert = array(0.49,0.39,0.52,0.48,0.50);
$cntwert = count($arrwert);
$arrbez = array("01.06.2016", "05.07.2016", "02.06.2017", "04.07.2017","08.07.2017");
$cntbez = count($arrbez);
	
echo "    <script>";

echo "	function createConfig(details, vdata) {";
echo "		return {";
echo "			type: 'line',";
echo "			data: {";
echo "				labels: [";
for ($i = 0; $i < $cntbez; $i++) {
  echo "'".$arrbez[$i]."',";
}  
echo "              ],";
echo "				datasets: [{";
echo "				    label: 'Apfelmus (Aldi)',";
echo "					steppedLine: details.steppedLine,";
echo "					data: vdata,";
echo "					borderColor: details.color,";
echo "					fill: false";
echo "				}]";
echo "			},";
echo "			options: {";
echo "				responsive: true,";
echo "				title: {";
echo "					display: true,";
echo "					text: details.label";
echo "				},";
echo "                showAllTooltips: true,";

echo "    tooltips: {";
echo "      callbacks: {";
echo "        title: function(tooltipItem, data) {";
//echo "            return data.labels[tooltipItem[0].index]; ";
echo "            return ''; ";
echo "          },";
echo "        label: function(tooltipItem, data) {";
echo "            let wert=vdata[tooltipItem.index];"; 
echo "            return wert;";
echo "          }";
echo "        }";
echo "      },";

echo "                    scales: {";
echo "                        yAxes: [{";
echo "                            ticks: {";
echo "                                beginAtZero:true,";
echo "                                max: 0.6,";
echo "								  min: 0";
echo "                            }";
echo "                        }]";
echo "                    }";
echo "			}";
			
echo "		};";
echo "	}";


echo "	window.onload = function() {";
echo "		var container = document.querySelector('.container');";

echo "		var data = [";
for ($i = 0; $i < $cntwert; $i++) {
  echo $arrwert[$i].",";
}  
echo "		];";

echo "		var steppedLineSettings = [{";
echo "			steppedLine: true,";
echo "			label: 'Preisentwicklung',";
echo "			color: window.chartColors.purple";
echo "		}];";

echo "		steppedLineSettings.forEach(function(details) {";
echo "			var div = document.createElement('div');";
echo "			div.classList.add('chart-container');";

echo "			var canvas = document.createElement('canvas');";
echo "			div.appendChild(canvas);";
echo "			container.appendChild(div);";

echo "			var ctx = canvas.getContext('2d');";
echo "			var config = createConfig(details, data);";

?>
		Chart.pluginService.register({
			beforeRender: function (chart) {
				if (chart.config.options.showAllTooltips) {
					chart.pluginTooltips = [];
					chart.config.data.datasets.forEach(function (dataset, i) {
						chart.getDatasetMeta(i).data.forEach(function (sector, j) {
							chart.pluginTooltips.push(new Chart.Tooltip({
								_chart: chart.chart,
								_chartInstance: chart,
								_data: chart.data,
								_options: chart.options.tooltips,
								_active: [sector]
							}, chart));
						});
					});

					chart.options.tooltips.enabled = false;
				}
			},
			afterDraw: function (chart, easing) {
				if (chart.config.options.showAllTooltips) {
					if (!chart.allTooltipsOnce) {
						if (easing !== 1)
							return;
						chart.allTooltipsOnce = true;
					}

					chart.options.tooltips.enabled = true;
					Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
						tooltip.initialize();
						tooltip.update();
						tooltip.pivot();
						tooltip.transition(easing).draw();
					});
					chart.options.tooltips.enabled = false;
				}
			}
		})

<?php		
echo "			new Chart(ctx, config);";
echo "		});";
	
echo "	};";
	
echo "    </script>";
	
echo "</body>";
echo "</html>";
?>