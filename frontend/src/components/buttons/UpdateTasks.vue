<script setup lang="ts">
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
    import { PencilLine } from 'lucide-vue-next'
    import { ref, watch } from 'vue'
    import { useAuthStore } from '@/store/auth'
    import { useToast } from '@/components/ui/toast/use-toast'
    import { useTasksStore } from '@/store/tasks'

    async function setup() {
        await tasksStore.fetchData()
    }

    const { task, taskId } = defineProps(['task', 'taskId']);
    const taskInput = ref('')
    const isButtonDisabled = ref(true)
    const authStore = useAuthStore()
    const { toast } = useToast()
    const tasksStore = useTasksStore()

    taskInput.value = task

    async function fnUpdateTask(){
        try {
            const response = await fetch(import.meta.env.VITE_API_URL + '/api/tasks/' + taskId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + authStore.authToken
                },
                body: JSON.stringify({
                    task: taskInput.value
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

    watch(taskInput, async () => {
        isButtonDisabled.value = (taskInput.value === "" || taskInput.value === task)
    })

</script>

<template>
    <Dialog>
      <DialogTrigger as-child>
          <Button variant="outline" size="icon" class="mx-1"><PencilLine class="w-5 h-5 mx-1" /></Button>
      </DialogTrigger>
      <DialogContent class="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>Update task</DialogTitle>
          <DialogDescription>
            Please enter task details.
          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4 py-4">
          <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right">
              Task
            </Label>
            <Input id="name" v-model="taskInput" class="col-span-3" />
          </div>
        </div>
        <DialogFooter>
          <DialogClose as-child>
            <Button type="submit" @click="fnUpdateTask" :disabled="isButtonDisabled">
              Update task
            </Button>
          </DialogClose>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </template>