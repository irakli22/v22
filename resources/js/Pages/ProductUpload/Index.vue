<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductUpload from '@/Components/ProductUpload.vue';
import { Head } from '@inertiajs/vue3';



</script> 

<template>
    <Head title="Product uploads" />

    <AuthenticatedLayout>
        <ProductUpload />
    </AuthenticatedLayout>
</template>