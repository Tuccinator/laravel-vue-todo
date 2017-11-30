<template>
    <div class="todo-list">
        <div class="todo-header">
            <span>To-Do List</span>
        </div>

        <ul class="filters">
            <li v-on:click="changeFilter(filtering.ACTIVE)">Active</li>
            <li v-on:click="changeFilter(filtering.COMPLETED)">Completed</li>
            <li v-on:click="changeFilter(filtering.ALL)">ALL</li>
        </ul>

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
            todos: [],
            currentFilter: 1,
            filtering: {
                ACTIVE: 1,
                COMPLETED: 2,
                ALL: 3
            }
        };
    },

    methods: {
        addTodo: function() {
            axios.post('/api/todos', { text: this.todo })
                .then(response => {
                    const result = response.data;

                    // check if successfully added
                    if(result.success) {
                        const newTodo = result.inserted_todo;

                        this.todos.push(newTodo);
                        this.todo = '';
                    }
                })
        },

        updateTodo: function({ id, status, starred }) {
            const index = _.findIndex(this.todos, todo => { return todo.id === id });
            const newTodo = this.todos[index];
            newTodo.status = status;
            newTodo.starred = starred;

            this.todos[index] = newTodo;
        },

        changeFilter: function(filter) {
            this.currentFilter = filter;
        }
    },

    computed: {
        availableTodos: function() {
            return this.sortTodos.filter((todo) => {
                switch(this.currentFilter) {
                    case 3:
                        return true;
                    case 2:
                        return todo.status === status.COMPLETED;
                    case 1:
                    default:
                        return todo.status === status.ACTIVE;
                }
            });
        },

        sortTodos: function() {
            return this.todos.sort(function(a, b) {
                return a.starred < b.starred;
            });
        }
    }
};

</script>