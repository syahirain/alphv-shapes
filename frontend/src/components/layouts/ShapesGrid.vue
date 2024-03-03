<script setup lang="ts">
import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from '@/components/ui/avatar'
import { storeToRefs } from 'pinia'
import { useShapesStore } from '@/store/shapes'
import { ref } from 'vue'
import { useRoute } from 'vue-router'

async function setup() {
  await shapesStore.fetchData()
  await shapesStore.fetchOverviewData()
  shapesLength.value = shapesStore.shapesLength
  overviewData.value = shapesStore.overviewData
  location.path === '/' && (dataIndex.value = shapesStore.shapesLength)
}

const shapesLength = defineModel('shapesLength')
const overviewData = defineModel('overviewData')
const shapesStore = useShapesStore()
const dataIndex = ref(4)
const location = useRoute()
setup()

interface Shape {
  id: string;
  shape: string;
  color: string;
  name: string;
  initial: string;
  created_at: string;
}

const { shapes } = storeToRefs(shapesStore) as unknown as { shapes: Shape[] }

setInterval(() => {
  setup()
}, 5000);
</script>

<template>
  <div class="space-y-8">
    <template v-for="(shape, index) in shapes" :key="shape.id">
      <div class="flex items-center" v-if="index < dataIndex">
        <Avatar class="h-9 w-9">
          <AvatarImage src="/avatars/01.png" alt="Avatar" />
          <AvatarFallback>{{ shape.initial }}</AvatarFallback>
        </Avatar>
        <div class="ml-4 space-y-1">
          <p class="text-sm font-medium leading-none">
            {{ shape.name }}
          </p>
          <p class="text-sm text-muted-foreground">
            {{ new Date(shape.created_at).toLocaleString() }}
          </p>
        </div>
        <div class="ml-auto font-medium">
          <div :class="shape.shape" :style="{ 'border-bottom': '50px solid ' + shape.color }" v-if="shape.shape == 'triangle' || shape.shape == 'trapezoid'"></div>
          <div :class="shape.shape" :style="{ 'background-color': shape.color }" v-else></div>
        </div>
      </div>
    </template>
  </div>
</template>