const app = Vue.createApp({
    data() {
        let journeyCreate = false;
        return {
            journeyCreate,
            roles: [],
            skills: [],
            courses: [],
            skillsAndCourses: [],
            role_details_exists: true,
            role_details: {
                role_id: "",
                role_name: "",
                role_desc: ""
            },
            skillsByRole: []
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
        },

        getSkillsAndCourses() {
            axios.get("PHP/functionGetSkillsAndCourses.php")
                .then(response => {
                if (response.status == 200) {
                    console.log(response.data)
                    this.skillsAndCourses = response.data.records;
                }
                })
                .catch(error => {
                console.log(error.message);
                });
        },
        
        getRoleById() {
            // url: 'skeleton_view_one_role?role_id=1&foo=1&bar=2');
            let urlParams = window.location.search.substring(1).split("&");
            let params = {};
            for (let param of urlParams) {
                let temp = param.split("=");
                let key = temp[0];
                let val = temp[1];
                params[key] = val;
            }
            
            try {
                let role_id = params.job_id;

                axios.post("PHP/functionGetRoleById.php", 
                {
                    role_id: role_id
                })
                    .then(response => {
                    if (response.status == 200) {
                        console.log(response.data);
                        role_details_exists = true;
                        this.role_details = response.data.records;
                    }
                    })
                    .catch(error => {
                    console.log(error.message);
                    console.log(error.response.data.status);
                    role_details_exists = false;
                    });
    
                axios
                .post("PHP/functionGetSkillsByRole.php", {
                    roleId: role_id,
                })
                .then(response => {
                    if (response.status == 200) {
                        console.log(response.data)
                        this.skillsByRole = response.data.records
                    }
                })
                .catch(error => {
                    console.log(error.message);
                });
            }
            
            catch {
                role_details_exists = false
            }
        }

    },
    beforeMount(){
        this.getRoles();
        this.getSkills();
        this.getCourses();
        this.getSkillsAndCourses();
        this.getRoleById();
    },
})

const vm = app.mount('#app')
