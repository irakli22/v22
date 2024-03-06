<script setup>

import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import ProductImageUpload from './ProductImageUpload.vue';


const { props } = usePage();

const form = useForm({
    name: props.product.name || '',
    price: props.product.price || '',
    storageCapacity: props.product.storageCapacity || '',
    ram: props.product.ram || '',
    categoryId: props.product.categoryId || '',
});

console.log(props)

const dropdownOpen = ref(false);
const categories = ref(props.categories);
const selectedCategory = ref('');
const isOpen = ref(false);



// Immediately set the selected category if categoryId is available
if (props.product && props.product.categoryId) {
    const foundCategory = categories.value.find(category => category.id === props.product.categoryId);
    if (foundCategory) {
        selectedCategory.value = foundCategory.name;
        form.categoryId = props.product.categoryId; // Ensure form's categoryId is also set
    }
}

// Function to handle category selection
const selectCategory = (categoryId, categoryName) => {
    selectedCategory.value = categoryName; // Store the selected category name
    form.categoryId = categoryId; // Directly assign the categoryId
    toggleDropdown();
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    dropdownOpen.value = !dropdownOpen.value;
};

const submit = () => {


    console.log(form);
    form.post('/product-upload');
}

</script>

<template>
    <div>
        <form @submit.prevent="submit" class="bg-white max-w-lg mx-auto my-10 p-6 rounded shadow">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input id="name" type="text" v-model="form.name" placeholder="Name"
                    class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</div>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                <input id="price" type="number" v-model="form.price" placeholder="Price"
                    class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.price" class="text-red-500 text-xs italic">{{ form.errors.price }}</div>
            </div>

            <div class="mb-4">
                <label for="storageCapacity" class="block text-gray-700 text-sm font-bold mb-2">Storage Capacity
                    (GB):</label>
                <input id="storageCapacity" type="number" v-model="form.storageCapacity"
                    placeholder="Storage Capacity in GB"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.storageCapacity" class="text-red-500 text-xs italic">{{ form.errors.storageCapacity
                }}
                </div>
            </div>

            <div class="mb-4">
                <label for="ram" class="block text-gray-700 text-sm font-bold mb-2">RAM (GB):</label>
                <input id="ram" type="number" v-model="form.ram" placeholder="RAM in GB"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.ram" class="text-red-500 text-xs italic">{{ form.errors.ram }}</div>
            </div>

            <div class="mb-4">
                <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Color:</label>
                <input id="color" type="text" v-model="form.color" placeholder="Color"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.color" class="text-red-500 text-xs italic">{{ form.errors.color }}</div>
            </div>

            <div class="mb-4">
                <label for="screenSize" class="block text-gray-700 text-sm font-bold mb-2">Screen Size (inches):</label>
                <input id="screenSize" type="number" step="0.01" v-model="form.screenSize"
                    placeholder="Screen Size in inches"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.screenSize" class="text-red-500 text-xs italic">{{ form.errors.screenSize }}</div>
            </div>

            <div class="mb-4">
                <label for="displayType" class="block text-gray-700 text-sm font-bold mb-2">Display Type:</label>
                <input id="displayType" type="text" v-model="form.displayType" placeholder="e.g., LCD, OLED"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.displayType" class="text-red-500 text-xs italic">{{ form.errors.displayType }}</div>
            </div>

            <div class="mb-4">
                <label for="refreshRate" class="block text-gray-700 text-sm font-bold mb-2">Refresh Rate (Hz):</label>
                <input id="refreshRate" type="number" v-model="form.refreshRate" placeholder="Refresh Rate in Hz"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.refreshRate" class="text-red-500 text-xs italic">{{ form.errors.refreshRate }}</div>
            </div>

            <div class="mb-4">
                <label for="bodyMaterial" class="block text-gray-700 text-sm font-bold mb-2">Body Material:</label>
                <input id="bodyMaterial" type="text" v-model="form.bodyMaterial" placeholder="Body Material"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.bodyMaterial" class="text-red-500 text-xs italic">{{ form.errors.bodyMaterial }}
                </div>
            </div>

            <div class="mb-4">
                <label for="connectivity" class="block text-gray-700 text-sm font-bold mb-2">Connectivity:</label>
                <input id="connectivity" type="text" v-model="form.connectivity" placeholder="e.g., 5G, LTE, Wi-Fi"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.connectivity" class="text-red-500 text-xs italic">{{ form.errors.connectivity }}
                </div>
            </div>

            <div class="mb-4">
                <label for="frontCameraResolution" class="block text-gray-700 text-sm font-bold mb-2">Front Camera
                    Resolution:</label>
                <input id="frontCameraResolution" type="text" v-model="form.frontCameraResolution"
                    placeholder="Front Camera Resolution"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.frontCameraResolution" class="text-red-500 text-xs italic">{{
                    form.errors.frontCameraResolution }}</div>
            </div>

            <div class="mb-4">
                <label for="cameraResolution" class="block text-gray-700 text-sm font-bold mb-2">Camera Resolution:</label>
                <input id="cameraResolution" type="text" v-model="form.cameraResolution" placeholder="Camera Resolution"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.cameraResolution" class="text-red-500 text-xs italic">{{ form.errors.cameraResolution
                }}
                </div>
            </div>

            <div class="mb-4">
                <label for="simType" class="block text-gray-700 text-sm font-bold mb-2">SIM Type:</label>
                <input id="simType" type="text" v-model="form.simType" placeholder="SIM Type"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.simType" class="text-red-500 text-xs italic">{{ form.errors.simType }}</div>
            </div>


            <div class="mb-4">
                <label for="operatingSystem" class="block text-gray-700 text-sm font-bold mb-2">Operating System:</label>
                <input id="operatingSystem" type="text" v-model="form.operatingSystem" placeholder="Operating System"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.operatingSystem" class="text-red-500 text-xs italic">{{ form.errors.operatingSystem
                }}
                </div>
            </div>

            <div class="mb-4">
                <label for="processor" class="block text-gray-700 text-sm font-bold mb-2">Processor:</label>
                <input id="processor" type="text" v-model="form.processor" placeholder="Processor Type and Model"
                    class="shadow appearance-none border rounded border-gray-300 w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div v-if="form.errors.processor" class="text-red-500 text-xs italic">{{ form.errors.processor }}</div>
            </div>

            <div class="mb-4">
                <label for="waterResistant" class="flex items-center">
                    <input id="waterResistant" type="checkbox" v-model="form.waterResistant"
                        class="shadow border-gray-300 rounded mr-2">
                    Water Resistant
                </label>
                <div v-if="form.errors.waterResistant" class="text-red-500 text-xs italic">{{ form.errors.waterResistant }}
                </div>
            </div>

            <div class="mb-4 relative">
                <label for="custom-dropdown" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <button type="button" id="custom-dropdown" @click="toggleDropdown" :aria-expanded="dropdownOpen.toString()"
                    class="w-full flex justify-between bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:shadow-outline">
                    {{ selectedCategory || 'Please select a category' }}
                    <span>🡣</span>
                </button>

                <div v-if="dropdownOpen" class="absolute w-full mt-1 bg-white border border-gray-300 rounded shadow z-10">
                    <div v-for="category in categories" :key="category.id"
                        @click="selectCategory(category.id, category.name)"
                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        {{ category.name }}
                    </div>
                </div>
                <div v-if="form.errors.categoryId" class="text-red-500 text-xs italic">{{ form.errors.categoryId }}</div>
            </div>


            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
        </form>

        <ProductImageUpload v-if="props.product && props.product.id" :productId="props.product.id" />
    </div>
</template>
