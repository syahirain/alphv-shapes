<script setup lang="ts">
  import { cn } from '@/lib/utils'
  import { useAuthStore } from '@/store/auth'
    
  const authStore = useAuthStore()
</script>

<template>
  <div :class="cn('flex items-center space-x-4 lg:space-x-6', $attrs.class ?? '')">
    <router-link to="/" class="text-sm font-medium transition-colors hover:text-primary" :class="{ 'text-muted-foreground': $route.path !== '/' }">Home</router-link>
    <router-link to="/overview" v-if="authStore.isAuthenticated()" class="text-sm font-medium transition-colors hover:text-primary" :class="{ 'text-muted-foreground': $route.path !== '/overview' }">Overview</router-link>
    <router-link to="/listing" v-if="authStore.isAuthenticated()" class="text-sm font-medium transition-colors hover:text-primary" :class="{ 'text-muted-foreground': $route.path !== '/listing' }">Listing</router-link>
    <!-- Other navigation links -->
  </div>
</template>