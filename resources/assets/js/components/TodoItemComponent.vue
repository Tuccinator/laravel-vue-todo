<template>
    <div class="todo-item">
        <span class="todo-name">{{ todo.id }}: {{ todo.text }}</span>
        <button v-on:click="remove">x</button>
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

            axios.delete(`/api/todos/${todoId}`)
                .then(response => {
                    const result = response.data;

                    if(result.success) {
                        this.$emit('update-todo', { id: todoId, status: status.REMOVED });
                    }
                });
        }
    }
};

</script>