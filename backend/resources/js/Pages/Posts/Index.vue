<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import { nl2br } from '@/common.js';
defineProps({
    posts: Object,
    auth: Object,
    
});
// console.log(replies);


const showReplies = ref({});

const toggleReplies = (postId) => {
    showReplies.value[postId] = !showReplies.value[postId];
};
const deletePost = id => {
    router.delete(route('posts.destroy', {post:id}), {
        onBefore: () => confirm('本当に削除しますか？'),
    });
}
const deleteReply = ({ post, reply }) => {
    router.delete(route('replies.destroy', { post: post, reply: reply }), {
        onBefore: () => confirm('本当に削除しますか？'),
    });
}
</script>

<template>
    <Head title="掲示板" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">掲示板</h2>
                <Link
                    as="button"
                    :href="route('posts.create')"
                    class="inline-block px-6 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg shadow-md hover:bg-blue-700 transition duration-200"
                >
                    ＋ 新規投稿
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <FlashMessage />
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="space-y-8">
                    <div v-for="post in posts.data" :key="post.id" class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-center border-b pb-2 mb-4">
                                <h2 class="text-2xl font-semibold text-gray-800">{{ post.title }}</h2>
                                <div class="flex gap-2" v-if="auth.user.id === post.user.id">
                                    <Link
                                        as="button"
                                        :href="route('posts.edit', post.id)"
                                        class="text-sm px-4 py-2 bg-yellow-400 text-white font-semibold rounded hover:bg-yellow-500 transition duration-200 shadow"
                                    >
                                        編集する
                                    </Link>
                                    <button
                                        @click="deletePost(post.id)"
                                        class="text-sm px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition duration-200 shadow"
                                    >
                                        削除する
                                    </button>
                                </div>
                            </div>

                            <p v-html="nl2br(post.body)" class="text-gray-700 mb-4"></p>

                            <div class="text-sm text-gray-500 flex justify-between border-t pt-2 mb-4">
                                <span>作成者: {{ post.user.name }}</span>
                                <span>投稿日: {{ new Date(post.created_at).toLocaleDateString() }}</span>
                            </div>

                            <!-- リプライ表示切り替えボタン -->
                            <button
                                class="text-blue-600 hover:underline text-sm"
                                @click="toggleReplies(post.id)"
                            >
                            {{ showReplies[post.id] 
                            ?  ' リプライを隠す' 
                            : post.replies.length + ' 件のリプライを表示' }}
                            </button>
                            <Link as="button"
                            :href="route('replies.create', { post: post.id })"
                            class="inline-block ml-4 text-sm bg-green-600 text-white px-4 py-3 font-bold rounded-lg shadow-md hover:bg-green-700 transition duration-200"
>
                                返信する
                            </Link>

                                                                   
                    <div v-if="showReplies[post.id]" class="mt-4 border-t pt-4 space-y-4">
                        <div v-if="post.replies && post.replies.length > 0">
                            <div
                                v-for="reply in post.replies"
                                :key="reply.id"
                                class="p-4 my-4 bg-gray-100 rounded-lg shadow-sm"
                            >
                                <!-- 名前、日付、ボタンを1行に -->
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="text-sm font-bold text-gray-700">返信者： {{ reply.user.name }}</span>
                                        <span class="text-xs text-gray-500 ml-4">{{ new Date(reply.created_at).toLocaleDateString() }}</span>
                                    </div>
                                    <div class="flex gap-2" v-if="auth.user.id === reply.user.id">
                                        <Link
                                            as="button"
                                            :href="route('replies.edit', { post: post.id, reply: reply.id })"
                                            class="text-sm px-4 py-2 bg-yellow-400 text-white font-semibold rounded hover:bg-yellow-500 transition duration-200 shadow"
                                        >
                                            編集する
                                        </Link>
                                        <button
                                            @click="deleteReply({ post: post.id, reply: reply.id })"
                                            class="text-sm px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition duration-200 shadow"
                                        >
                                            削除する
                                        </button>
                                    </div>
                                </div>

                                <hr class="my-2 border-gray-300" />

                                <div class="text-gray-800 text-sm mt-2">
                                    {{ reply.body }}
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-sm text-gray-400">まだリプライはありません。</div>
                    </div>

                    
                        </div>
                    </div>
                </div>

            </div>
            <div class="flex justify-center mt-6">
                    <Pagination :links="posts.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
