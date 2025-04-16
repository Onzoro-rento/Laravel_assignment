<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import {onMounted} from 'vue';
import Pagination from '@/Components/Pagination.vue';
import {ref} from 'vue';
import {router} from '@inertiajs/vue3';

defineProps({
    customers: Object
    
});
const search = ref('')
// ref の値を取得するには .valueが必要
const searchCustomers = () => {
 Inertia.get(route('customers.index', { search: search.value }))
}

// onMounted(() => {
//     console.log(props.customers);
// });
</script>

<template>
    <ul v-for="customer in customers.data" :key="customer.id">
        <li>{{ customer.id }}</li>
        <li>{{ customer.name }}</li>
    </ul>>


    <Pagination class="mt-6" :links="customers.links"></Pagination>>
</template>
