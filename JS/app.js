const app = Vue.createApp({
    data() {
        let journeyCreate = false;
        return {
            journeyCreate,
            roles: [],
            skills: [],
            courses: [],
            learningJourneys: [],
            skillsAndCourses: [],

            roleButtonAction: "",
            new_role_name: "",
            new_role_desc: "",
            new_role_skill: "",

            updateRoleID: "",
            skillButtonAction: "",
            updateSkillID: "",
            designation: "",

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
                course_category: "",

            },
            skillsByCourse: [],
            rolesBySkill: [],

            targetLJs: [],
        }
    },
    // computed: {
    //     isHR() {
    //         return (localStorage.staff_designation == 3)
    //     }
    // },
    methods: {
        isLoggedIn() {
            let staff_id = localStorage.getItem("staff_id");
            this.designation = localStorage.getItem("staff_designation");
            // console.log("isLoggedIn function")
            if (!staff_id && window.location.pathname != "/is212lms/login.html") {
                window.location.href = "/is212lms/login.html";
            }
            else return staff_id;
        },
        ljps_login() {
            let login_staff_id = document.getElementById("login_page_username").value;
            let login_staff_pw = document.getElementById("login_page_password").value;
            
            axios.post("PHP/functionGetStaffByEmail.php",
                {
                    staff_email: login_staff_id 
                }
            )
            .then(response => {
                if (response.status == 200) {
                    console.log(response);
                    localStorage.setItem("staff_id", response.data.records.staff_id);
                    localStorage.setItem("staff_fName", response.data.records.staff_fName);
                    localStorage.setItem("staff_lName", response.data.records.staff_lName);
                    localStorage.setItem("staff_designation", response.data.records.staff_designation);
                    window.location.href = "/is212lms/index.html";
                }
            })
            .catch(error => {
                console.log(error.message);
                console.log("fail");
                alert("Login failed. Please check your email and password.")
            });
            
        },
        ljps_logout() {
            localStorage.removeItem("staff_id");
            localStorage.removeItem("staff_fName");
            localStorage.removeItem("staff_lName");
            localStorage.removeItem("staff_designation");
            window.location.href = "/is212lms/login.html";
        },
        getRoles() {
            axios.get("PHP/functionGetAllRoles.php")
                .then(response => {
                if (response.status == 200) {
                    this.roles = response.data.records;
                    if (rolesTable) {
                        let rolesDT = [];
                        for (let role of this.roles) {
                            let role_array = 
                            [
                                role.role_id, 
                                role.role_name, 
                                role.role_desc, 
                                role.is_active,
                                `
                                <button onclick="vm.roleUpdateBtn(` 
                                    + role.role_id + `, '`
                                    + role.role_name + `', '`
                                    + role.role_desc
                                    + `')" class="admin-role-btn_update">Update</button>
                                <button onclick="vm.roleDeleteBtn(` + role.role_id + `)" >Delete</button>
                                `
                            ];
                            rolesDT.push(role_array);
                        }
                        rolesTable.rows.add(rolesDT).draw();                        
                    }        
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
                    if (skillsTable) {
                        let skillsDT = [];
                        for (skill of this.skills) {
                            let skill_array = 
                            [
                                skill.skill_id, 
                                skill.skill_name, 
                                skill.skill_desc, 
                                skill.is_active,
                                `
                                <button onclick="toggleSkillsModal(); vm.skillButtonAction='update'; vm.updateSkillID=`+skill.skill_id+`"class="admin-skill-btn_update">Update</button>
                                <button onclick="vm.skillDelete(` + skill.skill_id + `)">Delete</button>`
                            ];
                            skillsDT.push(skill_array);
                        }
                        skillsTable.rows.add(skillsDT).draw();                        
                    }        
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

        getLJbyStaffId() {
            let input_staff_id = localStorage.staff_id;

            if (!input_staff_id) { return; }

            // console.log("getLJ " + input_staff_id);
            axios.post("PHP/functionGetLJByStaffId.php", 
            {
                staff_id: input_staff_id
            })
                .then(response => {
                if (response.status == 200) {
                    // console.log(response.data);
                    this.learningJourneys = response.data.records
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
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("fail");
                });
        },

        getRoleById(role_id = null) {
            if (!role_id) {
                // url: 'skeleton_view_one_role?role_id=1&foo=1&bar=2');
                let urlParams = window.location.search.substring(1).split("&");
                let params = {};
                for (let param of urlParams) {
                    let temp = param.split("=");
                    let key = temp[0];
                    let val = temp[1];
                    params[key] = val;
                }
                role_id = params.role_id;
            }

            if (role_id) {
                try {
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
                    this.role_details_exists = false;
                }
            }
            else {this.role_details_exists = false;}
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

            let skill_id = params.skill_id;
            if(skill_id) {
                try {
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
                    this.skill_details_exists = false;
                }
            }
            else {this.skill_details_exists = false;}
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

            let course_id = params.course_id;
            if (course_id) {
                try {
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
                    this.course_details_exists = false;
                }
            }
            else {this.course_details_exists = false;}
        },

        roleNewBtn() {
            this.roleButtonAction = 'new';
            this.new_role_name = '';
            this.new_role_desc = '';
            this.skillsByRole = [];
        },

        roleUpdateBtn(role_id, role_name, role_desc) {
            this.roleButtonAction = 'update';
            this.updateRoleID = role_id;
            this.new_role_name = role_name;
            this.new_role_desc = role_desc;
            this.getRoleById(role_id);
            $('.admin-model_header .title').text('Update Role');
            $('.admin-model.role').toggle();
        },

        roleDeleteBtn(role_id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to undo this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.post("PHP/functionDeleteRole.php", {
                        role_id: role_id
                    })
                        .then(response => {
                        if (response.status == 200) {
                            console.log('successful deleted role');
                        }
                        })
                        .catch(error => {
                        console.log(error.message);
                        console.log("fail");
                        });
                    swal("Deleted", {
                    icon: "success",
                });
                }
            });
        },
        skillDelete(skill_id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to undo this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.post("PHP/functionDeleteSkills.php", {
                        skill_id: skill_id
                    })
                        .then(response => {
                        if (response.status == 200) {
                            console.log('successful deleted skill');
                        }
                        })
                        .catch(error => {
                        console.log(error.message);
                        console.log("fail");
                        });
                    swal("Deleted", {
                    icon: "success",
                });
                }
            });
        },
        createRole(){
            let role_name = this.new_role_name;
            let role_desc = this.new_role_desc;
            let role_skills_w_dup = this.skillsByRole;
            let role_skills = [];
            for (let skill of role_skills_w_dup) {
                let skill_id = skill['skill_id'];
                if (!role_skills.includes(skill_id) ) {
                    role_skills.push(skill_id)
                }
            }

            axios.post("PHP/functionAddRole.php", {
                role_name: role_name,
                role_desc: role_desc,
                role_skills: role_skills
            })
                .then(response => {
                if (response.status == 200) {
                    console.log('successful add role');
                    console.log(response)
                    window.location.reload();
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("fail");
                });
        },
        updateRole(var_role_id){
            let role_name = this.new_role_name;
            let role_desc = this.new_role_desc;
            let role_skills_w_dup = this.skillsByRole;
            let role_skills = [];
            for (let skill of role_skills_w_dup) {
                let skill_id = skill['skill_id'];
                if (!role_skills.includes(skill_id) ) {
                    role_skills.push(skill_id)
                }
            }

            axios.post("PHP/functionUpdateRole.php", {
                    role_name: role_name,
                    role_desc: role_desc,
                    role_id: var_role_id,
                    role_skills: role_skills
            })
                .then(response => {
                if (response.status == 200) {
                    console.log(response);
                    console.log("Successfully Updated Role");
                    window.location.reload();
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("Update role fail");
                });
        },
        updateSkill(var_skill_id){
            let skill_name = document.getElementById('new_skill_name').value;
            let skill_desc = document.getElementById('new_skill_desc').value;
            axios.post("PHP/functionUpdateSkills.php", {
                    skill_name: skill_name,
                    skill_desc: skill_desc,
                    skill_id: var_skill_id
            })
                .then(response => {
                if (response.status == 200) {
                    console.log("Successfully Updated Skill");
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("Update Skill fail");
                });
        },
        createSkill(){
            let skill_name = document.getElementById('new_skill_name').value;
            let skill_desc = document.getElementById('new_skill_desc').value;
            axios.post("PHP/functionAddSkills.php", {
                skill_name: skill_name,
                skill_desc: skill_desc,
            })
                .then(response => {
                if (response.status == 200) {
                    console.log('successful add skills');
                    console.log(response)
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("fail");
                });

        },
        removingLearningJourney(){
            let lj_name = document.getElementById('lj_name').value;
            axios.post("PHP/functionDeleteLearningJourney.php", {
                lj_name: lj_name,
            })
                .then(response => {
                if (response.status == 200) {
                    console.log('successful remove learning journey');
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("fail");
                });
        },
        addCourseToLJs() {
            console.log(this.course_details);
            console.log(this.targetLJs);
            let course_id = this.course_details.course_id;
            
            axios.post("PHP/functionAddCourseToLJ.php", {
                course_id: course_id,
                lj_list: this.targetLJs
            })
                .then(response => {
                if (response.status == 200) {
                    console.log(response);
                    console.log('successful add course to LJ');
                }
                })
                .catch(error => {
                console.log(error.message);
                console.log("fail");
                });
        },
    },
    beforeMount(){
        this.isLoggedIn();
        this.getRoles();
        this.getSkills();
        this.getCourses();
        this.getLJbyStaffId();
        this.getSkillsAndCourses();
        this.getRoleById();
        this.getCourseById();
        this.getSkillById();
    },
})

app.component('navbar-component', {
    template: `
    <div class="Navbar__Wrapper">
        <div class="Navbar">
            <div class="Navbar__Link Navbar__Link-brand">
                LJMS
            </div>
            <div onclick="classToggle()" class="Navbar__Link Navbar__Link-toggle">
                <i class="fas fa-bars"></i>
            </div>

            <nav class="Navbar__Items">
                <div class="Navbar__Link">
                    <a href="index.html">Home</a>
                </div>
                <div class="Navbar__Link">
                <a href="role.html">Role</a>
                </div>
                <div class="Navbar__Link">
                <a href="skills_course_search.html">Skills/Courses</a>
                </div>
                <div v-if="designation==2 || designation==3"class="Navbar__Link">
                <a href="admin.html">Edit Roles/Skills</a>
                </div>
            </nav>

            <nav class="Navbar__Items Navbar__Items--right">
                <div class="Navbar__Link">
                    <a href="myjourney.html">My Journeys</a>
                </div>
                <div class="Navbar__Link">
                    <a href="#" v-on:click="ljps_logout">Logout</a>
                </div>
            </nav>
        </div>
    </div>`
})

const vm = app.mount('#app')
