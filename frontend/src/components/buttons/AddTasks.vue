<script setup lang="ts">
    import { Plus } from 'lucide-vue-next'
    import { Button } from '@/components/ui/button'
    import {
        Dialog,
        DialogContent,
        DialogDescription,
        DialogFooter,
        DialogHeader,
        DialogTitle,
        DialogTrigger,
        DialogClose,
    } from '@/components/ui/dialog'
    import { Input } from '@/components/ui/input'
    import { Label } from '@/components/ui/label'
    import { ref, watch } from 'vue'
    import { useAuthStore } from '@/store/auth'
    import { useToast } from '@/components/ui/toast/use-toast'
    import { useTasksStore } from '@/store/tasks'

    async function setup() {
        await tasksStore.fetchData()
    }

    const task = ref('')
    const isButtonDisabled = ref(true)
    const tasksStore = useTasksStore()
    const authStore = useAuthStore()
    const { toast } = useToast()

    async function fnAddTask(){
        try {
            const response = await fetch(import.meta.env.VITE_API_URL + '/api/tasks', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + authStore.authToken
                },
                body: JSON.stringify({
                  task: task.value
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

    watch(task, async () => {
        isButtonDisabled.value = (task.value === '')
    })
</script>

<template>
    <Dialog>
      <DialogTrigger as-child>
        <Button variant="outline">
          <Plus class="w-4 h-4 mr-2" />Create New Task
        </Button>
      </DialogTrigger>
      <DialogContent class="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>Create new task</DialogTitle>
          <DialogDescription>
            Please enter task details.
          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4 py-4">
          <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right">
              Task
            </Label>
            <Input id="name" v-model="task" class="col-span-3" />
          </div>
        </div>
        <DialogFooter>
          <DialogClose as-child>
            <Button type="submit" @click="fnAddTask" :disabled="isButtonDisabled">
              Add task
            </Button>
          </DialogClose>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </template>