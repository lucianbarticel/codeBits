function TodoCtrl($scope){
    $scope.totalTodos = 4;
    $scope.todos = [{text: 'Learn Angular', done: false}, {text: 'build an app', done: false}];
    
    $scope.getTotalTodos = function(){
        return $scope.todos.length;
    }
    
    $scope.addTodo = function(){
        $scope.todos.push({text: $scope.formTodoText, done:false});
        $scope.formTodoText = '';
    }
    
    $scope.clearCompleted = function(){
        $scope.todos= _.filter($scope.todos, function(todo){return !todo.done});
    }
}