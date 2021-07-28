<template>
    <div class="w-full h-full fixed z-10 bg-gray-200 px-4 lg:p-0">
        <div
            class="p-8 relative lg:fixed space-y-4 top-1/4 right-0 lg:right-1/4 bg-white z-20 w-full lg:w-2/4 text-gray-500 font-bold rounded-md shadow-md">
            <div class="space-y-2">
                <label for="email">Usuario</label>
                <input v-model="form.email" id="email" type="text"
                       class="w-full rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 transition duration-200 border border-gray-300 transition duration-200">
            </div>
            <div class="space-y-2">
                <label for="password">Contraseña</label>
                <input :disabled="action_state == false" v-model="form.password" v-on:keyup.enter="submit" id="password"
                       type="password"
                       class="w-full rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 transition duration-200 border border-gray-300">
            </div>
            <div class="flex justify-center">
                <button :disabled="action_state == false" @click="submit"
                        :class="{'bg-blue-500 focus:bg-blue-600 focus:ring-2 focus:ring-blue-600 ' : action_state == true, 'bg-gray-200' : action_state == false}"
                        class="rounded-md text-white px-4 py-2 transition duration-200">Entrar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            action_state: true,
            form: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        submit() {
            if (this.action_state == true) {
                this.action_state = false
                axios.post(route('admin.login'), this.form)
                    .then(({data}) => {
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Usuario validado',
                            timer: 600,
                            showConfirmButton: false
                        })
                            .then(() => window.location = route('products.index'))
                    })
                    .catch((err) => {
                        if (this.form.email == '' || this.form.password == '') {
                            let error = err.response.data;
                            let template = '';

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
                        } else if (err.response.status === 403) {
                            return this.$swal.fire({
                                icon: 'error',
                                title: 'Ooops...',
                                text: 'Usuario o contraseña incorrectos.',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#3B82F6'
                            })
                                .then(() => this.action_state = true)
                        } else {
                            return this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Usuario o contraseña incorrectos.',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#3B82F6'
                            })
                                .then(() => this.action_state = true)
                        }
                    })
            } else {
                this.action_state = false
            }
        }
    }
}
</script>

<style scoped>

</style>
