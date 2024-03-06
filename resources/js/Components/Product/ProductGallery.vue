<template>
    <div class="flex flex-col items-center">
        <div class="mb-5">
            <img :src="currentImage" alt="Product Image" class="w-full max-w-lg" />
        </div>
        <div class="flex gap-2">
            <div v-for="(image, index) in images" :key="index"
                class="cursor-pointer transform transition duration-200 ease-in-out hover:scale-110"
                @click="setCurrentImage(image)">
                <img :src="image" alt="Product Thumbnail" class="w-24 h-24 object-cover" />
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const product = ref(props.product);


console.log(usePage())

// Sample images, replace with your actual images
const images = ref([
'/images/placeholder.png',
'/images/placeholder.png',
'/images/placeholder.png',
    // Add more images as needed
]);

const currentImage = ref(images.value[0]);

function setCurrentImage(image) {
    currentImage.value = image;
}
</script>
  