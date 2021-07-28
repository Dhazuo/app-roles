<template>
    <admin-layout>
        <template v-slot:content>
            <h1 class="text-2xl font-bold mb-16">Creando producto</h1>
            <div class="w-full space-y-4">
                <div class="space-y-2">
                    <label for="name" class="text-gray-500 font-bold">Nombre</label>
                    <input v-model="product_form.name" type="text" id="name"
                           class="transition duration-200 rounded-md shadow-sm border border-gray-300 w-full px-2 focus:border-blue-500 focus:ring-0">
                </div>
                <div class="space-y-2">
                    <label for="description" class="text-gray-500 font-bold">Descripción</label>
                    <textarea v-model="product_form.description" type="text" id="description" rows="4"
                              class="transition duration-200 rounded-md shadow-sm border border-gray-300 w-full px-2 focus:border-blue-500 focus:ring-0"></textarea>
                </div>
                <div class="flex space-x-2">
                    <label class="text-gray-500 font-bold">Imagen:</label>
                    <input v-if="product_form.image == null" type="file" accept="image/*" @change="onFileChange"
                           class="">
                </div>
                <div class="">
                    <h1 v-if="product_form.image == null" class="text-red-500">No has seleccionado ninguna imagen</h1>
                    <div v-else class="space-y-2">
                        <img v-if="product_form.image.includes('https')" :src="product_form.image" alt="">
                        <img v-else :src="new_image == true ? '/' + product_form.image : product_form.image" alt="">
                        <button @click="removeImage" class="py-2 px-4 bg-gray-200 text-black rounded-md ">Quitar imagen</button>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="price" class="text-gray-500 font-bold">Precio</label>
                    <div class="flex items-center">
                        <h1 class="font-bold rounded-l-md py-2 px-4 border border-gray-300 bg-gray-300">$</h1>
                        <input v-model="product_form.price" type="number" id="price"
                               class="transition duration-200 rounded-r-md shadow-sm border border-gray-300 px-2 focus:border-blue-500 focus:ring-0">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="stock" class="block text-gray-500 font-bold">Stock</label>
                    <input v-model="product_form.stock" type="number" id="stock"
                           class="transition duration-200 block rounded-md shadow-sm border border-gray-300 px-2 focus:border-blue-500 focus:ring-0">
                </div>
                <div class="space-x-2 flex justify-center">
                    <inertia-link :href="route('products.index')"
                                  class="px-4 py-2 bg-white rounded-md shadow-sm border border-gray-300 hover:bg-gray-100 focus:bg-gray-200 transition duration-200">
                        Regresar
                    </inertia-link>
                    <button :disabled="action_state == false" @click="save"
                            :class="{'bg-blue-500 focus:bg-blue-600 focus:ring-2 focus:ring-blue-600 ' : action_state == true, 'bg-gray-200' : action_state == false}"
                            class="rounded-md text-white px-4 py-2 transition duration-200">Guardar
                    </button>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout";

export default {
    components: {AdminLayout},
    props: {
        product: Object,
    },
    mounted() {
            console.log(this.product)
        },
    data() {
        return {
            action_state: true,
            new_image: true,
            product_form: {
                image: this.product.image,
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                stock: this.product.stock
            },
        }
    },
    watch: {
        product_form: {
            handler: function () {
                if (this.product_form.price < 0) {
                    alert('No se puede colocar un precio menor a $1')
                    this.product_form.price = 0
                }
                if (this.product_form.stock < 0) {
                    alert('No se puede colocar un stock menor a 0')
                    this.product_form.stock = 0
                }
            },
            deep: true
        }
    },
    methods: {
        save() {
            if (this.action_state == true) {
                this.action_state = false

                let number = parseInt(this.product_form.stock)
                this.product_form.stock = number

                axios.put(route('products.update', this.product.id), this.product_form)
                    .then(({data}) => {
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Información editada con éxito',
                            showConfirmButton: false,
                            timer: 600
                        })
                            .then(() => {
                                window.location = route('products.index')
                            });
                    })
                    .catch((err) => {
                        let error = err.response.data
                        let template = ''

                        Object.keys(error.errors).forEach((key) => {
                            template += `<li class="mb-2">${error.errors[key]}</li>`
                        });

                        return this.$swal.fire({
                            icon: 'error',
                            title: 'Ooops...',
                            html: `<ul>${template}</ul>`,
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })
                            .then(() => this.action_state = true);
                    })
            } else {
                this.action_state = false
            }
        },

        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();

            reader.onload = (e) => {
                this.product_form.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage(){
            this.product_form.image = null
            this.new_image = false
        }
    }
}
</script>

<style scoped>

</style>
