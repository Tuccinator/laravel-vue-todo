<template>
    <div class="todo-list">
        <div class="todo-header">
            <span>To-Do List</span>
        </div>

        <div class="todo-add">
            <input type="text" v-model="todo" placeholder="What do you need to do?" />
        </div>

        <div class="todo-items">
            <todo-item></todo-item>
        </div>
    </div>
</template>