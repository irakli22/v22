<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Product from '@/Components/Product/Product.vue';
import { Head } from '@inertiajs/vue3';

</script> 

<template>
    <Head title="Product" />

    <AuthenticatedLayout>
        <Product />
    </AuthenticatedLayout>
</template>