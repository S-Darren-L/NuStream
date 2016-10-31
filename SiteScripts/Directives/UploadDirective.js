angular.module('App').directive('upload', ['$timeout',function($timeout) {
  return {
    restrict: 'AE',
    scope:true,
    template: '<div class="Upload"  ng-click="onFileClick()" style="position:relative;overflow:hidden;height:5%;">'+
    			'<label style="position:absoluate;" ng-show="!hasImage">{{label}}</label>' +
    			'<img ng-show="hasImage" src="{{src}}" tag="" style="position: relative;width: 300%;height: 420%;top: -160%;left: -100%;"/> '+
    			'<input style="display:none;" name={{name}} type="file" accept="image/*;capture=camera" onchange="angular.element(this).scope().fileNameChanged()" />'+
    			'</div>',
    link: function(scope, element, attrs, controller, transcludeFn){
		scope.hasImage = false;
        scope.name = attrs.name;
        scope.label = attrs.label;
        scope.ableToClick = true;
		scope.src = attrs.src;
		if(!!scope.src && scope.src != "http://www.nustreamtoronto.com/"){
			scope.hasImage = true;
		}
    	scope.onFileClick = function(){

    		$timeout(function(){
                if(scope.ableToClick){
					scope.ableToClick = false;
					element.find('input')[0].click();
					scope.ableToClick = true;
                }
    		});
    	}
		// scope.$watch(element.find('img')[0].src, function(newVal,oldVal){
			// if(!!newVal && newVal != "http://www.nustreamtoronto.com/"){
				// scope.hasImage = true;
			// }
		// });
		
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