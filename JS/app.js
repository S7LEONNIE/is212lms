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
            skillsByRole: [],

            skill_details_exists: true,
            skill_details: {
                skill_id: "",
                skill_name: "",
                skill_desc: ""
            },
            coursesBySkill: [],

            course_details_exists: true,
            course_details: {
                course_id: "",
                course_name: "",
                course_desc: "",
                course_status: "",
                course_type: "",
                course_category: ""
            },
            skillsByCourse: [],
            rolesBySkill: [],
        }
    },
    methods: {
        getRoles() {
            axios.get("PHP/functionGetAllRoles.php")
                .then(response => {
                if (response.status == 200) {
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
                    this.skillsAndCourses = response.data.records;
                    console.log("abc");
                    console.log(response.data.records);
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("fail");
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
                        this.role_details_exists = true;
                        this.role_details = response.data.records;
                    }
                    })
                    .catch(error => {
                    console.log(error.message);
                    console.log(error.response.data.status);
                    this.role_details_exists = false;
                    });

                axios
                .post("PHP/functionGetSkillsByRole.php", {
                    roleId: role_id,
                })
                .then(response => {
                    if (response.status == 200) {
                        this.skillsByRole = response.data.records
                    }
                })
                .catch(error => {
                    console.log(error.message);
                });
            }

            catch {
                this.role_details_exists = false
            }
        },

        getSkillById() {
            // url: 'skeleton_view_one_course?course_id=1&foo=1&bar=2');
            let urlParams = window.location.search.substring(1).split("&");
            let params = {};
            for (let param of urlParams) {
                let temp = param.split("=");
                let key = temp[0];
                let val = temp[1];
                params[key] = val;
            }

            try {
                let skill_id = params.skill_id;

                axios.post("PHP/functionGetSkillById.php",
                {
                    skill_id: skill_id
                })
                .then(response => {
                    if (response.status == 200) {
                        this.skill_details_exists = true;
                        this.skill_details = response.data.records;
                    }
                })
                .catch(error => {
                    console.log(error.message);
                    console.log(error.response.data.status);
                    this.skill_details_exists = false;
                });

                axios.post("PHP/functionGetCoursesBySkill.php", {
                    skill_id: skill_id,
                })
                .then(response => {
                    if (response.status == 200) {
                        this.coursesBySkill = response.data.records
                    }
                })
                .catch(error => {
                    console.log(error.message);
                });
            }
            catch {
                this.skill_details_exists = false
            }
        },
        
        getCourseById() {
            // url: 'skeleton_view_one_course?course_id=1&foo=1&bar=2');
            let urlParams = window.location.search.substring(1).split("&");
            let params = {};
            for (let param of urlParams) {
                let temp = param.split("=");
                let key = temp[0];
                let val = temp[1];
                params[key] = val;
            }

            try {
                let course_id = params.course_id;

                axios.post("PHP/functionGetCourseById.php",
                {
                    course_id: course_id
                })
                    .then(response => {
                    if (response.status == 200) {
                        this.course_details_exists = true;
                        this.course_details = response.data.records;
                    }
                    })
                    .catch(error => {
                    console.log(error.message);
                    console.log(error.response.data.status);
                    this.course_details_exists = false;
                    });

                axios
                .post("PHP/functionGetSkillsByCourse.php", {
                    course_id: course_id,
                })
                .then(response => {
                    if (response.status == 200) {
                        this.skillsByCourse = response.data.records

                        for (let skill of this.skillsByCourse) {
                            axios
                            .post("PHP/functionGetRolesBySkill.php", {
                                skill_id: skill.skill_id,
                            })
                            .then(response => {
                                if (response.status == 200) {
                                    this.rolesBySkill.push(...response.data.records);
                                }
                            })
                            .catch(error => {
                                console.log(error.message);
                            });
                        }
                    }
                })
                .catch(error => {
                    console.log(error.message);
                });

            }

            catch {
                this.course_details_exists = false
            }
        },

        roleDelete() {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to undo this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Deleted", {
                    icon: "success",
                });
                }
            });
        }

    },
    beforeMount(){
        this.getRoles();
        this.getSkills();
        this.getCourses();
        this.getSkillsAndCourses();
        this.getRoleById();
        this.getCourseById();
        this.getSkillById();
    },
})

const vm = app.mount('#app')
