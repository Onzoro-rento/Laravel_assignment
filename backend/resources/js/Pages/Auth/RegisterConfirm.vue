<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { router } from '@inertiajs/vue3'

defineProps({
  userInput: Object,
})

const submit = () => {
  router.post(route('register.final'))
}

const goBack = () => {
  router.visit(route('register'))
}
</script>

<template>
  <GuestLayout>
    <div class="space-y-6 text-gray-800">
      <h2 class="text-xl font-semibold text-center">登録内容の確認</h2>

      <div class="space-y-4 text-sm">
        <div>
          <p class="text-gray-600">名前</p>
          <p class="text-base font-medium text-gray-900 border-b pb-1">{{ userInput.name }}</p>
        </div>

        <div>
          <p class="text-gray-600">メールアドレス</p>
          <p class="text-base font-medium text-gray-900 border-b pb-1">{{ userInput.email }}</p>
        </div>

        <div>
          <p class="text-gray-600">パスワード</p>
          <p class="text-base font-medium text-gray-900 tracking-widest border-b pb-1">
            {{ '•'.repeat(userInput.password.length) }}
          </p>
        </div>
      </div>

      <div class="flex flex-col space-y-3 items-center mt-6">
        <button
          @click="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition"
        >
          この内容で登録する
        </button>

        <button
          @click="goBack"
          class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md transition"
        >
          修正する
        </button>
      </div>
    </div>
  </GuestLayout>
</template>
