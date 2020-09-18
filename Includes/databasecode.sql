CREATE TABLE users (
  user_id varchar(256) PRIMARY KEY not null,
  user_first varchar(256) not null,
  user_last varchar(256) not null,
  user_email varchar(256) not null,
  user_uid varchar(256) not null,
  user_pwd varchar(256) not null
);

CREATE TABLE profileimg (
  id int(11) AUTO_INCREMENT not null PRIMARY KEY,
  userid varchar(256) not null,
  status int(11) not null
);