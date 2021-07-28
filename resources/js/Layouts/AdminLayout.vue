<template>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <div class="hidden lg:block col-span-1 h-full bg-gray-700 text-white font-bold space-y-4">
            <div class="h-16 border-b border-white"></div>
            <navlink-component :href="route('products.index')" :active="route().current('products.index')">
                Index
            </navlink-component>
        </div>
        <div class="col-span-5 ">
            <div class="px-4 h-16 w-full fixed lg:relative flex justify-between lg:justify-end items-center py-1 border border-gray-300 bg-gray-700 lg:bg-white  shadow-sm">
                <button @click="sidebarAction" class="text-white p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="4" y1="6" x2="20" y2="6"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="18" x2="20" y2="18"></line>
                    </svg>
                </button>
                <button @click="openMenuModal" class="rounded-full w-12 h-12 bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </button>
            </div>
            <div class="px-4 py-6 content transition duration-900 opacity-0">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
    <!--#sidebar-->
    <div v-show="sidebar" @click="sidebarAction" class="fixed top-0 w-full h-full bg-black bg-opacity-50 z-30 block lg:hidden"></div>
    <div v-show="sidebar" class="fixed top-0 w-1/2 h-full text-white bg-gray-700 z-40 side -translate-x-full block lg:hidden transition duration-500">
        <button @click="sidebarAction" class="absolute p-2 text-white top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="4" y1="12" x2="14" y2="12"></line>
                <line x1="4" y1="12" x2="8" y2="16"></line>
                <line x1="4" y1="12" x2="8" y2="8"></line>
                <line x1="20" y1="4" x2="20" y2="20"></line>
            </svg>
        </button>
        <div class="space-y-4 mt-8">
            <navlink-component class="block" :href="route('products.index')" :active="route().current('products.index')">
                Index
            </navlink-component>
        </div>
    </div>
    <!--#options-->
    <div v-show="openMenu" v-if="$page.props.user" class="fixed lg:absolute z-20 top-16 right-2 menu transform scale-75 opacity-0 translate-y-0 text-gray-700 font-bold origin-top-right transition duration-300 bg-white rounded-md shadow-md border border-gray-300 py-6">
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

</template>

<script>
import NavlinkComponent from "../Components/NavlinkComponent";
export default {
    components: {NavlinkComponent},
    data(){
        return{
            openMenu: false,
            sidebar: false,
        }
    },
    mounted() {
        let op = document.querySelector('.content.opacity-0')
        setTimeout(() => {
           op.classList.remove('opacity-0');
           op.classList.add('opacity-100');
        }, 100);
    },
    methods: {
        logout(){
            axios.post(route('logout'), [])
                .then(() => window.location = route('admin.login'))
        },
        sidebarAction(){
            if (this.sidebar == false) {
                this.sidebar = !this.sidebar
                let side = document.querySelector('.side.-translate-x-full');
                setTimeout(() => {
                    side.classList.remove('-translate-x-full');
                    side.classList.add('translate-x-0');
                }, 100)
            } else {
                let side = document.querySelector('.side.translate-x-0');
                setTimeout(() => {
                    side.classList.remove('translate-x-0');
                    side.classList.add('-translate-x-full');
                }, 100)
                setTimeout(() => this.sidebar = !this.sidebar, 600)
            }
        },
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
    },
    computed: {
        user(){
            return this.$page.props.auth.user
        }
    },
}
</script>

<style scoped>

</style>
