<template>
    <div class="todo-item">
        <span class="todo-name">{{ todo.id }}: {{ todo.text }}</span>
    </div>
</template>

<script>

module.exports = {
    props: {
        todo: Object
    }
};

</script>