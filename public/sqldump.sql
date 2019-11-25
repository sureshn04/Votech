CREATE TABLE admin (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL,
    password VARCHAR(10) NOT NULL
);
ALTER TABLE result AUTO_INCREMENT=3000;


-- PARTY
CREATE TABLE party (  
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL UNIQUE,
    password VARCHAR(10) NOT NULL,
    total_candidates INT
);

-- AREA Table
CREATE TABLE area (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL,
    total_voters VARCHAR(10) NOT NULL
);

-- Candidate
CREATE TABLE candidate (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL UNIQUE,
    password VARCHAR(10) NOT NULL,
    area_id INT, FOREIGN KEY (area_id) REFERENCES area(id)
);

-- VoTER
CREATE TABLE voter(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(15) NOT NULL ,
    password VARCHAR(10) NOT NULL,
    age INT,
    phone_no INT(10),
    area_id INT, FOREIGN KEY (area_id) REFERENCES area(id)
); 

-- RESULT
CREATE TABLE result(
	no_of_votes INT(10),
    area_id INT,
    cand_id INT,
    foreign key (area_id) references area(id),
    foreign key (cand_id) references candidate(id)
);

desc candidate;

/*INSERT VAL*/
insert into party (name, password, total_candidates)  values ('KGP', '1234', 5);
insert into party (name, password, total_candidates)  values ('KGP', '1234', 5);
select * from party;
delete from party where id = '2003';

-- Area value
insert into area (name, total_voters) values ('Mysore', 1);
insert into area (name, total_voters) values ('Mandya', 1);
select * from area;

SELECT * FROM admin WHERE password='1234';
SELECT id,name FROM admin WHERE password='1234' AND name='1000';

-- Voter
insert into voter (name, password, age, phone_no, area_id) values ('arjun', '123', 20, 1234567890, 1); 
alter table voter add flag int;
select * from area;

-- Candidate
alter table candidate add constraint party_id  FOREIGN KEY (party_id) references party(id);
insert into candidate (name, password, area_id, party_id) values ('sommana', '123', 5550, 2000);
insert into candidate (name, password, area_id, party_id) values ('suraj', '123', 5551, 2000);
insert into candidate (name, password, area_id, party_id) values ('ravi', '123', 5550, 2001);
insert into candidate (name, password, area_id, party_id) values ('mahesh', '123', 5551, 2001);
select * from candidate;

-- Result
desc result;
insert into result (area_id, cand_id, no_of_votes) values (5550, 3000, 0);
insert into result (area_id, cand_id, no_of_votes) values (5550, 3004, 0);
insert into result (area_id, cand_id, no_of_votes) values (5551, 3003, 0);
insert into result (area_id, cand_id, no_of_votes) values (5551, 3005, 0);

select * from result;
-- QUERIES
select name, party_id from candidate where (area_id = 102) OR (1=1);

-- select c.id,c.name,c.area_id, c.party_id, party.name as partyName from candidate c join party on c.party_id = party.id AND v.id = 3000;
select c.id,c.name,c.area_id, c.party_id, party.name as partyName from ((candidate c inner join party on c.party_id = party.id) inner join voter 
on c.area_id = voter.area_id AND voter.id = 4000);

select * from result where cand_id = 3000 and area_id = 5550;
UPDATE result SET no_of_votes='1' WHERE can_id='3000' AND area_id='5550';

-- Qurey for result table
select party.name as partName, candidate.name as candName, area.name as areaName, area.total_voters, result.no_of_votes from result INNER JOIN candidate ON result.cand_id=candidate.id INNER JOIN party ON party.id = candidate.party_id INNER JOIN area ON result.area_id = area.id; 

-- stored procedure
DELIMITER $$ ;
create procedure display_result()
select party.name as partyName, candidate.name as candName, area.name as areaName, area.total_voters, result.no_of_votes from result INNER JOIN candidate ON result.cand_id=candidate.id INNER JOIN party ON party.id = candidate.party_id INNER JOIN area ON result.area_id = area.id; 

call display_result();

-- Trigger
DELIMITER $$
CREATE 
	TRIGGER updateTotalVoter AFTER INSERT ON voter 
    FOR EACH ROW BEGIN
		
        UPDATE area 
        SET total_voters = total_voters + 1
        WHERE id = NEW.area_id;
	END;
$$
DELIMITER  ; $$

DELIMITER $$
CREATE 
	TRIGGER updateTotalCandidate AFTER INSERT ON candidate 
    FOR EACH ROW BEGIN
		
        UPDATE party 
        SET total_candidates = total_candidates + 1
        WHERE id = NEW.party_id;
	END;
$$
DELIMITER  ; $$

select * from party;


-- select c.id, c.name, a.name as areaName from candidate c, area a where c.area_id = a.id and c.party_id = 2000; 
