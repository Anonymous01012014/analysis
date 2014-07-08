<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

/**
 * Class name : Views_model
 * 
 * Description :
 * This class contains functions to deal with the vies in the database
 * 
 * Created date : 05-05-2014
 * Modification date : ---
 * Modfication reason : ---
 * Author : Ahmad Mulhem Barakat
 * contact : molham225@gmail.com
 */    

class Views_model extends CI_Model{
	/** views class variables **/
	
	/**
     * Constructor
     **/	
	function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Class functions
	 **/
    
    /**
	 * function name : getSegmentTravelTimes
	 * 
	 * Description : 
	 * gets the travel times of the segments of the highway specified by the given id.
	 * 
	 * parameters:
	 * highway_id: the id of the highway for these segments.	
	 * 
	 * Created date :  05-05-2014
	 * Modification date : ---
	 * Modfication reason : ---
	 * Author : Ahmad Mulhem Barakat
	 * contact : molham225@gmail.com
	 */
	 public function getSegmentTravelTimes($highway_id){
		$query = "SELECT * 
					FROM segment_travel_time
					WHERE highway_id = {$highway_id};";
		$result = $this->db->query($query);
		return $result->result_array();
	 }
    /**
	 * function name : getTTAvgCount
	 * 
	 * Description : 
	 * gets the travel times of the segments of the highway specified by the given id.
	 * 
	 * parameters:
	 * highway_id: the id of the highway for these segments.	
	 * 
	 * Created date :  05-05-2014
	 * Modification date : ---
	 * Modfication reason : ---
	 * Author : Ahmad Mulhem Barakat
	 * contact : molham225@gmail.com
	 */
	 public function getTTAvgCount($initialTimeShift,$endTimeShift){
		 $startHours = 7;
		 $initialTimeShift += 31;
		 if($initialTimeShift > 59){
			$startHours += floor($initialTimeShift/60);
			$initialTimeShift = $initialTimeShift % 60;
		 }
		 echo "From ".$startHours." : ".$initialTimeShift." To ";
		 
		 $endHours =  $startHours;
		 $endTimeShift += $initialTimeShift;
		  //echo "end time = ".$endTimeShift."<br/>".floor($endTimeShift/60)."<br/>".($endTimeShift % 60)."<br/>";
		 if($endTimeShift > 59){
			$endHours += floor($endTimeShift/60);
			$endTimeShift = $endTimeShift % 60;
		 }
		 echo $endHours." : ".$endTimeShift."<br />";
 		$query = "SELECT        AVG(dbo.travel.travel_time) AS travel_time, COUNT(dbo.travel.travel_time) AS travel_count, [from].station_id
					FROM            dbo.travel INNER JOIN
											 dbo.passing AS pass_from ON dbo.travel.passing_from = pass_from.id INNER JOIN
											 dbo.station AS [from] ON pass_from.station_id = [from].id INNER JOIN
											 dbo.highway ON [from].highway_id = dbo.highway.id INNER JOIN
											 dbo.passing AS pass_to ON dbo.travel.passing_to = pass_to.id INNER JOIN
											 dbo.station AS [to] ON pass_to.station_id = [to].id AND dbo.highway.id = [to].highway_id AND [from].highway_id = [to].highway_id INNER JOIN
											 dbo.neighbor ON [from].id = dbo.neighbor.station_id AND [to].id = dbo.neighbor.neighbor_id
					WHERE        (dbo.travel.is_valid = 1) AND (dbo.travel.is_valid = 1) AND ( pass_from.passing_time >= '2014-06-27 ".$startHours.":".$initialTimeShift.":24.000' AND pass_to.passing_time <= '2014-06-27 ".$endHours.":".$endTimeShift.":24.000')
					group by [from].station_id";
		$result = $this->db->query($query);
		return $result->result_array();
	 }
    /**
	 * function name : getTTAvg
	 * 
	 * Description : 
	 * gets the travel times of the segments of the highway specified by the given id.
	 * 
	 * parameters:
	 * highway_id: the id of the highway for these segments.	
	 * 
	 * Created date :  05-05-2014
	 * Modification date : ---
	 * Modfication reason : ---
	 * Author : Ahmad Mulhem Barakat
	 * contact : molham225@gmail.com
	 */
	 public function getTTAvg($initialTimeShift,$endTimeShift,$station){
		 $startHours = 7;
		 $initialTimeShift += 31;
		 if($initialTimeShift > 59){
			$startHours += floor($initialTimeShift/60);
			$initialTimeShift = $initialTimeShift % 60;
		 }
		 //echo $startHours." : ".$initialTimeShift."<br />";
		 
		 $endHours =  $startHours;
		 $endTimeShift += $initialTimeShift;
		
		 if($endTimeShift > 59){
			$endHours += floor($endTimeShift/60);
			$endTimeShift = $endTimeShift % 60;
		 }
		 //echo $endHours." : ".$endTimeShift."<br />";
 		$query = "SELECT        dbo.travel.travel_time AS travel_time
					FROM            dbo.travel INNER JOIN
											 dbo.passing AS pass_from ON dbo.travel.passing_from = pass_from.id INNER JOIN
											 dbo.station AS [from] ON pass_from.station_id = [from].id INNER JOIN
											 dbo.highway ON [from].highway_id = dbo.highway.id INNER JOIN
											 dbo.passing AS pass_to ON dbo.travel.passing_to = pass_to.id INNER JOIN
											 dbo.station AS [to] ON pass_to.station_id = [to].id AND dbo.highway.id = [to].highway_id AND [from].highway_id = [to].highway_id INNER JOIN
											 dbo.neighbor ON [from].id = dbo.neighbor.station_id AND [to].id = dbo.neighbor.neighbor_id
					WHERE        (dbo.travel.is_valid = 1) AND (dbo.travel.is_valid = 1) AND ( pass_from.passing_time >= '2014-06-27 ".$startHours.":".$initialTimeShift.":24.000' AND pass_to.passing_time <= '2014-06-27 ".$endHours.":".$endTimeShift.":24.000') AND [from].station_id like '".$station."'
					ORDER BY dbo.travel.id";
		$result = $this->db->query($query);
		return $result->result_array();
	 }
	 
}
