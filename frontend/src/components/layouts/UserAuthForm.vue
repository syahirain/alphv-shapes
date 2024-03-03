<script setup lang="ts">
import { ref } from 'vue'
import { Loader2 } from 'lucide-vue-next';
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import router from '../../router'
import { useAuthStore } from '@/store/auth'

const authStore = useAuthStore()
const email = ref('')
const password = ref('')
const isLoading = ref(false)

async function onSubmit(event: Event) {
  event.preventDefault()
  isLoading.value = true

  try {
      const response = await fetch(import.meta.env.VITE_API_URL + '/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: email.value,
          password: password.value,
          token_name: "web-access"
        }),
      });

      if (response.ok) {
        const data = await response.json()
        localStorage.token = data.access_token
        localStorage.user = data.user
        authStore.setAuthToken(data.access_token)
        router.push('/')
      } else {
        // Handle errors, e.g., show an error message
        console.error('Login failed', response.statusText);
      }
      isLoading.value = false
  } catch (error) {
    // Handle unexpected errors
    isLoading.value = false
    console.log(error)
    console.error('An error occurred during login', error);
  }
}
</script>

<template>
  <div :class="cn('grid gap-6', $attrs.class ?? '')">
    <form @submit="onSubmit">
      <div class="grid gap-2">
        <div class="grid gap-1">
          <Label class="sr-only" for="email">
            Email
          </Label>
          <!-- <Input
            id="email"
            placeholder="email"
            type="email"
            auto-capitalize="none"
            auto-complete="email"
            auto-correct="off"
            :disabled="isLoading"
          /> -->
          <input type="email" v-model="email" id="email" placeholder="email"/>
        </div>
        <div class="grid gap-1">
          <Label class="sr-only" for="password">
            Email
          </Label>
          <!-- <Input
            id="password"
            placeholder="password"
            type="password"
            auto-capitalize="none"
            auto-correct="off"
            :disabled="isLoading"
          /> -->
          <input type="password" v-model="password" id="password" placeholder="password" />
        </div>
        <Button :disabled="isLoading">
          <Loader2 v-if="isLoading" class="mr-2 h-4 w-4 animate-spin" />
          Sign In
        </Button>
      </div>
    </form>
  </div>
</template>