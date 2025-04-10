<script setup>
import { router } from '@inertiajs/vue3';
import InertiaTest from '../InertiaTest.vue';

defineProps({
    id : String,
    blog : Object,
})

const deleteConfirm = (id) => {
    // console.log(id);
    router.delete(`/inertia/${id}`, {
        onBefore: () => confirm('本当に削除しますか？'),
    });
}
    
</script>
<template>
{{ id }}<br>
{{ blog.title }}
<button @click="deleteConfirm(blog.id)">削除</button>
</template>