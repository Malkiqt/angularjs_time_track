app.controller('myController',function($scope,$http){

	//var time_pickers = getElementsByClassName('timepicker');

	//var my_timepicker = $timepicker(time_pickers, ngModelController);

	$scope.today = get_today();

	$scope.logged = true;

	$scope.username = 'Malkiq';
	$scope.current_id = 0;
	//$scope.current_day = '';
	$scope.selected_day = '15/02/2018';
	$scope.aspect_options = [];
	//$scope.selected_stat = '';

	$scope.days = [];


	$scope.activities = [];


	$scope.main_stats = ['work','leasure','family','social','sport'];


	$scope.stats = {
		'work' : {
			'length':'work222',
			'subtypes':{
				'subtype1':'first_subtype',
				'subtype2':'second_subtype',
				'subtype3':'third_subtype'
			}
		},
		'leasure' : {
			'length':'leasure',
			'subtypes':{
				'subtype1':'first_leasuresubtype',
				'subtype2':'second_leasuresubtype',
				'subtype3':'third_leasuresubtype'
			}
		},

	};
	






	$scope.load_stats = function(limit){
		
		var data = {
			'action' : 'load_stats' ,
			'username' : $scope.username ,
			'date' : $scope.selected_day,
			'limit' : limit
		};

		send_ajax(data,
			function success(response){


				var result_data = JSON.parse(response.data);
				$scope.stats = {
					'work' : {},
					'leasure' : {},
					'social' : {},
					'family' : {},
					'sport' : {}
				};

				var count = 0;
				for(var obj_name in result_data[0]){
					//$scope.stats[obj_name] = result_data[0][obj_name];
					for(var prop_name in result_data[0][obj_name]){
						$scope.stats[obj_name][prop_name] = result_data[0][obj_name][prop_name];														
					}
				}
				count++;

			},
			function error(error){
				alert('A problem Occured in the HTTP request');
				alert(error);
			}
		);
	}



	$scope.load_days = function(){
		
		var data = {
			'action' : 'load_days' ,
			'username' : $scope.username
		};

		send_ajax(data,
			function success(response){

				var stringified_data = JSON.stringify(response.data);
				var result_data = JSON.parse(stringified_data);

				var count = 0;
				$scope.activities = [];


				for(data of result_data){
					$scope.days.push(new Object);
					for(var prop_name in data){
						$scope.days[count][prop_name] = data[prop_name];
					}

					count++;
				}

			},
			function error(error){
				alert('A problem Occured in the HTTP request');
				alert(error);
			}
		);

	}









	$scope.load_activities = function(){
		

		var data = {
			'action' : 'load_activities' ,
			'username' : $scope.username ,
			'date' : $scope.selected_day
		};

		send_ajax(data,
			function success(response){

				var stringified_data = JSON.stringify(response.data);

				var result_data = JSON.parse(stringified_data);

				var count = 0;
				$scope.activities = [];


				for(data of result_data){
					$scope.activities.push(new Object);
					for(var prop_name in data){
						$scope.activities[count][prop_name] = data[prop_name];
					}
					count++;
				}

			},
			function error(error){
				alert('A problem Occured in the HTTP request');
				alert(error);
			}
		);
	}





	$scope.update_day = function(new_name){
		var data = {
			'action' : 'update_day' ,
			'id' : $scope.current_id ,
			'name' : new_name , 
		}

		
		send_ajax(data,
			function success(response){
				alert('Name Updated Created');

			},	
			function error(error){

				alert('A problem Occured');
			}
		);
	};

	$scope.update_activity = function(name,type,subtype,start_time,end_time,description){
		var data = {
			'action' : 'update_activity' ,
			'id' : $scope.current_id ,
			//'username' : $scope.username , 
			//'date' : $scope.current_day ,
			'name' : name,
			'type' : type,
			'subtype' : subtype,
			'start_time' : start_time,
			'end_time' : end_time,
			'description' : description
		};

		

		send_ajax(data,
			function success(response){
				var result_data = JSON.parse(response.data);
				if(result_data[0].result == 0){
					alert('Problem while making activity in PHP');
				}else{
					alert('Activity Updated');
				}
			},	
			function error(error){

				alert('A problem Occured');
			}
		);
	}; 


	$scope.delete_activity = function(this_id){

		$scope.current_id = this_id;

		var data = {
			'action' : 'delete_activity' ,
			'id' : this_id
		};

		send_ajax(data,
			function(response){
				alert('Activity Deleted');
				$scope.load_activities($scope.aspect);
			},
			function(error){
				alert(error);
				//alert('A problem occured');
			}
		);
	};


 	$scope.create_subtype = function(type,subtype){
		var data = {
			'action' : 'create_subtype' ,
			'username' : $scope.username , 
			'type' : type ,
			'subtype' : subtype
		};

		

		send_ajax(data,
			function success(response){
				var result_data = JSON.parse(response.data);
				if(result_data[0].result == 0){
					alert('Problem while making activity in PHP');
				}else{
					alert('Activity Created');
				}
			},	
			function error(error){

				alert('A problem Occured(error of ajax)');
			}
		);
	};

	$scope.create_activity = function(name,type,subtype,start_time,end_time,description){
		var data = {
			'action' : 'create_activity' ,
			'username' : $scope.username , 
			'date' : $scope.selected_day ,
			'name' : name,
			'type' : type,
			'subtype' : subtype,
			'start_time' : start_time,
			'end_time' : end_time,
			'description' : description
		};

		

		send_ajax(data,
			function success(response){
				var result_data = JSON.parse(response.data);
				if(result_data[0].result == 0){
					alert('Problem while making activity in PHP');
				}else{
					alert('Activity Created');
				}
			},	
			function error(error){
				alert(error);
				alert('A problem Occured(error of ajax)');
			}
		);
	};  


	$scope.create_day = function(name,date){
		var data = {
			'action' : 'create_day' ,
			'username' : $scope.username ,
			'name' : name ,
			'date' : $scope.today
		};

		

		send_ajax(data,
			function success(response){

				var result_data = JSON.parse(response.data);

				if(result_data[0].result == 0){


					alert('You already made a day today');
				}else{
					alert('Day Created');
				}
				

			},	
			function error(error){
				alert(error);
				//alert('A problem Occured');
			}
		);
	};





	$scope.login = function(username,password){
		var data = {
			'action' : 'login' ,
			'username' : username ,
			'password' : password
		};

		

		send_ajax(data,
			function success(response){

				var result_data = JSON.parse(response.data);

				if(result_data[0].result == 0){
					alert('Wrong Username or Password');
				}else{
					$scope.username = username;
					$scope.logged = true;
					$scope.load_days();
				}	

			},	
			function error(error){
				alert('A problem Occured In the PHP Function');
			}
		);
	};



	$scope.register = function(username,password,password_repeat){
		var data = {
			'action' : 'register' ,
			'username' : username ,
			'password' : password ,
			'password_repeat' : password_repeat
		};
		if(username && password && password_repeat){

			if(password===password_repeat){

				send_ajax({'action' : 'check','username' : username},
					function success(response){

						var result_data = JSON.parse(response.data);

						if(result_data[0].result == 0){
							alert('Username already exists');
						}else{
							send_ajax(data,
								function success(response){
									alert('Successfully Registered');
								},
								function error(error){
									alert('A problem Occured In the PHP Function(Register)');
									alert(error);
								}
							);
						}	
					},	
					function error(error){
						alert('A problem Occured In the PHP Function(Check)');
						alert(error);
					}
				);
			}else{
				alert('Password do not match');
			}
		
		}else{
			alert('Fill all Fields');
		}
	};



	$scope.logout = function(){
		$scope.logged = false;
	}




	function send_ajax(data,success_callback,error_callback){
		$http({
			method: 'POST',
			url: 'php/process.php',	
			data: data	
		}).then(function(response){
			success_callback(response);
		},function(error){
			error_callback(error);
		});	
	};



	$scope.set_id = function(this_id){
		$scope.current_id = this_id;
	}


	$scope.set_day = function(this_day){
		$scope.selected_day = this_day;
	}

	//$scope.set_stat = function(this_stat){
		//$scope.selected_stat = this_stat;
	//}

	function get_today(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd = '0'+dd
		} 

		if(mm<10) {
		    mm = '0'+mm
		} 

		today = dd + '/'  +  mm   + '/' + yyyy;

		return today;
	}















	$scope.load_days();

});