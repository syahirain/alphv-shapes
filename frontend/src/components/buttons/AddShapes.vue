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
    import {
        Select,
        SelectContent,
        SelectGroup,
        SelectItem,
        SelectTrigger,
        SelectValue,
    } from '@/components/ui/select'
    import { Input } from '@/components/ui/input'
    import { Label } from '@/components/ui/label'
    import { ref, watch } from 'vue'
    import ColorInput from 'vue-color-input'
    import { useAuthStore } from '@/store/auth'
    import { useToast } from '@/components/ui/toast/use-toast'
    import { useShapesStore } from '@/store/shapes'

    async function setup() {
    await shapesStore.fetchData()
    await shapesStore.fetchOverviewData()
    }

    const shapesStore = useShapesStore()
    const name = ref('')
    const shape = ref('')
    const color = ref('000000')
    const isButtonDisabled = ref(true)
    const authStore = useAuthStore()
    const { toast } = useToast()

    async function fnAddShape(){
        try {
            const response = await fetch(import.meta.env.VITE_API_URL + '/api/shapes', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + authStore.authToken
                },
                body: JSON.stringify({
                name: name.value,
                shape: shape.value,
                color: color.value
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

    watch(name, async () => {
        isButtonDisabled.value = (shape.value === '' || name.value === '')
    })

    watch(shape, async () => {
        isButtonDisabled.value = (shape.value === '' || name.value === '')
    })

</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="outline">
        <Plus class="w-4 h-4 mr-2" />Create New Shape
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Create new shape</DialogTitle>
        <DialogDescription>
          Please enter shape details.
        </DialogDescription>
      </DialogHeader>
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="name" class="text-right">
            Name
          </Label>
          <Input id="name" v-model="name" class="col-span-3" />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="shape" class="text-right">
            Shape
          </Label>
          <Select id="shape" v-model="shape">
                <SelectTrigger class="col-span-3">
                <SelectValue placeholder="Select a shape" />
                </SelectTrigger>
                <SelectContent>
                <SelectGroup>
                    <SelectItem value="circle">
                    Circle
                    </SelectItem>
                    <SelectItem value="oval">
                    Oval
                    </SelectItem>
                    <SelectItem value="rectangle">
                    Rectangle
                    </SelectItem>
                    <SelectItem value="square">
                    Square
                    </SelectItem>
                    <SelectItem value="trapezoid">
                    Trapezoid
                    </SelectItem>
                    <SelectItem value="triangle">
                    Triangle
                    </SelectItem>
                </SelectGroup>
                </SelectContent>
          </Select>
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="color" class="text-right">
            Color
          </Label>
          <color-input id="color" v-model="color" format="hex" />
        </div>
      </div>
      <DialogFooter>
        <DialogClose as-child>
          <Button type="submit" @click="fnAddShape" :disabled="isButtonDisabled">
            Add shape
          </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>