<template>
    <admin-layout>
        <template v-slot:content>
            <div class="flex justify-between mb-16">
                <h1 class="text-2xl font-bold">Users</h1>
            </div>
            <div v-if="users.data.length <= 0" class="text-2xl font-bold text-center">No hay usuarios :(</div>
            <div v-else class="w-full overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="w-full text-gray-500 text-sm uppercase">
                    <tr class="w-full border-b border-gray-300 bg-gray-50">
                        <th class="p-4 text-left">Nombre</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Fecha de creación</th>
                        <th class="p-4">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="w-full text-gray-600 text-sm">
                    <tr v-for="p in users.data" class="w-full border-b border-gray-300">
                        <td class="p-4">{{ p.name.substr(0, 20) + '...' }}</td>
                        <td class="p-4">{{ p.email }}</td>
                        <td class="p-4">{{ p.created_at }}</td>
                        <td class="p-4">
                            <div class="flex space-x-4 justify-center">
                                <button @click="deleteUser(p)" class="text-red-600 hover:text-red-700 focus:text-red-800">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-20">
                <pagination class="mt-6" :links="users.links" />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout";
import Pagination from "../../../Components/Pagination";

export default {
    props: {
        users: Array
    },
    components: {AdminLayout, Pagination},
    methods: {
        deleteUser(user) {
            this.$swal.fire({
                icon: 'warning',
                title: `¿Desea eliminar el usuario ${user.email}?`,
                text: 'Esta acción es irreversible.',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar',
            })
                .then((result) => {
                    if (result.isConfirmed){
                        axios.delete(route('users.destroy', user.id))
                            .then(() => {
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'Usuario eliminado',
                                    showConfirmButton: false,
                                    timer: 600
                                })
                                    .then(() => window.location = route('users.index'));
                            });
                    }
                })
        }
    },

}
</script>

<style scoped>

</style>
