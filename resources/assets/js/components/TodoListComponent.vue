<template>
    <div class="todo-list">
        <div class="todo-header">
            <span>To-Do List</span>
        </div>

        <div class="todo-add">
            <input type="text" v-model="todo" @keyup.enter="addTodo" placeholder="What do you need to do?" />
        </div>

        <div class="todo-items">
            <todo-item v-for="todo in todos" v-bind:todo="todo" key="todo.id"></todo-item>
        </div>
    </div>
</template>

<script>
const TodoItem = require('./TodoItemComponent.vue');

module.exports = {
    components: {
        'todo-item': TodoItem
    },

    data: function() {
        return {
            todo: '',
            
            todos: [
                { id: 1, text: 'Get Groceries'},
                { id: 2, text: 'Buy new TV'},
                { id: 3, text: 'Begin workout'}
            ],

            nextTodoId: 4
        };
    },

    methods: {
        addTodo: function() {
            this.todos.push({ id: this.nextTodoId, text: this.todo });
            this.todo = '';
            this.nextTodoId += 1;
        }
    }
};

</script>