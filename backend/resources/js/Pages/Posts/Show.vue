<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link} from '@inertiajs/vue3';
import { nl2br} from '@/common.js';
import { router } from '@inertiajs/vue3';


defineProps({
    posts: Object,
}) 



</script>

<template>
    <Head title="投稿内容：詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">投稿内容：詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-8 mx-auto">
                
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
                <div class="p-2 w-full">
                    <div class="relative">
                        <label for="name" class="leading-7 text-sm text-gray-600">タイトル</label>
                        <div  id="name"   class="w-full  bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            {{ posts.title }}
                        </div>
                    </div>
                </div>
                    
                    <div class="p-2 w-full">
                    <div class="relative">
                        <label for="memo" class="leading-7 text-sm text-gray-600">投稿内容</label>
                        <div id="memo" v-html="nl2br(posts.body)" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                    </div>
                    
                    
                </div>
                </div>
            </div>
    </section>
            </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>