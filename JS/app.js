const app = Vue.createApp({
    data() {
        return {
            roles: [],
        }
    },
    methods: {
        getRoles() {
            axios.get("PHP/functionGetAllRoles.php")
                .then(response => {
                if (response.status == 200) {
                    console.log(response.data)
                    this.roles = response.data.records
                }
                })
                .catch(error => {
                console.log(error.message);
                });
        }
    },
    beforeMount(){
        this.getRoles();
    },
})

const vm = app.mount('#app')
