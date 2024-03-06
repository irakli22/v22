<template>
    <div class="container mx-auto">
        <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Image
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="product in products" :key="product.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <img :src="product.imageUrl" alt="Product Image" class="h-10 w-10 rounded-full">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ product.name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link :href="route('productUpload.show', { product: product.id })" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                      <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script setup>
import { ref  } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

const props = usePage();

// const products = props.props.products.data;

const productsref = ref(props.props.products.data);
const productsreactive = ref(props.props.products.data);

const products = ref(props.props.products.data);

// const currentPage = ref(props.products.id);

console.log(products.value);
// console.log(productsreactive);

const editProduct = (id) => {
    // Implement your edit logic here
    console.log(route('productUpload.show', { product: id }))
    // route('image-upload/'+ id);
    route('productUpload.show', { product: id })
}

const deleteProduct = (id) => {
    // Implement your delete logic here
    console.log('Deleting product', id)
}
</script>
  
  