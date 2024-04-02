<script setup lang="ts">
    import { Button } from '@/components/ui/button'
    import { Check } from 'lucide-vue-next'
    import { useAuthStore } from '@/store/auth'
    import { useToast } from '@/components/ui/toast/use-toast'
    import { useTasksStore } from '@/store/tasks'

    const { taskComplete, taskId } = defineProps(['taskComplete', 'taskId']);
    const authStore = useAuthStore()
    const { toast } = useToast()
    const tasksStore = useTasksStore()

    async function setup() {
        await tasksStore.fetchData()
    }

    async function fnChangeComplete(){
        try {
            const complete = taskComplete == "O" ? "X" : "O";
            const response = await fetch(import.meta.env.VITE_API_URL + '/api/tasks/' + taskId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + authStore.authToken
                },
                body: JSON.stringify({
                    complete: complete
                }),
            });

            if (response.ok) {
                setup()
                const data = await response.json()
                toast({
                    title: "Status",
                    description: data.message,
                })
            } else {
                // Handle errors, e.g., show an error message
                console.error('Login failed', response.statusText);
            }
        } catch (error) {
            // Handle unexpected errors
            console.log(error)
            console.error('An error occurred during login', error);
        }
    }
    
</script>

<template>
    <Button variant="outline" @click="fnChangeComplete" size="icon" class="mx-1">
        <template v-if="taskComplete === 'X'">
            <Check class="w-5 h-5 mx-1" color="#0ed836" />
        </template>
        <template v-else>
        </template>
    </Button>
</template>