<html>

<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">





	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
	<!--<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>-->
	<!--Moment Picker/Time Picker

	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.js"></script>
	<script src="vendor/angular-moment-picker/angular-moment-picker.min.js"></script>
	<link href="vendor/angular-moment-picker/angular-moment-picker.min.css" rel="stylesheet">-->

	<script type='text/javascript' src='angular/myApp.js'></script>
	<script type='text/javascript' src='angular/myController.js'></script>
	<script type='text/javascript' src='angular/myDirectives.js'></script>
</head>















<body>
	<div ng-app='myApp' ng-controller='myController'>







		<div ng-show='logged' id='logged'>




	
			

			<div id='wrapper' class='col-md-10 col-md-push-1 col-xs-12'>




		<!--     !!!!!!!!!!!!!!!!!!!!!!      DAYS     !!!!!!!!!!!!!!!!!!!!   -->
				<div id='days_container' class='col-md-3 col-xs-12'>

					<div class='header' class='col-xs-12'>

						

						<span>{{today}}</span>
						<form ng-submit='create_day(create_day_name)'>
							

							<input type='text' placeholder='day name' ng-model='create_day_name'>

							<input type='submit' value='Create Day'>
						</form>
					</div>

					<div class='days' class='col-xs-12'>
						<form>
							<input type='text' placeholder='Search Day'>
							<input type='submit' value='Find Day'>
						</form>
						<div id='day_list'>
							<div ng-repeat='day in days'>
								<day></day>
							</div>
						</div>

					</div>

				</div>



		<!--     !!!!!!!!!!!!!!!!!!!!!!      ACTIVITIES     !!!!!!!!!!!!!!!!!!!!   -->
				<div id='activities_container' class='col-md-7 col-xs-12'>
					<div class='header' class='col-xs-12'>

						<div class='col-md-8 col-xs-12'>
							<button id='create_activity' data-toggle="modal" data-target="#create_activity_modal">Create Activity</button>
						</div>

						<div class='col-md-4 col-xs-12'>
							<button id='create_subtype' data-toggle="modal" data-target="#create_subtype_modal">Create SubType</button>
						</div>

					</div>

					<div class='activities' class='col-xs-12'>

						<span>{{selected_day}}</span>
						<div id='activity_list'>
							<div ng-repeat='activity in activities'>
								<activity></activity>
							</div>
						</div>
						
					</div>
				</div>



		<!--     !!!!!!!!!!!!!!!!!!!!!!      STATS     !!!!!!!!!!!!!!!!!!!!   -->
				<div id='stats_container' class='col-md-2 col-xs-12'>

					<div class='header' class='col-xs-12'>
						<form ng-submit='load_stats(1)'>
							<select>
								<option selected>Total</option>
								<option>Last Month</option>
								<option>Last Week</option>
								<option>Selected Day</option>
							</select>
							<input type='submit' value='Load Stats'>
						</form>
					</div>



					<div id='stats'>
						<div ng-repeat='(key, value) in stats'>
							<h4>{{ key }}</h4>
							<h4 class='show_subtypes'>{{ key.length }}%</h4>

							<div ng-repeat='(sub_key, sub_value) in value.subtypes'>
								<span >{{ sub_key }}  {{ sub_value }}</span>
								<br>
							</div>

						</div>
					<!--<div ng-repeat='(key, value) in stats'>
							<h4>{{ key }}</h4>
							<h4 class='show_subtypes'>{{ key.length }}%</h4>

							<div ng-repeat='(sub_key, sub_value) in value.subtypes'>
								<span >{{ sub_key }}  {{ sub_value }}</span>
								<br>
							</div>

							<select ng-model='stats_limit'> 
								<option value='1'>1</option>
							</select>

						</div>-->
						
					</div>
				</div>


			</div>



			<div id='logout_container' class='col-md-1 col-md-push-1 col-xs-12'>
				<button id='logout' ng-click='logout()'>Logout</button>
			</div>





		</div>


















		<div ng-show='!logged' class='col-xs-12'>


				<div id='login_container' class='col-md-6 col-xs-12'>
					<h3>Login</h3>
					<form  ng-submit='login(login.username,login.password)'>
						<input type='text' ng-model='login.username' placeholder='Username'><br> 
						<input type='password' ng-model='login.password' placeholder='Password'><br>
						<input type='submit' value='submit'>
					</form>				
				</div>


				<div id='register_container' class='col-md-6 col-xs-12'>
					<h3>Register</h3>
					<form  ng-submit='register(register.username,register.password,register.repeat_password)'>
						<input type='text' ng-model='register.username' placeholder='Username'><br>
						<input type='password' ng-model='register.password' placeholder='Password'><br>
						<input type='password' ng-model='register.repeat_password' placeholder='Reapeat Password'><br>
						<input type='submit' value='submit'>
					</form>				
				</div>			
		</div>


		<modal:create:subtype></modal:create:subtype>
		<modal:create:activity></modal:create:acitivity>
		<modal:update:activity></modal:update:activity>
		<modal:update:day></modal:update:day>

	</div>

</body>
</html>