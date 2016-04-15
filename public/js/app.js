var app = angular.module('myApp', []);

app.controller('todoCtrl', function($scope, $http) {

    $scope.showCreateForm = function() {
        
        $scope.clearForm();

        // change modal title
        $('#modal-todo-title').text("Create New Todo");

        // hide update todo button
        $('#btn-update-todo').hide();

        // show create todo button
        $('#btn-create-todo').show();

        // show modal
        $('#modal-todo-form').openModal();
    }

    $scope.clearForm = function() {
        $scope.id = "";
        $scope.title = "";
        $scope.description = "";
    }

    // create new todo 
    $scope.createTodo = function() {

        // fields in key-value pairs
        $http.post('./todo.create', {
            'title': $scope.title,
            'description': $scope.description

        }).success(function(data, status, headers, config) {

            console.log(data);

            // tell the user new todo was created
            Materialize.toast(data, 4000);

            // close modal
            $('#modal-todo-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the list
            $scope.getAll();
        });
    }

    // read todos
    $scope.getAll = function() {
        $http.get('./todos').success(function(response) {
            $scope.todos = response;
        });
    }

    // retrieve record to fill out the form
    $scope.readOne = function(id) {

        // change modal title
        $('#modal-todo-title').text("Edit Todo");

        // show udpate todo button
        $('#btn-update-todo').show();

        // show create todo button
        $('#btn-create-todo').hide();

        // post id of todo to be edited
        $http.get('./todo.edit/'+id).success(function(response) {

            // put the values in form
            $scope.id = response.id;
            $scope.title = response.title;
            $scope.description = response.description;

            // show modal
            $('#modal-todo-form').openModal();

        }).error(function(data) {
            Materialize.toast('Unable to retrieve record.', 4000);
        });
    }

    // update todo record / save changes
    $scope.updateTodo = function() {
        $http.post('./todo.update', {
            'id': $scope.id,
            'title': $scope.title,
            'description': $scope.description

        }).success(function(data, status, headers, config) {
            
            console.log(data);
            
            // tell the user todo record was updated
            Materialize.toast(data, 4000);

            // close modal
            $('#modal-todo-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the todo list
            $scope.getAll();
        });
    }

    // delete todo
    $scope.deleteTodo = function(id) {

        // ask the user if he is sure to delete the record
        if (confirm("Are you sure?")) {
            
            // post the id of todo to be deleted
            $http.post('./todo.remove', {
                'id': id
            }).success(function(data, status, headers, config) {

                // tell the user todo was deleted
                Materialize.toast(data, 4000);

                // refresh the list
                $scope.getAll();
            });
        }
    }
});