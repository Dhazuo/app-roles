<template>
    <admin-layout>
        <template v-slot:content>
            <div class="flex justify-between mb-16">
                <h1 class="text-2xl font-bold ">Mirando product: {{ product.name }}</h1>
                <inertia-link :href="route('products.index')"
                              class="px-4 py-2 bg-white rounded-md shadow-sm border border-gray-300 hover:bg-gray-100 focus:bg-gray-200 transition duration-200">
                    Regresar
                </inertia-link>
            </div>
            <div class="w-full space-y-4 text-center">
                <div class="w-full flex justify-center">
                    <img v-if="product.image.includes('https')" :src="product.image" alt="">
                    <img v-else :src="'/' + product.image" alt="">
                </div>
                <h1 class="text-gray-600 font-bold">{{ product.name }}</h1>
                <p class="text-gray-400 font-bold">{{ product.description }}</p>
                <h1 class="text-gray-600 font-bold">${{ product.price }}</h1>
                <h1 class="text-gray-600 font-bold">Stock: {{ product.stock }}</h1>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout";
export default {
    name: "Show",
    components: {AdminLayout},
    props: {
        product: Object
    }
}
</script>

<style scoped>

</style>
