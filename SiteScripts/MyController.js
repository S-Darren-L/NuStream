myApp.controller('myController',['$scope',function($scope){

	$scope.vm = {};
	hideAll();
	$scope.vm.showStaging = true;
	$scope.vm.Label = 'STAGING';
	$scope.vm.FormClassName = "Staging";

	$scope.onStagingClick = function(){
		hideAll();
		$scope.vm.showStaging = true;
		$scope.vm.Label = 'STAGING';
		$scope.vm.FormClassName = "Staging";
	};

	$scope.onCleanupClick = function(){
		hideAll();
		$scope.vm.showCleanup = true;
		$scope.vm.Label = 'CLEAN UP';
		$scope.vm.FormClassName = "Cleanup";
	};
	$scope.onTouchupClick = function(){
		hideAll();
		$scope.vm.showTouchup = true;
		$scope.vm.Label = 'TOUCH UP';
		$scope.vm.FormClassName = "Touchup";
	};
	$scope.onYardWorkClick = function(){
		hideAll();
		$scope.vm.showYardWork = true;
		$scope.vm.Label = 'YARD WORK';
		$scope.vm.FormClassName = "YardWork";
	};
	$scope.onInspectionClick = function(){
		hideAll();
		$scope.vm.showInspection = true;
		$scope.vm.Label = 'INSPECTION';
		$scope.vm.FormClassName = "Inspection";
	};
	$scope.onStorageClick = function(){
		hideAll();
		$scope.vm.showStorageWork = true;
		$scope.vm.Label = 'STORAGE';
		$scope.vm.FormClassName = "Storage";
	};
	$scope.onRelocationClick = function(){
		hideAll();
		$scope.vm.showRelocation = true;
		$scope.vm.Label = 'RELOCATION';
		$scope.vm.FormClassName = "Relocation";
	};
$scope.onSaveClick = function(){
	var form = $('.'+ $scope.vm.FormClassName).find('.SubmitButton').click();
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