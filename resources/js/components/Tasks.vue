<template>
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    <div v-show="errors.length" class="alert alert-danger">
                        <strong>Whoops! Something went wrong!</strong>
                        <br><br>

                        <ul>
                            <li v-for="error in errors" v-bind:key="error">{{ error }}</li>
                        </ul>
                    </div>

                    <div class="form-horizontal">
                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" v-model="task.name">
                            </div>
                       </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                          <div class="col-sm-offset-3 col-sm-6">
                                <button @click="addTask()" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Tasks -->
            <div v-show="tasks.length">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Task</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" v-bind:key="task.id">
                                    <td class="table-text"><div>{{ task.name }}</div></td>

                                    <!-- Task Delete Button -->
                                    <td>
                                        <button @click="deleteTask(task.id)" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [],
                task: {
                    name: ''
                },
                errors: []
            }
        },

        created() {
            this.fetchTasks();
        },

        methods: {
            fetchTasks() {
                fetch('api/tasks')
                .then(res => res.json())
                .then(res => {
                    this.tasks = res.data;
                })
                .catch(err => console.log(err))
            },
            addTask() {
                this.errors = [];
                if(!this.task.name) {
                    this.errors.push('Name required.');
                    return;
                }

                fetch('api/task', {
                    method: 'post',
                    body: JSON.stringify(this.task),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.task.name = '';
                    this.fetchTasks();
                })
                .catch(err => console.log(err))
            },
            deleteTask(id) {
                fetch(`api/task/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    this.fetchTasks();
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>