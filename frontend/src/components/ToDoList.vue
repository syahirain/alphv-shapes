<script setup lang="ts">
    import {
        Table,
        TableBody,
        TableCaption,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
    } from '@/components/ui/table'  
   import {
    Tabs,
    TabsContent,
   } from '@/components/ui/tabs'
   import { storeToRefs } from 'pinia'
   import { useTasksStore } from '@/store/tasks'

   import AddTasks from './buttons/AddTasks.vue'
   import UpdateTasks from './buttons/UpdateTasks.vue'
   import DeleteTasks from './buttons/DeleteTasks.vue'
   import TaskCheckbox from './buttons/TaskCheckbox.vue'

   async function setup() {
    await tasksStore.fetchData()
    tasksLength.value = tasksStore.tasksLength
   }

    const tasksLength = defineModel('tasksLength')
    const tasksStore = useTasksStore()
    setup()

    interface Task {
        id: string;
        user_id: string;
        task: string;
        complete: string;
        created_at: string;
        updated_at: string;
    }

const { tasks } = storeToRefs(tasksStore) as unknown as { tasks: Task[] }
</script>

<template>
    <div class="flex-1 space-y-4 p-8 pt-6">
        <div class="flex items-center justify-between space-y-2">
            <h2 class="text-3xl font-bold tracking-tight">
                To Do List
            </h2>
            <div class="flex items-center space-x-2">
                <AddTasks />
            </div>
        </div>
        <Tabs default-value="overview" class="space-y-4">
            <TabsContent value="overview" class="space-y-4">
                <Table>
                    <TableCaption>A list of all tasks.</TableCaption>
                    <TableHeader>
                    <TableRow>
                        <!-- <TableHead class="w-[100px]">ID</TableHead> -->
                        <TableHead></TableHead>
                        <TableHead>Task</TableHead>
                        <TableHead>Created at</TableHead>
                        <TableHead>Updated at</TableHead>
                        <TableHead class="text-right"></TableHead>
                    </TableRow>
                    </TableHeader>
                    <TableBody>
                    <TableRow v-for="task in tasks" :key="task.id">
                        <!-- <TableCell class="font-medium">
                            {{ task.id }}
                        </TableCell> -->
                        <TableCell>
                            <TaskCheckbox :taskComplete="task.complete" :taskId="task.id" />
                        </TableCell>
                        <TableCell :class="{ 'line-through': task.complete === 'X' }">{{ task.task }}</TableCell>
                        <TableCell>{{ (task.created_at ? new Date(task.created_at).toLocaleString() : 'N/A') }}</TableCell>
                        <TableCell>{{ (task.updated_at ? new Date(task.updated_at).toLocaleString() : 'N/A') }}</TableCell>
                        <TableCell class="text-right">
                            <UpdateTasks :task="task.task" :taskId="task.id" />
                            <DeleteTasks :taskId="task.id" />
                        </TableCell>
                    </TableRow>
                    </TableBody>
                </Table>
            </TabsContent>
        </Tabs>
    </div>
</template>