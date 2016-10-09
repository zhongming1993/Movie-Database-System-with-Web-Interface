
# tables create

# Primary Constraint1: Movie must have a unique id, which is the primary key
create table Movie (
id int not null,
title varchar(100),
year int,
rating varchar (10),
company varchar(50),
primary key (id)
)ENGINE = INNODB;


# Primary Constraint2: Actor must have a unique id, which is the primary key
# Check Constraint1: All of the Actor's is either female or male.
create table Actor (
id int not null,
last varchar(20),
first varchar(20),
sex varchar(6),
dob date,
dod date,
check (sex = 'Female' or sex = 'Male'),
primary key (id)
) ENGINE = INNODB;


# Primary Constraint3: Sales must have a unique mid, which is the primary key
# Foreign Constraint1: Sales's mid must correspond to Movie'id, which is the foreign key constraint
create table Sales (
mid int not null,
ticketsSold int,
totalIncome int,
primary key (mid),
foreign key (mid) references Movie (id)
)ENGINE = INNODB;

# Primary Constraint4: Director must have a unique id, which is the primary key
create table Director (
id int not null,
last varchar(20),
first varchar(20),
dob date,
dod date,
primary key (id)
)ENGINE = INNODB;

# Foreign Constraint2: MovieGenre's mid must correspond to Movie'id, which is the foreign key constraint
create table MovieGenre (
mid int,
genre varchar(20),
foreign key (mid) references Movie(id)
)ENGINE = INNODB;

# Foreign Constraint3: MovieDirector's mid must correspond to Movie'id, which is the foreign key constraint
create table MovieDirector (
mid int,
did int,
foreign key (mid) references Movie(id)
)ENGINE = INNODB;

# Foreign Constraint4: MovieActor's mid must correspond to Movie'id, which is the foreign key constraint
# Foreign Constraint5: MovieActor's did must correspond to Actor's id, which is the foreign key constraint
create table MovieActor (
mid int,
aid int,
role varchar(50),
foreign key (mid) references Movie(id),
foreign key (aid) references Actor(id)
)ENGINE = INNODB;

# Check Constraint2: All of the imdb rating should be within 0-100, which is the check constraint
# Check Constraint3: All of the rot rating should be within 0-100, which is the check constraint
# Foreign Constraint6: MovieRating's mid must correspond to Movie's id, which is the foreign key constraint
create table MovieRating (
mid int,
imdb int,
rot int,
check (imbd >=0 and imbd <=100),
check (rot >=0 and rot <=100),
foreign key (mid) references Movie(id)
)ENGINE = INNODB;

create table Review (
name varchar(20),
time timestamp,
mid int,
rating int,
comment varchar(500)
)ENGINE = INNODB;

create table MaxPersonID (
id int
)ENGINE = INNODB;


create table MaxMovieID (
id int
)ENGINE = INNODB;



