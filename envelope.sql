CREATE TABLE students (
	id int not null auto_increment,
	first_name varchar(20) not null,
	last_name varchar(25) not null,
	middle_name varchar(25),
	full_name varchar(50) not null,
	gender varchar(10) not null,
	email varchar(50) not null unique,
	index_number int not null unique,
	password varchar(255) not null,
	created_at datetime not null,
	updated_at datetime,

	primary key(id)
);


CREATE TABLE courses (
	id int not null auto_increment,
	name varchar(30) not null unique,
	created_at datetime not null,
	updated_at datetime,

	primary key(id)
);

CREATE TABLE lecturers (
	id int not null auto_increment,
	first_name varchar(20) not null,
	last_name varchar(25) not null,
	middle_name varchar(25),
	full_name varchar(50) not null,
	gender varchar(10) not null,
	title varchar(5) not null,
	email varchar(50) not null unique,
	password varchar(255) not null,
	course_id int not null,
	created_at datetime not null,
	updated_at datetime,

	primary key(id),
	foreign key(course_id) references courses(id) on delete cascade on update cascade
);

CREATE TABLE assignments (
	id int not null auto_increment,
	title varchar(20) not null,
	assignment_path varchar(255) not null,
	size varchar(10) not null,
	lecturer_id int not null,
	created_at datetime not null,
	submission_date datetime not null,

	primary key(id),
	foreign key(lecturer_id) references lecturers(id) on delete cascade on update cascade
);

CREATE TABLE solutions (
	id int not null auto_increment,
	assignment_id int not null,
	student_id int not null,
	lecturer_id int not null,
	solution_path varchar(255),
	size varchar(10) not null,
	created_at datetime not null,

	primary key(id),
	foreign key(assignment_id) references assignments(id) on delete cascade on update cascade,
	foreign key(student_id) references students(id) on delete cascade on update cascade,
	foreign key(lecturer_id) references lecturers(id) on delete cascade on update cascade
);









