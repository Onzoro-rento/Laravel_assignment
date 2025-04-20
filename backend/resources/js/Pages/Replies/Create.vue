<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import ValidationErrors from '@/Components/ValidationErrors.vue';

defineProps({
    errors: Object,
    post: Object,
}) 

const form = reactive({
    body: null,
});
const storeReply = (postId) => {
    router.post(`/posts/${postId}/replies`, form);
}
</script>

<template>
    <Head title="リプライ" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">リプライ</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <ValidationErrors :errors="errors" />
            <section class="text-gray-600 body-font relative">
                <!-- 投稿内容表示 -->
            <div class="bg-gray-100 p-4 rounded mb-6">
                <h4 class="text-xl font-bold mb-2">対象の投稿</h4>
                <div class="p-6">
                            <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-4">{{ post.title }}</h2>
                            <p class="text-gray-700 mb-4">{{ post.body }}</p>

                            <div class="text-sm text-gray-500 flex justify-between border-t pt-2 mb-4">
                                <span>作成者: {{ post.user.name }}</span>
                                <span>投稿日: {{ new Date(post.created_at).toLocaleDateString() }}</span>
                            </div>
</div><div></div>
            </div>
                <form @submit.prevent="storeReply(post.id)">
            <div class="container px-5 py-8 mx-auto">
                
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
                
                    
                    <div class="p-2 w-full">
                    <div class="relative">
                        <label for="body" class="leading-7 text-sm text-gray-600">内容</label>
                        <textarea id="body" name="body" v-model="form.body"  class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                    </div>
                    <div class="p-2 w-full">
                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">返信する</button>
                    </div>
                    
                </div>
                </div>
            </div>
        </form>
    </section>
            </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>