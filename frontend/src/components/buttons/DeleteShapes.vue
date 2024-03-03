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
    import { Trash2 } from 'lucide-vue-next'
    import { ref, watch } from 'vue'
    import { useAuthStore } from '@/store/auth'
    import { useToast } from '@/components/ui/toast/use-toast'
    import { useShapesStore } from '@/store/shapes'

    const { shapeId } = defineProps(['shapeId'])
    const deleteInput = ref('')
    const isButtonDisabled = ref(true)
    const shapesStore = useShapesStore()
    const authStore = useAuthStore()
    const { toast } = useToast()

    async function setup() {
        await shapesStore.fetchData()
        await shapesStore.fetchOverviewData()
    }
    
    watch(deleteInput, async () => {
        isButtonDisabled.value = (deleteInput.value !== 'delete-shape')
    })

    async function fnDeleteShape(){
        try {
            const response = await fetch(import.meta.env.VITE_API_URL + '/api/shapes/' + shapeId, {
                method: 'DELETE',
                headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + authStore.authToken
                },
            });

            if (response.ok) {
                setup()
                toast({
                    title: "Status",
                    description: "Shape deleted",
                })
            } else {
                // Handle errors, e.g., show an error message
                console.error('Delete failed', response.statusText);
            }
        } catch (error) {
            // Handle unexpected errors
            console.log(error)
            console.error('An error occurred during delete shape', error);
        }
    }
   
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
        <Button variant="outline" size="icon" class="mx-1"><Trash2 class="w-5 h-5 mx-1" /></Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Delete shape</DialogTitle>
        <DialogDescription>
          Type <span class="font-bold">delete-shape</span> and click Delete button.
        </DialogDescription>
      </DialogHeader>
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <input id="name" v-model="deleteInput" class="col-span-3" placeholder="type here"/>
        </div>
      </div>
      <DialogFooter>
        <DialogClose as-child>
          <Button type="submit" @click="fnDeleteShape" :disabled="isButtonDisabled">
            Delete
          </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>