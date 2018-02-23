<?php 

	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'angularjs_time_track';

	$conn = new mysqli($host,$user,$pass,$db);

	header('Content-Type: application/json');

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$action = $request->action;

	switch($action){


			case 'load_stats':
				$username = $request->username;
				$date = $request->date;
				$limit = $request->limit;
				//$query = "SELECT type,subtype,length FROM activity WHERE date='".$date."' AND username='".$username."' ORDER BY id DESC LIMIT ".$limit;
				//$query = "SELECT type,subtype,length FROM activity WHERE username='".$username."' ORDER BY id DESC LIMIT ".$limit;
				$query = "SELECT type,subtype,length FROM activity WHERE username='".$username."' ORDER BY id DESC";
				$result = $conn->query($query);

				$total_length = 0;

				$type_array = [];
				$subtype_array = [];

				if($result){
					while($row = $result->fetch_row()){
						$type = $row[0];
						$subtype = $row[1];
						$length = $row[2];
						$total_length += $length;
						if(!isset($type_array[$type])){
							$type_array[$type] = $length; ///Initialize Type			
						}else{
							$type_array[$type] += $length; ///Add Length to type
						}
						if(!isset($subtype_array[$type][$subtype])){
							$subtype_array[$type][$subtype] = $length; //Initialize Subtype					
						}else{
							$subtype_array[$type][$subtype] += $length; //Add Length to Subtype
						}

					}	

					$result = '';
					$result_subtypes = '';
					$type_count = 0;
					$total_type_count = count($type_array);
					//Foreach Type
					foreach($type_array as $this_type => $this_type_length){

						$result .= '"'.$this_type.'": {';
						$result .= '"length": "'.$this_type_length.'",';
						$result .= '"subtypes": {';

						$subtype_count = 0;
						$total_subtype_count = count((array)$subtype_array[$this_type]);

						foreach($subtype_array[$this_type] as $this_subtype => $this_subtype_length){
							
							$result .= '"'.$this_subtype.'" : "'.$this_subtype_length.'"';

							$subtype_count++;
							if($subtype_count<$total_subtype_count){
								$result .= ',';
							}					
						}

						$result .= 	"}";
						$result .= 	"}";

						$type_count++;
						if($type_count<$total_type_count){
							$result .= ',';
						}
			
					}
					//Add BRACKETS

					//$result = '{"work" : "100"}';
					echo json_encode('[{'.$result.'}]');
					//echo json_encode('[{"result" : "1"}]');
				}

				 
				break;









			case 'create_subtype':
				$username = $request->username;
				$type = $request->type;
				$subtype = $request->subtype;
				$query = "SELECT * FROM subtype WHERE username='".$username."' AND subtype='".$subtype."'";
				$result = $conn->query($query);

				if(!$result->num_rows){
					$query = "INSERT INTO subtype(username,type,subtype) VALUES('" .$username. "','". $type ."','". $subtype ."')";	
					$conn->query($query);				
					echo json_encode('[{"result" : "1"}]');
				}else{
					echo json_encode('[{"result" : "0"}]');
				}
				break;





			case 'load_days':


				$username = $request->username;
				//$date = $request->date;

				$query = "SELECT id,date,name FROM days 
				WHERE username='".$username."' ORDER BY id DESC";	

				$result = $conn->query($query);
				$count = 0;

				if($result){
					$result_rows = $result->num_rows;
		
					echo '[';
					while($row = $result->fetch_row()){
						echo '{"id":"'.$row[0].'","date":"'.$row[1].'","name":"'.$row[2].'"}';					
						$count ++;
						if($count<$result_rows){
							echo ',';
						}
					}
					echo ']';

				}
				break;






			case 'load_activities':

				$username = $request->username;
				$date = $request->date;

				$query = "SELECT id,name,start_time,end_time,length,type,subtype,description FROM activity 
				WHERE username='".$username."' AND date='".$date."' ORDER BY id DESC";	
				$result = $conn->query($query);
				$count = 0;

				if($result){
					$result_rows = $result->num_rows;
		
					echo '[';
					while($row = $result->fetch_row()){
						echo '{"id":"'.$row[0].'","name":"'.$row[1].'","start_time":"'.$row[2].'","end_time":"'.$row[3].'","length":"'.$row[4].'","type":"'.$row[5].'","subtype":"'.$row[6].'","description":"'.$row[7].'"}';					
						$count ++;
						if($count<$result_rows){
							echo ',';
						}
					}
					echo ']';
				}
				break;


			case 'update_day':
			
				$id = $request->id;

				$name = $request->name;



				$query = "UPDATE days SET name='".$name."' WHERE id='".$id."'";

				$result = $conn->query($query);

				if($result){

					echo json_encode('[{"result" : "1"}]');
				}else{

					echo json_encode('[{"result" : "0"}]');
				}

				break;


			case 'update_activity':
			
				$id = $request->id;

				$name = $request->name;
				$type = $request->type;
				$subtype = $request->subtype;
				$start_time = $request->start_time;
				$end_time = $request->end_time;
				$description = $request->description;


				$query = "UPDATE activity SET name='".$name."',type='".$type."',subtype='".$subtype."',start_time='".$start_time."',end_time='".$end_time."',
				description='".$description."', WHERE id='".$id."'";

				$result = $conn->query($query);

				if($result){

					echo json_encode('[{"result" : "1"}]');
				}else{

					echo json_encode('[{"result" : "0"}]');
				}

				break;


			case 'delete_activity':
				$id = $request->id;

				$query = "DELETE FROM activity WHERE id='".$id."'";

				$conn->query($query);

				break;


			case 'create_activity':


				$username = $request->username;

				$date = $request->date;
				$name = $request->name;
				$type = $request->type;
				$subtype = $request->subtype;
				$start_time = $request->start_time;
				$end_time = $request->end_time;
				$description = $request->description;

				$length = get_time_length($start_time,$end_time);


				$query = "INSERT INTO activity(username,date,name,start_time,end_time,length,type,subtype,description) 
				VALUES('".$username."','".$date."','".$name."','".$start_time."','".$end_time."','".$length."','".$type."','".$subtype."','".$description."')";


				$result = $conn->query($query);

				if($result){

					echo json_encode('[{"result" : "1"}]');
				}else{

					echo json_encode('[{"result" : "0"}]');
				}

				break;


			case 'create_day':
				$username = $request->username;
				$name = $request->name;
				$date = $request->date;
				$query = "SELECT * FROM days WHERE username='".$username."' AND date='".$date."'";
				$result = $conn->query($query);

				if(!$result->num_rows){
					$query = "INSERT INTO days(username,name,date) VALUES('" .$username. "','". $name ."','". $date ."')";	
					$conn->query($query);				
					echo json_encode('[{"result" : "1"}]');
				}else{
					echo json_encode('[{"result" : "0"}]');
				}
				break;	


			case 'login':
				$username = $request->username;
				$password = $request->password;

				$query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
				$result = $conn->query($query);

				if($result->num_rows){
					echo json_encode('[{"result" : "1"}]');
				}else{
					echo json_encode('[{"result" : "0"}]');
				}
				break;


			case 'register':

				$username = $request->username;
				$password = $request->password;

				$query = "INSERT INTO subtypes(username,work,leasure,social,family,sport) VALUES('".$username."','','','','','')";
				$conn->query($query);


				$query = "INSERT INTO users(username,password,admin) VALUES('" .$username. "','". $password ."','0')";	
				$result = $conn->query($query);	

				if($result){
					echo json_encode('[{"result" : "1"}]');
				}else{
					echo json_encode('[{"result" : "0"}]');
				}
				break;	
		
			case 'check':

				$username = $request->username;
				

				$query = "SELECT * FROM users WHERE username='".$username."'";
				$result = $conn->query($query);

				//if($result )
				if(!($result->num_rows)){
					echo json_encode('[{"result" : "1"}]');
				}else{
					echo json_encode('[{"result" : "0"}]');
				}
				break;	



			case 'logout':

				session_destroy();
				break;
	}





		



	function get_time_length($start_time,$end_time){
		$start_hour = intval(substr($start_time, 0, strpos($start_time, ":")));
		$end_hour = intval(substr($end_time, 0, strpos($end_time, ":")));

		$start_minutes = intval(substr($start_time, (strpos($start_time, ":")+1) , (strlen($start_time)-3)));
		$end_minutes = intval(substr($end_time, (strpos($end_time, ":")+1) , (strlen($end_time)-3)));

		if($end_hour<$start_hour){
			$end_hour += 24;
		}
		if($end_minutes<$start_minutes){
			$end_hour--;
			$end_minutes+=60;
		}
		$length = (($end_hour - $start_hour)*60 + ($end_minutes - $start_minutes));	

		return $length;
	}





?>