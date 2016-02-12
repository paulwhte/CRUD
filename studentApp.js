var app = angular.module("studentApp", []);

app.controller("studentCtrl", function($scope){
    
    $scope.submit = function(typeOfOp, id){
        //console.log("I am working: " + typeOfOp + ", " + id);
        
        //Confirm if it's a delete
        if (typeOfOp == "delete") {
            if (!confirm("Do you want to delete this entry?")) {
                return;
            }
        }
        
        var postData = {type:typeOfOp, firstName:$scope.firstName, lastName:$scope.lastName, id:id};    
        $scope.firstName = "";
        $scope.lastName = "";
        
        $.post("manipulateStudentList.php", postData, function(data){
            //Data is object
            //  error: lists errors, if empty no errors and display students
            //  studentList: array of student objects, specifically student.firstName and student.lastName
            
            //Convert json string to js array
            var hold = $.parseJSON(data);
            //Output errors
            $("#errorDiv").html(hold.error);
            //Update binding
            $scope.studentList = hold.studentList;
            //Kick the view
            $scope.$apply();
        });
    };
    
    $scope.edit = function(typeOfOp, studentObj){
        var postData = {type:typeOfOp, firstName:studentObj.firstName, lastName:studentObj.lastName, id:studentObj.id};
        
        $.post("manipulateStudentList.php", postData, function(data){
            //Data is object
            //  error: lists errors, if empty no errors and display students
            //  studentList: array of student objects, specifically student.firstName and student.lastName
            
            //Convert json string to js array
            var hold = $.parseJSON(data);
            //Output errors
            $("#errorDiv").html(hold.error);
            //Update binding
            $scope.studentList = hold.studentList;
            //Kick the view
            $scope.$apply();
        });
    }
    
    $scope.submit("reload");
});