create table departments (
	dept_id int not null primary key,
	dept_name varchar(20) not null,
	dept_loc varchar(20) not null
);

create table employees (
	employee_id int not null primary key,
	first_name varchar(20),
	last_name varchar(25) not null,
	email varchar(25) not null,
	phone_number varchar(20),
	hire_date date not null,
	job_id varchar(20) not null,
	salary decimal(8,2),
	commission_pct decimal(2,2),
	manager_id int(6),
	department_id int(4),
	foreign key (department_id) references departments(dept_id) on delete cascade on update cascade
);

alter table employees add constraint manager_constraint foreign key(manager_id) references employees(employee_id) on delete set null;

insert into departments(dept_id, dept_name, dept_loc) values 
(101, "administration", "Capecoast"),
(102, "marketing", "Kumasi"),
(103, "production", "Takoradi");

insert into employees(employee_id, first_name, last_name, email, phone_number, hire_date, job_id, salary, commission_pct, manager_id, department_id) values
(111, 'Ahmed', 'Issah', 'ahmed@gmail.com', '0242424242', '2015-02-03', 'JO1', 5000, 0.5, null, 101),
(112, 'George', 'Asante', 'george@gmail.com', '0541787685', '2017-10-06', 'JO2', 2700, 0.7, 111, 103),
(113, 'Frank', 'Yaw', 'frank@yahoo.com', '0276434410', '2016-09-08', 'JO3', 5500, 0.6, 112, 102),
(114, 'Ahmed', 'Issah', 'ahmed@gmail.com', '0242424242', '2015-02-03', 'JO4', 4000, 0.4, 113, 101),
(115, 'Jersey', 'Reed', 'george@gmail.com', '0542787685', '2017-10-06', 'JO5', 2600, 0.9, 114, 103),
(116, 'Prince', 'Ann', 'prince@yahoo.com', '0201834419', '2014-11-12', 'JO6', 5540, 0.8, 115, 102);


