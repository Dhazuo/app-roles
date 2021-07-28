<template>
    <div class="w-full h-full p-12 bg-black bg-opacity-50 fixed z-30 flex justify-center">
        <div class="w-full lg:w-1/4 relative transition duration-500 modal transform scale-0 h-auto bg-white rounded-md p-6 text-sm text-gray-600 font-bold text-center">
            <button @click="closeModal" class="absolute rounded-full h-8 w-8 bg-gray-200 top-2 right-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x w-full h-full" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <h1 class="font-bold text-xl mb-12">Inicia sesión</h1>
            <div class="space-y-4 text-center">
                <div class="space-y-2">
                    <label for="email">Email</label>
                    <input v-model="form.email" id="email" type="text" class="w-full border border-gray-300 rounded-md shadow-sm transition duration-200">
                </div>
                <div class="space-y-2">
                    <label for="password">Password</label>
                    <input :disabled="action_state == false" @keydown.enter="submit" v-model="form.password" id="password" type="password" class="w-full border border-gray-300 rounded-md shadow-sm transition duration-200">
                </div>
                <div class="flex justify-center">
                    <button :disabled="action_state == false" @click="submit"
                            :class="{'bg-blue-500 focus:bg-blue-600 focus:ring-2 focus:ring-blue-600 ' : action_state == true, 'bg-gray-200' : action_state == false}"
                            class="rounded-md text-white px-4 py-2 transition duration-200">Entrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            action_state: true,
            form: {
                email: '',
                password: ''
            }
        }
    },
    mounted() {
        if (document.querySelector('.modal.scale-0')){
            let sca = document.querySelector('.modal.scale-0')
            setTimeout(() => {
                sca.classList.remove('scale-0')
                sca.classList.add('scale-100')
            }, 100)
        }
    },
    methods: {
        closeModal(){
          this.$emit('close-modal')
        },
        submit(){
            if (this.action_state == true) {
                this.action_state = false
                axios.post(route('user.login'), this.form)
                    .then(({data}) => {
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Usuario validado',
                            timer: 600,
                            showConfirmButton: false
                        })
                            .then(() => window.location = route('home'))
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
                        }
                        else {
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
