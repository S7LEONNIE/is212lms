drop database if exists SPM_LJMS_DB;
create database SPM_LJMS_DB;
use SPM_LJMS_DB;

create table staff (
    staff_id integer primary key,
    staff_fname varchar(50),
    staff_lname varchar(50),
    email varchar(50),
    designation integer
);

insert into staff (staff_id, staff_fname, staff_lname, email, designation) values 
    (1, 'John', 'Doe', 'john.doe@gmail.com', 1),
    (2, 'Edel',  'Weiss', 'edel.weiss@gmail.com', 3),
    (3, 'Simron', 'Ferzair', 'simron.ferzair@gmail.com', 1),
    (4, 'Elro', 'Robins', 'elro.robins@gmail.com', 3),
    (5, 'Annaliese', 'Fair', 'annaliese.fair@gmail.com', 2),
    (6, 'Therrus', 'Lyrandar', 'therrus.lyrandar@gmail.com', 3),
    (7, 'Lorentz', 'Kramer', 'lorentz.kramer@gmail.com', 2),
    (8, 'Linnaeus', 'de Cona', 'linnaeus.decona@gmail.com', 3),
    (9, 'Ceiren', 'Reyn', 'ceiren.reyn@gmail.com', 2),
    (10, 'Ochrus', 'Athodo', 'ochrus.athodo@gmail.com', 3),
    (11, 'Oscar', 'Bonnheim', 'oscar.bonnheim@gmail.com', 1),
    (12, 'Violyn', 'von Volkslied', 'violyn.vonvolkslied@gmail.com', 3);

create table department (
    dept_id integer auto_increment primary key,
    dept_name varchar(50)
);

insert into department (dept_id, dept_name) values
    (1, 'Sales'),
    (2, 'Operations'),
    (3, 'HR'),
    (4, 'Finance'),
    (5, 'IT'),
    (6, 'Manager');

create table department_staff (
    department_id integer,
    staff_id integer,
    is_manager integer,
    PRIMARY KEY (department_id, staff_id),
	constraint department_staff_fk1 foreign key(staff_id) references staff(staff_id),
    constraint department_staff_fk2 foreign key(department_id) references department(dept_id)
);

insert into department_staff (department_id, staff_id, is_manager) values
    (1, 1, 0),
    (1, 2, 1),
    (2, 3, 0),
    (2, 4, 1),
    (3, 5, 0),
    (3, 6, 1),
    (4, 7, 0),
    (4, 8, 1),
    (5, 9, 0),
    (5, 10, 1),
    (6, 11, 0),
    (6, 12, 1);

create table role (
    role_id integer auto_increment primary key,
    role_name varchar(50),
    role_desc varchar(255),
    is_active varchar(50)
);

insert into role (role_id, role_name, role_desc, is_active) values
    (1, "Engineer", "This role is good at engineering.","active"),
    (2, "Manager", "This role is good at managing.", "active"),
    (3, "IT Developer", "This role is good at web development.", "active"),
    (4, "Death, Destroyer of Worlds", "This role is good at petting kittens.", "active");

create table learning_journey (
    lj_id integer auto_increment primary key,
    lj_name varchar(50),
    staff_id integer,
    role_id integer,
    constraint learning_journey_fk1 foreign key(staff_id) references staff(staff_id),
    constraint learning_journey_fk2 foreign key(role_id) references role(role_id)
);

insert into learning_journey (lj_id, lj_name, staff_id, role_id) values
    (1, "John's Learning Journey", 1, 1),
    (2, "Edel's Learning Journey", 2, 2),
    (3, "Simron's Learning Journey", 3, 3),
    (4, "Elro's Learning Journey", 4, 4);

create table skill (
    skill_id integer auto_increment primary key,
    skill_name varchar(50),
    skill_desc varchar(255),
    is_active varchar(50)
);

insert into skill (skill_id, skill_name, skill_desc, is_active) values
    (1, "Engineering", "This skill makes you good at engineering.", "active"),
    (2, "Communications", "This skills makes you good at communication.", "active"),
    (3, "Super Communications", "This skills makes you very good at communication.", "active"),
    (4, "SQL", "This skill makes you good at DBMS.", "active"),
    (5, "Meteor Swarm", "This skill does 40d6 fire and bludgeoning damage to all creatures in the area.", "active"),
    (6, "Lightning Bolt", "This skill does 8d6 lightning damage in a 100ft line", "active"),
    (7, "Operator", "This skill makes you good at operations.", "active"),
    (8, "Technical Photography", "This skill makes you good at the Hardware equipment aspects of photography.", "active"),
    (9, "Marketing", "This skill makes you good at Digital Marketing.", "active"),
    (10, "Network Security", "This skill makes you good at implementing Network Security.", "active");

create table course (
    course_id varchar(10) primary key,
    course_name varchar(50),
    course_desc varchar(255),
    course_status varchar(15),      -- boolean. Tracks active/retired courses
    course_type varchar(10),        -- boolean, tracks internal/external courses
    course_category varchar(50)
);

