angular.module('App').directive('upload', ['$timeout',function($timeout) {
  return {
    restrict: 'AE',
    scope:true,
    template: '<div class="Upload"  ng-click="onFileClick()">'+
    			'<label style="position:absoluate;">{{label}}<label>' +
    			'<img src=""/> '+
    			'<input style="display:none;" name={{name}} type="file" accept="image/*;capture=camera" onchange="angular.element(this).scope().fileNameChanged()" />'+
    			'</div>',
    link: function(scope, element, attrs, controller, transcludeFn){
        scope.name = attrs.name;
        scope.label = attrs.label;
        scope.ableToClick = true;
    	scope.onFileClick = function(){
    		$timeout(function(){
                if(scope.ableToClick){
    			 element.find('input')[0].click();
                 scope.ableToClick = false;
                }
    		});
    	}

		scope.fileNameChanged=function($event)
		{
            scope.ableToClick = true;
		    var fr = new FileReader();

		    fr.readAsDataURL(event.target.files[0]);

		    fr.onload = function (e) { 
				element.find('div').css('background-image','url("'+this.result+'")');
				element.find('div').css('background-repeat','round');
                element.find('div').css('background-size','cover');
			};
		}
    }
  };
}]);