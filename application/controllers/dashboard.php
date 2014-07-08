<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function index(){
		$this->load->view("variables");
	}
	
	public function receiveInputs(){
		
		$initialTimeShift = $_GET["initialMinutes"];
		$endTimeShift = $_GET["Minutes"];
		$nValue = $_GET["nValue"];
		
		$data["initialTimeShift"] = $initialTimeShift;
		$data["nValue"] = $nValue;
		$data["endTimeShift"] = $endTimeShift;
		
		$this->load->view("variables", $data);
		
		$times1 = array();
		
		$this->load->model("views_model");
		
		$result = $this->views_model->getTTAvgCount($initialTimeShift,$endTimeShift);
		echo "Count of  travels (BT-001 -> BT-002) = ".$result[0]["travel_count"]."<br/>Normal average = ".$result[0]["travel_time"]."<br/>";
		$result1 = $this->views_model->getTTAvg($initialTimeShift,$endTimeShift,"BT-001");
		//echo "travel times (BT-001 -> BT-002): ";
		foreach($result1 as $time){
			//echo $time["travel_time"]." , ";
			array_push($times1,$time["travel_time"]);
		}
		echo "<br/> Simple Moving Average for travel times (BT-001 -> BT-002): <br/>";
		$this->calcAvg($times1,$nValue);
	}
	
	public function SMA($array,$step){
	$sma = 0;
	for ($i=0; $i< count($array);$i += $step){
		//echo "i = ".$i." <br/> ";
		$elements = " , { ";
		for($j = $i;$j< $i +$step; $j++){
			
				if(isset($array[$j])){
				//echo "j = ".$j." <br/> ";
				if(isset($array[$j - $step])){
					$sma = $sma -  (($array[$j - $step])/$step) + ($array[$j]/$step);
					$elements .= $array[$j]." }";
				}else{
					//echo $array[$j] ."<br/>";
					$sma = $sma + $array[$j]/$step;
					$elements .= $array[$j] . " , ";
				}
				if($j == $step - 1){
					echo "initial Average: ";
					echo "SMA = ".$sma . $elements." } "."<br/>";
					$elements = " , { ";
				}
				if($i>=$step){
					echo "SMA = ".$sma . $elements. "<br/>";
					$elements = " , { ";
				}
			}
		}
	}
	return $sma;
}


	public function calcAvg($data,$step){
		
		$avg = $this->draw($data,$step);
		//echo "average = ".$avg;
	}
	
	public function draw($array,$step)
	{
		$category = array();
		$category['name'] = 'num';
		
		$series1 = array();
		$series1['name'] = 'SimpleMovingAverage';
		$series2['name'] = 'TravleTimes';
		
		$sma = 0;
	for ($i=0; $i< count($array);$i += $step){
		for($j = $i;$j< $i +$step; $j++){
				
				if(isset($array[$j])){
					$series2['data'][] = $array[$j];
				$category['data'][] = $j+1;
				if(isset($array[$j - $step])){
					$sma = $sma -  (($array[$j - $step])/$step) + ($array[$j]/$step);
				}else{
					$sma = $sma + $array[$j]/$step;
					
				}
				if($j == $step - 1){
					for($k = 0;$k<$step; $k++){
						$series1['data'][] = $sma;
					}
				}
				if($i>=$step){
					$series1['data'][] = $sma;
				}
			}
		}
		
		
	}
	$result = array();
		array_push($result,$category);
		array_push($result,$series1);
		array_push($result,$series2);
		
		$data['chartData'] = $result;
		$this->load->view("chart",$data);
	
}
}