insert into course (course_id, course_name, course_desc,
                    course_status, course_type, course_category) values
    (1, "Engineering Course", "This is about engineering",
    "Active", "Internal", "Engineering"),
    (2, "Super Engineering Course", "This is about rocket science",
    "Active", "Internal", "Engineering"),
    (3, "Communications Course", "This is about communication",
    "Active", "External", "Communications"),
    (4, "Management Communications Course", "This is an SMU course",
    "Active", "External", "Super Communications"),
    (5, "SQL Course", "This is a course about SQL",
    "Active", "Internal", "Database"),
    (6, "Retired SQL Course", "This is half a course about SQL",
    "Retired", "Internal", "Database"),
    (7, "Defense against the Dark Arts", "This is a course about magic",
    "Active", "External", "Magic"),
    (8, "Operations Course", "This is a course about Operations",
    "Active", "Internal", "Operations"),
    (9, "Workplace Conflict Management for Professionals", "This course will address the gaps to build consensus and utilise knowledge of conflict management techniques to diffuse tensions and achieve resolutions effectively in the best interests of the organisation.", 
    "Active","External", "Management"),
    (10, "Canon MFC Mainteance and Troubleshooting", "Troubleshoot and fixing L2,3 issues of Canon ImageRUNNER series of products",
    "Active", "Internal", "Technical"),
    (11, "Optimising Your Brand For The Digital Spaces", "Digital has fundamentally shifted communication between brands and their consumers from a one-way broadcast to a two-way dialogue. In a hastened bid to transform their businesses to be digital market-ready.",
    "Active", "External", "Sales"),
    (12, "Network Security", "Understanding of the fundamental knowledge of network security including cryptography, authentication and key distribution. The security techniques at various layers of computer networks are examined.",
    "Active", "External", "Technical");

create table course_skill (
    course_id varchar(10),
    skill_id integer,
    PRIMARY KEY (course_id, skill_id),
	constraint course_skill_fk1 foreign key(course_id) references course(course_id),
    constraint course_skill_fk2 foreign key(skill_id) references skill(skill_id)
);

insert into course_skill (course_id, skill_id) values
    (1, 1),
    (2, 1),
    (3, 2),
    (4, 2),
    (4, 3),
    (5, 4),
    (6, 4),
    (7, 5),
    (7, 6),
    (8, 7),
    (9,2),
    (10,8),
    (11,9),
    (12,10);

create table role_skill (
    role_id integer,
    skill_id integer,
    PRIMARY KEY (role_id, skill_id),
	constraint role_skill_fk1 foreign key(role_id) references role(role_id),
    constraint role_skill_fk2 foreign key(skill_id) references skill(skill_id)
);

insert into role_skill (role_id, skill_id) values
    (1, 1),
    (1, 2),
    (2, 2),
    (2, 3),
    (3, 4),
    (3, 7),
    (4, 3),
    (4, 5);

create table lj_course (
    learning_journey_id integer,
    course_id varchar(10),
    PRIMARY KEY (learning_journey_id, course_id),
	constraint lj_course_fk1 foreign key(learning_journey_id) references learning_journey(lj_id),
    constraint lj_course_fk2 foreign key(course_id) references course(course_id)
);

insert into lj_course (learning_journey_id, course_id) values
    (1, 1),
    (1, 2),
    (1, 3),
    (2, 2),
    (2, 4),
    (2, 7),
    (3, 3),
    (3, 6),
    (3, 8),
    (4, 2),
    (4, 7),
    (4, 8);

create table registration (
    reg_id integer auto_increment PRIMARY KEY,
    staff_id integer,
    course_id varchar(10),
    reg_status varchar(20),
    completion_status varchar(20),
    -- PRIMARY KEY (staff_id, course_id),
	constraint registration_fk1 foreign key(staff_id) references staff(staff_id),
    constraint registration_fk2 foreign key(course_id) references course(course_id)
);

insert into registration (staff_id, course_id, 
                        reg_status, completion_status) values
    (1, 1, "Registered", "Completed"),
    (2, 3, "Registered", "Completed"),
    (3, 4, "Waitlist", "Not Completed"),
    (4, 1, "Rejected", "Not Completed"),
    (5, 8, "Waitlist", "Not Completed"),
    (6, 2, "Registered", "Not Completed"),
    (7, 5, "Registered", "Completed"),
    (8, 6, "Rejected", "Not Completed"),
    (9, 7, "Registered", "Completed"),
    (10, 7, "Waitlist", "Not Completed"),
    (11, 8, "Registered", "Completed"),
    (12, 4, "Waitlist", "Completed");
    
create table staff_skill (
    staff_id integer,
    skill_id integer,
	constraint staff_skill_fk1 foreign key(staff_id) references staff(staff_id),
    constraint staff_skill_fk2 foreign key(skill_id) references skill(skill_id)
);

insert into staff_skill (staff_id, skill_id) values
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 2),
    (5, 4),
    (6, 7),
    (7, 3),
    (8, 6),
    (9, 3),
    (10, 2),
    (11, 7),
    (12, 1);
