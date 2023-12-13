var app = angular.module('customerApp', ['datatables']);
var host = window.location.host;
var path = window.location.pathname.split('/index.php');
//str_replace()
//alert(path)
app.controller('customerController', function($scope, $http){
	$http.get("http://"+host+"/portefeuille-client/composant/com_extraction/controlerExtraction.php?task=getAllExtraction").success(function(data, status, headers, config){
		$scope.extractions = data;
	});
});