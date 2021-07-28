<template>
    <shop-layout>
        <template v-slot:content>
            <div class="pt-16">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div v-for="p in products" class="rounded-md shadow-md ">
                        <img :src="p.image" alt="" class="rounded-t-md">
                        <div class="p-3 text-center space-y-3">
                            <h1 class="font-bold text-gray-700">{{ p.name }}</h1>
                            <p class="text-gray-500">{{ p.description.substr(0, 30) + '...' }}</p>
                            <h1 v-if="p.stock > 0" class="font-bold text-gray-500">Stock: {{ p.stock }} {{ p.stock == 1 ? 'unidad' : 'unidades' }} </h1>
                            <h1 v-else class="font-bold text-red-500">No quedan unidades</h1>
                            <h1 class="font-bold text-gray-800" :class="{ 'line-through text-red' : p.stock <= 0 }">${{ p.price }}</h1>

                        </div>
                    </div>
                </div>
            </div>
        </template>
    </shop-layout>
</template>

<script>
import ShopLayout from "../../Layouts/ShopLayout";
export default {
    components: {ShopLayout},
    props: {
        products: Array
    },
    mounted() {
        console.log(this.products)
    }
}
</script>

