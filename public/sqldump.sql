CREATE TABLE admin (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL,
    password VARCHAR(10) NOT NULL
);
ALTER TABLE party AUTO_INCREMENT=2000;


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
    name VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(10) NOT NULL,
    age INT,
    phone_no INT(10),
    area_id INT, FOREIGN KEY (area_id) REFERENCES area(id)
); 

-- RESULT
CREATE TABLE result(
	no_of_votes INT(10),
    area_id INT,
    candidate_id INT,
    foreign key (area_id) references area(id),
    foreign key (candidate_id) references candidate(id)
);

desc candidate;

/*INSERT VAL*/
insert into party (name, password, total_candidates)  values ('KGP', '1234', 5);
insert into party (name, password, total_candidates)  values ('KGP', '1234', 5);
select * from party;

-- Area value
insert into area (name, total_voters) values ('Mysore', 3);
insert into area (name, total_voters) values ('Mandya', 5);
select * from area;

SELECT * FROM admin WHERE password='1234';
SELECT id,name FROM admin WHERE password='1234' AND name='1000';
