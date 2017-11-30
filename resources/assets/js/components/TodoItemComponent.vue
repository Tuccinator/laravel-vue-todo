<template>
    <div class="todo-item">
        <span class="todo-name">{{ todo.text }}</span>
        <div class="star-button" v-on:click="star">
            <i class="fa fa-star" v-if="todo.starred"></i>
            <i class="fa fa-star-o" v-else></i>
        </div>
        <button v-on:click="complete" v-if="todo.status === 1">Completed</button>
        <button v-on:click="remove" v-if="todo.status === 1">x</button>
    </div>
</template>

<script>
const axios = require('axios');
const status = require('../status');

module.exports = {
    props: {
        todo: Object
    },

    methods: {
        remove: function() {
            const todoId = this.todo.id;
            const starred = this.todo.starred;

            axios.delete(`/api/todos/${todoId}`)
                .then(response => {
                    const result = response.data;

                    if(result.success) {
                        this.$emit('update-todo', { id: todoId, status: status.REMOVED, starred: starred });
                    }
                });
        },

        star: function() {
            const todoId = this.todo.id;
            const todoStatus = this.todo.status;

            if(todoStatus !== status.ACTIVE) return;

            axios.post(`/api/todos/${todoId}/star`)
                .then(response => {
                    const result = response.data;

                    if(result.success) {
                        this.$emit('update-todo', result.updated_todo);
                    }
                });
        },

        complete: function() {
            const todoId = this.todo.id;

            axios.post(`/api/todos/${todoId}`)
                .then(response => {
                    const result = response.data;

                    if(result.success) {
                        this.$emit('update-todo', result.updated_todo);
                    }
                })
        }
    }
};

</script>