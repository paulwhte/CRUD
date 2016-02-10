var app = angular.module("studentApp", []);

app.controller("studentCtrl", function($scope){
    $scope.firstName = "";
    $scope.lastName = "";
    
    $scope.submit = function(){
        console.log("I am working");
        /*$http.post("php.php", {}).success(function(data){
            
        });*/
        
        $.post("test.php", {}, function(data){
            
        });
    };
});