<script setup lang="ts">
import { Carousel, CarouselContent, CarouselItem } from '@/components/ui/carousel'
import { Card, CardDescription, CardContent } from '@/components/ui/card'
import Autoplay from 'embla-carousel-autoplay'
// import { useFetch } from '../fetch-shapes.ts'
// import { Ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useShapesStore } from '@/store/shapes'

interface Shape {
  id: string;
  name: string;
  shape: string;
  color: string;
}

const shapesStore = useShapesStore()
const { shapes } = storeToRefs(shapesStore) as unknown as { shapes: Shape[] }

//const shapes = ['circle', 'square', 'rectangle', 'oval'];
</script>

<template>
  <Carousel
    class="relative w-full max-w-3xl items-center justify-center"
    :opts="{
      align: 'start',
      loop: true,
    }"
    :plugins="[Autoplay({
      delay: 2000,
    })]"
  >
    <CarouselContent class="-ml-1">
      <CarouselItem v-for="shape in shapes" :key="shape.id" class="pl-1 md:basis-1/2 lg:basis-1/3">
        <div class="p-1">
          <Card>
            <CardDescription class="ml-2">{{ shape.name }}</CardDescription>
            <CardContent class="flex aspect-square items-center justify-center p-6">
              <!-- <span class="text-2xl font-semibold">{{ index + 1 }}</span> -->
              <div :class="shape.shape + '-carousel'" :style="{ 'border-bottom': '100px solid ' + shape.color }" v-if="shape.shape == 'triangle' || shape.shape == 'trapezoid'"></div>
              <div :class="shape.shape + '-carousel'" :style="{ 'background-color': shape.color }" v-else></div>
            </CardContent>
          </Card>
        </div>
      </CarouselItem>
    </CarouselContent>
  </Carousel>
</template>