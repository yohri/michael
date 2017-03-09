set echo on	
connect system/amakal

drop user phpuser cascade;
create user phpuser identified by welcome;
grant connect, resource to phpuser;
alter user phpuser default tablespace users temporary tablespace temp account unlock;

drop user php_sec_admin cascade;
create user php_sec_admin identified by welcome;
alter user php_sec_admin default tablespace system temporary tablespace temp account unlock;
grant create procedure, create session, create table, resource, select any dictionary to php_sec_admin;

	connect phpuser/welcome

create table story
	(id number primary key, S_ID varchar2(10), Stories varchar2(20), Tittle varchar2(200));
	insert into story values(1,'10','Horror', 'Lagim sa Dilim');
	insert into story values(2,'12','romance', 'laki ng talong');
	insert into story values(3,'13','comedy', 'kinaen ang mani');
	insert into story values(4,'14','Adventure', 'Habulin ang talong');
	insert into story values(5,'15','Sci-fi', 'Nasobrahan sa lakas ang talong');
	insert into story values(6,'16','Crime', 'Pinatay sa laki ng talong');
	commit;

	connect php_sec_admin/welcome;

create table php_authentication
	(app_username varchar2(20) primary key,app_password varchar2(20) not null);

	insert into php_authentication values('Michael', 'asdqwe');
	insert into php_authentication values('Mikel', 'qweasd');
	commit;

	grant select on php_authentication to phpuser;
