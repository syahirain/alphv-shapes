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
    import { PencilLine } from 'lucide-vue-next'
    import { ref, watch } from 'vue'
    import ColorInput from 'vue-color-input'
    import { useAuthStore } from '@/store/auth'
    import { useToast } from '@/components/ui/toast/use-toast'
    import { useShapesStore } from '@/store/shapes'
    
    async function setup() {
        await shapesStore.fetchData()
        await shapesStore.fetchOverviewData()
    }

    const { name, shape, color, shapeId } = defineProps(['name', 'shape', 'color', 'shapeId']);
    const nameInput = ref('')
    const shapeInput = ref('')
    const colourInput = ref('000000')
    const isButtonDisabled = ref(true)
    const authStore = useAuthStore()
    const { toast } = useToast()
    const shapesStore = useShapesStore()

    nameInput.value = name
    shapeInput.value = shape
    colourInput.value = color

    async function fnUpdateShape(){
        try {
            const response = await fetch(import.meta.env.VITE_API_URL + '/api/shapes/' + shapeId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + authStore.authToken
                },
                body: JSON.stringify({
                name: nameInput.value,
                shape: shapeInput.value,
                color: colourInput.value
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

    watch(nameInput, async () => {
        isButtonDisabled.value = (nameInput.value === name && shapeInput.value === shape && colourInput.value === color)
    })

    watch(shapeInput, async () => {
        isButtonDisabled.value = (nameInput.value === name && shapeInput.value === shape && colourInput.value === color)
    })

    watch(colourInput, async () => {
        isButtonDisabled.value = (nameInput.value === name && shapeInput.value === shape && colourInput.value === color)
    })

</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
        <Button variant="outline" size="icon" class="mx-1"><PencilLine class="w-5 h-5 mx-1" /></Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Update shape</DialogTitle>
        <DialogDescription>
          Please enter shape details.
        </DialogDescription>
      </DialogHeader>
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="name" class="text-right">
            Name
          </Label>
          <Input id="name" v-model="nameInput" class="col-span-3" />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="shape" class="text-right">
            Shape
          </Label>
          <Select id="shape" v-model="shapeInput">
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
          <color-input id="color" v-model="colourInput" format="hex" />
        </div>
      </div>
      <DialogFooter>
        <DialogClose as-child>
          <Button type="submit" @click="fnUpdateShape" :disabled="isButtonDisabled">
            Update shape
          </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>