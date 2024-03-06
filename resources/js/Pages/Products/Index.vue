<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Products from '@/Components/Products.vue';
import { Head } from '@inertiajs/vue3';

</script> 

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <Products />
    </AuthenticatedLayout>
</template>