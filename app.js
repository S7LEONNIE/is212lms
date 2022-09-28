import homepage from './pages/home.js'
import * as pages from './pages/index.js'
import store from './store.js'


export default {
    name: 'App',
    components: Object.assign({homepage}, pages),

    setup() {
        const {watchEffect, onMounted, ref} = Vue;
        const page = ref(null);

        //store management: save $variables to localstorage
        onMounted(() => {
            window.addEventListener('beforeunload', () => {
                Object.keys(store).forEach(function (key){
                    if (key.charAt(0) == "$") {localStorage.setItem(key, store[key]); } else {localStorage.removeItem("$" + key);}
                });
            });
            Object.keys(store).forEach(function (key){
                if (key.charAt(0) == "$") {
                    if (localStorage.getItem(key)) store[key] = localStorage.getItem(key);
                }}
            )           
        })
        
        //url management
        watchEffect(() => {
            const urlpage = window.location.pathname.split("/").pop();
            if (page.value == null) {page.value = urlpage}
            if (page.value != urlpage) {const url = page.value ? page.value : './'; window.history.pushState({url: url}, '', url);                                }
            window.onpopstate = function() {page.value = window.location.pathname.split("/").pop()}; 
        })
        
        return {page, pages}
    },

    template: `
    <div class="Navbar__Wrapper">
        <div class="Navbar">
            <div class="Navbar__Link Navbar__Link-brand">
                LJMS
            </div>
            <div class="Navbar__Link Navbar__Link-toggle" onclick="classToggle()">
                <i class="fas fa-bars"></i>
            </div>

            <nav class="Navbar__Items">
                <template v-for="item, index in pages" key="item.name">
                    <div class="Navbar__Link" v-on:click="page = index">
                        {{ item.name }}
                    </div>
                </template>
            </nav>

            <nav class="Navbar__Items Navbar__Items--right">
                <div class="Navbar__Link">
                    <a href="myjourney.php">My Journey</a>
                </div>
                <div class="Navbar__Link">
                    <a href="profile.php">Hi, xxxx</a>
                </div>
            </nav>
        </div>
    </div>

    <div id="content">
        <component :is="page || 'homepage'"></component>
    </div>
    `,
  };
  