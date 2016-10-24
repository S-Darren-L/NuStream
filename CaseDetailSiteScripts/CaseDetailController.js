myApp.controller('CaseDetailController',['$scope',function($scope){

	$scope.vm = {};
	hideAll();
	$scope.vm.showStaging = true;
	$scope.vm.Label = 'STAGING';


	$scope.onStagingClick = function(){
		hideAll();
		$scope.vm.showStaging = true;
		$scope.vm.Label = 'STAGING';
	};

	$scope.onCleanupClick = function(){
		hideAll();
		$scope.vm.showCleanup = true;
		$scope.vm.Label = 'CLEAN UP';
	};
	$scope.onTouchupClick = function(){
		hideAll();
		$scope.vm.showTouchup = true;
		$scope.vm.Label = 'TOUCH UP';
	};
	$scope.onYardWorkClick = function(){
		hideAll();
		$scope.vm.showYardWork = true;
		$scope.vm.Label = 'YARD WORK';
	};
	$scope.onInspectionClick = function(){
		hideAll();
		$scope.vm.showInspection = true;
		$scope.vm.Label = 'INSPECTION';
	};
	$scope.onStorageClick = function(){
		hideAll();
		$scope.vm.showStorageWork = true;
		$scope.vm.Label = 'STORAGE';
	};
	$scope.onRelocationClick = function(){
		hideAll();
		$scope.vm.showRelocation = true;
		$scope.vm.Label = 'RELOCATION';
	};
	function hideAll(){

		$scope.vm.showStaging = false;
		$scope.vm.showCleanup = false;
		$scope.vm.showTouchup = false;
		$scope.vm.showYardWork = false;
		$scope.vm.showInspection = false;
		$scope.vm.showStorageWork = false;
		$scope.vm.showRelocation = false;
	};


}]);