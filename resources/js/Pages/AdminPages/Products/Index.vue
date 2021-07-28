<template>
    <admin-layout>
        <template v-slot:content>
            <div class="flex justify-between mb-16">
                <h1 class="text-2xl font-bold">Products</h1>
                <inertia-link :href="route('products.create')"
                              class="px-4 flex py-2 text-white bg-blue-500 focus:bg-blue-600 focus:ring-2 focus:ring-blue-600 transition duration-200 rounded-md shadow-sm">Crear producto
                </inertia-link>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="w-full text-gray-500 text-sm uppercase">
                    <tr class="w-full border-b border-gray-300 bg-gray-50">
                        <th class="p-4 text-left">Nombre</th>
                        <th class="p-4 text-left">Descripcion</th>
                        <th class="p-4 text-left">Precio</th>
                        <th class="p-4 text-left">Stock</th>
                        <th class="p-4">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="w-full text-gray-600 text-sm">
                    <tr v-for="p in products.data" class="w-full border-b border-gray-300">
                        <td class="p-4">
                            <inertia-link :href="route('products.show', p.id)" class="text-blue-500">
                                {{ p.name.substr(0, 20) + '...' }}
                            </inertia-link>
                        </td>
                        <td class="p-4">{{ p.description.substr(0, 30) + '...' }}</td>
                        <td class="p-4">${{ p.price }}</td>
                        <td class="p-4">{{ p.stock }}</td>
                        <td class="p-4">
                            <div class="flex space-x-4 justify-center">
                                <inertia-link class="text-green-600 hover:text-green-700 focus:text-green-800 " :href="route('products.edit', p.id)">Editar
                                </inertia-link>
                                <button @click="deleteNote(p)" class="text-red-600 hover:text-red-700 focus:text-red-800">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-20">
                <pagination class="mt-6" :links="products.links" />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout";
import Pagination from "../../../Components/Pagination";

export default {
    props: {
        products: Array
    },
    components: {AdminLayout, Pagination},
    methods: {
        deleteNote(note) {
            this.$swal.fire({
                icon: 'warning',
                title: `¿Desea eliminar el producto ${note.name}?`,
                text: 'Esta acción es irreversible.',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar',
            })
            .then((result) => {
                if (result.isConfirmed){
                    axios.delete(route('products.destroy', note.id))
                        .then(() => {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Producto eliminado',
                                showConfirmButton: false,
                                timer: 600
                            })
                            .then(() => window.location = route('products.index'));
                        });
                }
            })
        }
    },

}
</script>

<style scoped>

</style>
