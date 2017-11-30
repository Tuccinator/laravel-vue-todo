<template>
    <div class="todo-list">
        <div class="todo-header">
            <span>To-Do List</span>
        </div>

        <div class="todo-add">
            <input type="text" v-model="todo" @keyup.enter="addTodo" placeholder="What do you need to do?" />
        </div>

        <div class="todo-items">
            <todo-item v-for="todo in availableTodos" key="todo.id" v-bind:todo="todo" v-on:update-todo="updateTodo"></todo-item>
        </div>
    </div>
</template>

<script>
const TodoItem = require('./TodoItemComponent.vue');
const status = require('../status');
const axios = require('axios');
const _ = require('lodash');

module.exports = {
    components: {
        'todo-item': TodoItem
    },

    mounted: function() {
        axios.get('/api/todos')
            .then(response => {
                const todos = response.data;

                this.todos = todos;
            });
    },

    data: function() {
        return {
            todo: '',
            todos: []
        };
    },

    methods: {
        addTodo: function() {
            axios.post('/api/todos', { text: this.todo })
                .then(response => {
                    const result = response.data;

                    // check if successfully added
                    if(result.success) {
                        const newTodo = JSON.parse(result.inserted_todo);

                        this.todos.push(newTodo);
                        this.todo = '';
                    }
                })
        },

        updateTodo: function({ id, status }) {
            const index = _.findIndex(this.todos, todo => { return todo.id === id });
            const newTodo = this.todos[index];
            newTodo.status = status;

            this.todos[index] = newTodo;
        }
    },

    computed: {
        availableTodos: function() {
            return this.todos.filter(function(todo) {
                return todo.status === status.ACTIVE;
            });
        }
    }
};

</script>