const app = Vue.createApp({
    data() {
        return {
            roles: [],
            skills: [],
            courses: [],
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
        },

        getSkills() {
            axios.get("PHP/functionGetAllSkills.php")
                .then(response => {
                if (response.status == 200) {
                    console.log(response.data)
                    this.skills = response.data.records
                }
                })
                .catch(error => {
                console.log(error.message);
                });
        },

        getCourses() {
            axios.get("PHP/functionGetAllCourses.php")
                .then(response => {
                if (response.status == 200) {
                    console.log(response.data)
                    this.courses = response.data.records
                }
                })
                .catch(error => {
                console.log(error.message);
                });
        }

    },
    beforeMount(){
        this.getRoles();
        this.getSkills();
        this.getCourses();
    },
})

const vm = app.mount('#app')
