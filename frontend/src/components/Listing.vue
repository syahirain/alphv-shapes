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
   import AddShapes from './buttons/AddShapes.vue'
   import UpdateShapes from './buttons/UpdateShapes.vue'
   import DeleteShapes from './buttons/DeleteShapes.vue'
    //import { ref } from 'vue'
    import { storeToRefs } from 'pinia'
    import { useShapesStore } from '@/store/shapes'
    // import { PencilLine, Trash2 } from 'lucide-vue-next'

//    const shapesLength = ref(0)

async function setup() {
  await shapesStore.fetchData()
  shapesLength.value = shapesStore.shapesLength
}

const shapesLength = defineModel('shapesLength')
const shapesStore = useShapesStore()
setup()

interface Shape {
  id: string;
  shape: string;
  color: string;
  name: string;
  initial: string;
  created_at: string;
  updated_at: string;
}

const { shapes } = storeToRefs(shapesStore) as unknown as { shapes: Shape[] }
</script>

<template>
    <div class="flex-1 space-y-4 p-8 pt-6">
        <div class="flex items-center justify-between space-y-2">
            <h2 class="text-3xl font-bold tracking-tight">
                Shapes Listing
            </h2>
            <div class="flex items-center space-x-2">
                <AddShapes />
            </div>
        </div>
        <Tabs default-value="overview" class="space-y-4">
            <TabsContent value="overview" class="space-y-4">
                <Table>
                    <TableCaption>A list of all shapes.</TableCaption>
                    <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                            ID
                        </TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Shape</TableHead>
                        <TableHead>Color</TableHead>
                        <TableHead>Created at</TableHead>
                        <TableHead>Updated at</TableHead>
                        <TableHead class="text-right"></TableHead>
                    </TableRow>
                    </TableHeader>
                    <TableBody>
                    <TableRow v-for="shape in shapes" :key="shape.id">
                        <TableCell class="font-medium">
                            {{ shape.id }}
                        </TableCell>
                        <TableCell>{{ shape.name }}</TableCell>
                        <TableCell>{{ shape.shape }}</TableCell>
                        <TableCell>{{ shape.color }}</TableCell>
                        <TableCell>{{ (shape.created_at ? new Date(shape.created_at).toLocaleString() : 'N/A') }}</TableCell>
                        <TableCell>{{ (shape.updated_at ? new Date(shape.updated_at).toLocaleString() : 'N/A') }}</TableCell>
                        <TableCell class="text-right">
                            <!-- <Button variant="outline" size="icon"><PencilLine class="w-5 h-5 mx-1" /></Button>
                            <Button variant="outline" size="icon"><Trash2 class="w-5 h-5 mx-1" /></Button> -->
                            <!-- <UpdateShapes v-model:data="shape" /> -->
                            <UpdateShapes :name="shape.name" :shape="shape.shape" :color="shape.color" :shapeId="shape.id" />
                            <DeleteShapes :shapeId="shape.id" />
                        </TableCell>
                    </TableRow>
                    </TableBody>
                </Table>
            </TabsContent>
        </Tabs>
    </div>
</template>