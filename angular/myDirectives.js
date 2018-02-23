app.directive('timepicker',function(){
	return{
		restrict : 'EC',
	    scope: false,
	    templateUrl: './directives/timepicker.html'
	}
});


app.directive('day',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/day.html'
	}
});


app.directive('activity',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/activity.html'
	}
});


app.directive('modalCreateActivity',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/create_activity.html'
	}
});


app.directive('modalCreateSubtype',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/create_subtype.html'
	}
});


app.directive('modalUpdateActivity',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/update_activity.html'
	}
});

app.directive('modalUpdateDay',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/update_day.html'
	}
});