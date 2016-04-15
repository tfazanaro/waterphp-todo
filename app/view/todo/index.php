<?php load('template/header'); ?>

<body>
    <div class="container" ng-app="myApp" ng-controller="todoCtrl">
        <div class="row">
            <div class="col s12">

                <h4>TODO List</h4>

                <!-- used for searching the current list -->
                <input type="text" ng-model="search" class="form-control" placeholder="Search todo...">

                <!-- table that shows todo record list -->
                <table class="hoverable bordered">
                    <thead>
                        <tr>
                            <th class="text-align-center">ID</th>
                            <th class="width-30-pct">Title</th>
                            <th class="width-30-pct">Description</th>
                            <th class="text-align-center">Action</th>
                        </tr>
                    </thead>
                    <tbody ng-init="getAll()">
                        <tr ng-repeat="todo in todos | filter:search">
                            <td class="text-align-center">{{ todo.id }}</td>
                            <td>{{ todo.title }}</td>
                            <td>{{ todo.description }}</td>
                            <td>
                                <a ng-click="readOne(todo.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">edit</i>Edit</a>
                                <a ng-click="deleteTodo(todo.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">delete</i>Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- floating button for creating todo -->
                <div class="fixed-action-btn" style="bottom:45px; right:24px;">
                    <a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-todo-form" ng-click="showCreateForm()"><i class="large material-icons">add</i></a>
                </div>

                <!-- modal for for creating new todo -->
                <div id="modal-todo-form" class="modal">
                    <div class="modal-content">
                        <h4 id="modal-todo-title">Create New TODO</h4>
                        <div class="row">
                            <div class="input-field col s12">
                                <input ng-model="title" type="text" class="validate" id="form-name" placeholder="Type title here..." />
                                <label for="title">Title</label>
                            </div>
                            <div class="input-field col s12">
                                <textarea ng-model="description" type="text" class="validate materialize-textarea" placeholder="Type description here..."></textarea>
                                <label for="description">Description</label>
                            </div>
                            <div class="input-field col s12">
                                <a id="btn-create-todo" class="waves-effect waves-light btn margin-bottom-1em" ng-click="createTodo()"><i class="material-icons left">add</i>Create</a>

                                <a id="btn-update-todo" class="waves-effect waves-light btn margin-bottom-1em" ng-click="updateTodo()"><i class="material-icons left">edit</i>Save Changes</a>

                                <a class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">close</i>Close</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal -->
            </div>
            <!-- end col s12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->

    <?php load('template/footer'); ?>