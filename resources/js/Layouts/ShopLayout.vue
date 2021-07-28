<template>
    <!--#login-modal-->
    <login-component v-on:close-modal="closeLoginModal" v-show="openModal" v-if="openModal == true"></login-component>
    <!--#header-->
    <div class="h-16 fixed z-10 w-full shadow-md px-2 py-1 bg-blue-500 text-white flex items-center justify-between">
        <h1 class="text-xl">Title</h1>
        <button @click="openMenuModal" v-if="$page.props.user" class="rounded-full h-12 w-12 bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 24 24" stroke-width="2"
                 stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
            </svg>
        </button>
        <button @click="openModal = !openModal" v-else>
            <h1 class="underline">¿No estás logeado? Logea</h1>
        </button>
    </div>
    <!--#options-->
    <div v-show="openMenu" v-if="$page.props.user" class="fixed z-20 top-16 right-2 menu transform scale-75 opacity-0 translate-y-0 text-gray-700 font-bold origin-top-right transition duration-300 bg-white rounded-md shadow-md border border-gray-300 py-6">
        <div class="p-2 border-b border-gray-300 ">Hola, {{ user.name }}</div>
        <button @click="logout" class="mt-4 p-2 w-full hover:bg-gray-100 transition duration-200 flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
            </svg>
            <h1>Cerrar sesión</h1>
        </button>
    </div>
    <!--#content-->
    <div class="pt-16 px-8">
        <slot name="content"></slot>
    </div>
</template>

<script>
import LoginComponent from "../Pages/ShopPages/LoginComponent";

export default {
    components: {LoginComponent},
    data() {
        return {
            openModal: false,
            openMenu: false,
        }
    },
    computed: {
        user(){
            return this.$page.props.auth.user
        }
    },
    methods: {
        openMenuModal(){
          if (this.openMenu == false) {
              this.openMenu = !this.openMenu
              let sc = document.querySelector('.menu.scale-75.opacity-0')
              setTimeout(() => {
                  sc.classList.remove('scale-75')
                  sc.classList.add('scale-100')
                  sc.classList.remove('opacity-0')
                  sc.classList.add('opacity-100')
              }, 100);
          } else {
              let sc = document.querySelector('.menu.scale-100.opacity-100')
              sc.classList.remove('scale-100')
              sc.classList.add('scale-75')
              sc.classList.remove('opacity-100')
              sc.classList.add('opacity-0')
              this.openMenu = !this.openMenu
          }
        },
        logout() {
            axios.post(route('logout'), [])
                .then(() => window.location = route('home'))
        },
        closeLoginModal() {
            if (this.openModal == true) {
                let close = document.querySelector('.modal.scale-100')
                setTimeout(() => {
                    close.classList.remove('scale-100')
                    close.classList.add('scale-0')
                }, 100);
                setTimeout(() => this.openModal = !this.openModal, 600);
            }
        }
    },
}
</script>

<style scoped>

</style>
