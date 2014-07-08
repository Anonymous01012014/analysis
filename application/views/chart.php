
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.10.2.js"></script>
		<script src="<?php echo base_url();?>js/highcharts.js"></script>
		<script type="text/javascript">
			$(function () {
		$('#container').highcharts({
	            chart: {
	                renderTo: 'container',
	                type: 'line',
	                marginRight: 130,
	                marginBottom: 25,
	                zoomType: 'x'
	            },
	            title: {
	                text: 'Project Requests',
	                x: -20 //center
	            },
	            subtitle: {
	                text: '',
	                x: -20
	            },
	            xAxis: {
					title: {
	                    text: 'Number'
	                },
	                categories: [
	                <?php
						echo "{name: '".$chartData[0]['name']."',";
										 echo "  data: [";
									for($j=0;$j<count($chartData[0]['data']) - 1;$j++){
										echo (float)$chartData[0]['data'][$j].",";
									}
									echo (float)$chartData[0]['data'][count($chartData[0]['data']) - 1].",";
									echo ']},';	
	                ?>
	                ]
	            },
	            yAxis: {
	                title: {
	                    text: 'Time(in seconds)'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                formatter: function() {
	                        return '<b>'+ this.series.name +'</b><br/>'+
	                        this.x +': '+ this.y + 'secs';
	                }
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'top',
	                x: -10,
	                y: 100,
	                borderWidth: 0
	            },
	            
	            series: [
					<?php
									echo "{name: '".$chartData[1]['name']."',";
										 echo "  data: [";
									for($j=0;$j<count($chartData[1]['data']) - 1;$j++){
										echo (float)$chartData[1]['data'][$j].",";
									}
									echo (float)$chartData[1]['data'][count($chartData[1]['data']) - 1].",";
									echo ']},';	
									echo "{name: '".$chartData[2]['name']."',";
										 echo "  data: [";
									for($j=0;$j<count($chartData[2]['data']) - 1;$j++){
										echo (float)$chartData[2]['data'][$j].",";
									}
									echo (float)$chartData[2]['data'][count($chartData[2]['data']) - 1].",";
									echo ']}';	
								
						?>
	            ]        
	        
	    });
	});
		</script>
	    
	
		<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	
