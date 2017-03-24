var app = angular.module("mainApp",[]);

app.controller("mainCtrl", function($scope) {
	$scope.server = {ip:"192.241.214.61"};
	$scope.team = [
		{port:"42069",name:"Rodolfo",server:"rho",office:"rodo"},
		{port:"42070",name:"Uriel",server:"uri",office:"uri"},
		{port:"42071",name:"JM",server:"jm",office:"jm"},
		{port:"42072",name:"Jorge",server:"jorge",office:"jorge"},
		{port:"42073",name:"Marco",server:"marco",office:"marco"},
		{port:"42074",name:"Ara",server:"ara",office:"ara"}
	];
	$scope.member = $scope.team[0];
});
