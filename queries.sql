
# the names of all the actors in the movie 'Die Another Day'
select concat_ws (' ', last, first)
from Actor as a1
where a1.id in (
select aid
from MovieActor as ma1
where ma1.mid = (
select id 
from Movie as m1
where m1.title = 'Die Another Day'
));


# the count of all the actors who acted in multiple movies
select count(aid)
from (
select distinct aid
from MovieActor as ma2
group by ma2.aid
having count(mid) > 1
) as idset;


# the title of movies that sell more than 1,000,000 tickets
select title 
from Movie as m1
where m1.id in (
select mid 
from Sales as s1
where ticketsSold > 1000000
);


# name of person who is both actress and director, in format of last name and first name
select concat_ws (' ', last, first)
from Actor as a1
where a1.sex = 'Female' and a1.id in (
select id
from Director 
);


# the comedy that has the best imdb rating ever, in format of name
select title 
from Movie as m1
where m1.id in (
select mr1.mid
from MovieRating as mr1, MovieGenre as mg1
where mr1.mid = mg1.mid
and mg1.genre = 'Comedy'
and mr1.imdb >= all(
select mr2.imdb
from MovieRating as mr2, MovieGenre as mg2
where mr2.mid = mg2.mid
and mg2.genre = 'Comedy'
));


