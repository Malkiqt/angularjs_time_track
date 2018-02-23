<?php 


		

	
	$subtype_array['type']['subtype1'] = '1';
	$subtype_array['type']['subtype2'] = '2';
	$subtype_array['type']['subtype3'] = '3'; 
	$subtype_array['type']['subtype4'] = '4';



	foreach($subtype_array['type'] as $key => $value){
		echo $key.' - '.$value;
	}




















	/*header('Content-Type: application/json');

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$action = $request->action;

	$array['work'] = 'sm_data';
	$array['sport'] = 'sport_data';
	$array['social'] = 'sm_data';
	$array['family'] = 'sport_data';

	$newobj = new stdClass();
	$newobj->work = 'work_data';
	$newobj->sports = 'sportsdata';
	$newobj->family = 'familydata';
	$newobj->social = 'socialdata';

	foreach ($newobj as $key => $value) {
	    echo "$key  $value\n";
	}*/












	/*
	//$request = new stdClass();
	$array = ['work','sports','family','social'];
	$request['work'] = 'work_data';
	$request['sports'] = 'sportsdata';
	$request['family'] = 'familydata';
	$request['social'] = 'socialdata';
	
	$array = ['work','sports','family','social'];
	$request[$array[0]] = 'work_data';
	$request[$array[1]] = 'sportsdata';
	$request[$array[2]] = 'familydata';
	$request[$array[3]] = 'socialdata';



	$query_keys = '';
	$query_values = '';
	$count = 0;
	$total_count = count((array)$request);

	foreach($request as $key => $value){
		$query_keys .= $key;
		$query_values .= "'".$value."'";
		$count++;
		if($count<$total_count){
			$query_keys .= ',';
			$query_values .= ',';				
		}		
	}

	$query = "INSERT INTO subtype(".$query_keys.") VALUES(".$query_values.")";

	echo $query;  //INSERT INTO subtype(work,sports,family,social) VALUES('work_data','sportsdata','familydata','socialdata')	 
	*/
?>