<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductList from '@/Components/ProductList.vue';
import { Head } from '@inertiajs/vue3';

</script> 

<template>
    <Head title="ProductList" />

    <AuthenticatedLayout>
        <ProductList />
    </AuthenticatedLayout>
</template>