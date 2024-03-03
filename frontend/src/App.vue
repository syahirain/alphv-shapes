<script setup lang="ts">
    import MainNav from './components/layouts/MainNav.vue'
    import Search from './components/layouts/Search.vue'
    import UserNav from './components/layouts/UserNav.vue'
    import LoginButton from './components/buttons/LoginButton.vue'
    import Toaster from '@/components/ui/toast/Toaster.vue'
    import { useAuthStore } from '@/store/auth'
    
    const authStore = useAuthStore()

    if (localStorage.token) {
        authStore.setAuthToken(localStorage.token);
    }
</script>

<template>
    <div class="hidden flex-col md:flex">
        <div class="border-b" v-if="$route.path !== '/login'">
            <div class="flex h-16 items-center px-4">
                <!-- <TeamSwitcher /> -->
                <MainNav class="mx-6" />
                <div class="ml-auto flex items-center space-x-4">
                <Search v-if="authStore.token !== ''" />
                <UserNav v-if="authStore.token !== ''" />
                <LoginButton v-if="authStore.token == ''" />
                </div>
            </div>
        </div>
        <router-view></router-view>
    </div>
    <Toaster />
</template>