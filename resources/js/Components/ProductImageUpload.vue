<template>
    <div class="p-4">
        <div class="images-display grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <!-- Display images -->
            <img v-for="image in images" :src="image.path" :alt="`Product Image ${image.id}`" :key="image.id"
                class="w-full object-cover h-48 rounded-lg shadow-md">
        </div>

        <div class="image-upload mt-8">
            <!-- Image upload form -->
            <input type="file" @change="uploadImage" multiple
                class="file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
        </div>
    </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    productId: Number
});
console.log(props.productId)
const images = ref([]);

const fetchImages = async () => {
    try {
        const response = await axios.get(`/api/products/${props.productId}/images`);
        images.value = response.data;
        console.log(images.value[2])
    } catch (error) {
        console.error(error);
        // Handle error
    }
};

const uploadImage = async (event) => {
    const files = event.target.files;
    if (files.length === 0) return;

    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append("images[]", files[i]);
    }

    try {
        await axios.post(`/api/products/${props.productId}/images/upload`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        fetchImages(); // Re-fetch images after upload
    } catch (error) {
        console.error(error);
        // Handle error
    }
};

onMounted(fetchImages);
</script>
  
<style scoped>
/* Add styles here */
</style>
  