# The following statements violate Primary Constraint1: Movie must have a unique id, which is the primary key
# The violation is caused because Movie.id is the primary key and should be unique.
# Output: ERROR 1062 (23000): Duplicate entry '10000' for key 'PRIMARY'
insert into Movie Values(10000, 'MovieTest1', 1999, 'P', 'Universal');
insert into Movie Values(10000, 'MovieTest2', 2000, 'R', 'Universal');


# The following statements violate Primary Constraint2: Actor must have a unique id, which is the primary key
# The violation is caused because Actor.id is the primary key and should be unique.
# Output: ERROR 1062 (23000): Duplicate entry '1000' for key 'PRIMARY'
insert into Actor Values(1000, 'Actor1_last', 'Actor1_first', 'Female', 19650101, 20100101);
insert into Actor Values(1000, 'Actor2_last', 'Actor2_first', 'Female', 19350101, 20150101);

# The following statements violate Check Constraint1: All of the Actor's is either female or male.
# The violation is caused because Actor is either male or female.
# Output: Query OK. (because check constraint not availbale)
delete from Actor
where id = 1000;
insert into Actor Values(1000, 'Actor3_last', 'Actor3_first', 'dont_know', 19350101, 20150101);

# The following statements violate Primary Constraint3: Sales must have a unique mid, which is the primary key
# The violation is caused because Sales.mid is the primary key and should be unique.
# Output: ERROR 1062 (23000): Duplicate entry '1000' for key 'PRIMARY'
insert into Sales Values(1000, 100000, 5000000);
insert into Sales Values(1000, 300000, 15000000);

# The following statements violate Foreign Constraint1: Sales's mid must correspond to Movie'id, which is the foreign key constraint
# The violation is caused because each of Sales.mid should correspondes to movie.id.
# Output: ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails (`TEST`.`Sales`, CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
delete from Movie
where Movie.id = 1000;
delete from Sales
where mid = 1000;
insert into Sales Values(1000, 300000, 15000000);

# The following statements violate Primary Constraint4: Director must have a unique id, which is the primary key
# The violation is caused because Director.id is the primary key and should be unique.
# Output: ERROR 1062 (23000): Duplicate entry '100' for key 'PRIMARY'
insert into Director Values(100, 'Director1_last', 'Director1_first', 19650809, null);
insert into Director Values(100, 'Director2_last', 'Director2_first', 19870108, null);


# The following statements violate Foreign Constraint2: MovieGenre's mid must correspond to Movie'id, which is the foreign key constraint
# The violation is caused because each of MovieGenre.mid should correspondes to movie.id.
# Output ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
insert into MovieGenre Values(5000, 'MovieGenreTest');


# The following statements violate Foreign Constraint3: MovieDirector's mid must correspond to Movie'id, which is the foreign key constraint
# The violation is caused because each of MovieDirector.mid should correspondes to movie.id.
# Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
insert into MovieDirector Values(6000, 4000);

# The following statements violate Foreign Constraint4: MovieActor's mid must correspond to Movie'id, which is the foreign key constraint
# The violation is caused because each of MovieActor.mid should correspondes to movie.id.
# Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))
insert into MovieActor Values(4000, 3000, 'hero');

# The following statements violate Foreign Constraint5: MovieActor's did must correspond to Actor's id, which is the foreign key constraint
# The violation is caused because each of MovieActor.aid should correspondes to Actor.id.
# Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))
delete from Actor
where Actor.id = 5000;
insert into MovieActor Values(3000, 5000, 'hero');

# The following statements violate Check Constraint2: All of the imdb rating should be within 0-100, which is the check constraint
# The violation is caused because each of MovieRating.imdb should be within 0 - 100
# Output: Query OK. (because check constraint not availbale)
update MovieRating set imdb = 1000 where mid in (select id from Movie);

# The following statements violate Check Constraint3: All of the rot rating should be within 0-100, which is the check constraint
# The violation is caused because each of MovieRating.rot should be within 0 - 100
# Output: Query OK. (because check constraint not availbale)
update MovieRating set rot = 1000 where mid in (select id from Movie);

# The following statements violate Foreign Constraint6: MovieRating's mid must correspond to Movie's id, which is the foreign key constraint
# The violation is caused because each of MovieRating.aid should correspondes to Movie.id.
# Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieRating`, CONSTRAINT `MovieRating_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
delete from Movie
where Movie.id = 6000;
insert into MovieRating Values(6000, 50, 50);
