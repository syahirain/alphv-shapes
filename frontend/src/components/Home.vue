<script setup lang="ts">
   import ShapesGrid from './layouts/ShapesGrid.vue'
   import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
   } from '@/components/ui/card'
   import {
    Tabs,
    TabsContent,
   } from '@/components/ui/tabs'
   import { ref } from 'vue'

   const shapesLength = ref(0)
</script>

<template>
    <div class="flex-1 space-y-4 p-8 pt-6">
        <div class="flex items-center justify-between space-y-2">
            <h2 class="text-3xl font-bold tracking-tight">
                Shapes
            </h2>
        </div>
        <Tabs default-value="overview" class="space-y-4">
            <TabsContent value="overview" class="space-y-4">
                <div class="grid">
                    <Card>
                        <CardHeader>
                        <CardTitle>Total ({{ shapesLength }})</CardTitle>
                        </CardHeader>
                        <CardContent>
                        <ShapesGrid v-model:shapesLength="shapesLength" />
                        </CardContent>
                    </Card>
                </div>
            </TabsContent>
        </Tabs>
    </div>
</template>