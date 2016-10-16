drop table if exists TBL_ALERT, 
TBL_EVENT, 
TBL_EVENT_TYPE, 
TBL_ADMIN, 
TBL_CLINIC, 
TBL_USER, 
TBL_ADDRESS;


create table TBL_ADDRESS(
	ADDRESS_ID int primary key,
	CITY varchar(50),
	OFFICE varchar(50),
	STREET varchar(50),
	AREA varchar(50),
	AREA_CODE varchar(10),
	BUILDING_NUMBER int
);

create table TBL_USER(
	USER_ID int primary key,
	FIRST_NAME varchar(20),
	LAST_NAME varchar(30),
	NATIONAL_ID char(13),
	EMAIL varchar(50),
	PHONE varchar(10),
	BLOOD_TYPE varchar(3),
	ADDRESS_ID int,
	DATE_OF_BIRTH datetime,
	TITLE varchar(4),
	GENDER char(1),
	LANGUAGE_PREF varchar(20),
	PASSPORT_NUM varchar(20),
	PASSWORD varchar(255)
	
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID)
);

create table TBL_CLINIC(
	CLINIC_ID int primary key,
	ADDRESS_ID int,
	CONTACT_1 varchar(15),
	CONTACT_2 varchar(15),
	DESCRIPTION varchar(255),	
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID)
);

create table TBL_ADMIN(
	ADMIN_ID int primary key,
	EMAIL varchar(50),
	FIRST_NAME varchar(20),
	LAST_NAME varchar(50),
	PASSWORD varchar(100)
);

create table TBL_EVENT_TYPE(
	TYPE_ID int primary key,
	DESCRIPTION varchar(255),
	URGENCY varchar(5)
);

create table TBL_EVENT(
	EVENT_ID int primary key,
	EVENT_DATE datetime,
	ADDRESS_ID int,
	TYPE_ID int,
	DESCRIPTION varchar(255),
	TITLE varchar(50),
	ACTIVE boolean,
	CREATOR_ID int,
	
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID),
	foreign key (TYPE_ID) references TBL_EVENT_TYPE(TYPE_ID),
	foreign key (CREATOR_ID) references TBL_ADMIN(ADMIN_ID)
);

create table TBL_ALERT(
	ALERT_ID int primary key,
	TYPE_ID int,
	TITLE varchar(50),
	DESCRIPTION int, /* int refferences enum */
	
	foreign key (TYPE_ID) references TBL_EVENT_TYPE(TYPE_ID)
);

/* inserts */
/* TBL_ADDRESS */
INSERT INTO TBL_ADDRESS VALUES( 1, 'Berlin', '6', 'P.O. Box 622, 1849 Eu St.', 'BE', '78059', 6);
INSERT INTO TBL_ADDRESS VALUES( 2, 'Vico del Gargano', '1', 'P.O. Box 138, 3534 Risus Avenue', 'Puglia', '25737', 4);
INSERT INTO TBL_ADDRESS VALUES( 3, 'Istanbul', '2', 'P.O. Box 760, 5466 Pharetra St.', 'Ist', '5669', 9);
INSERT INTO TBL_ADDRESS VALUES( 4, 'Shivapuri', '9', '4473 In, Rd.', 'Madhya Pradesh', '53958', 7);
INSERT INTO TBL_ADDRESS VALUES( 5, 'Northumberland', '3', 'P.O. Box 290, 3201 Libero St.', 'ON', '454052', 8);
INSERT INTO TBL_ADDRESS VALUES( 6, 'Motueka', '4', 'P.O. Box 590, 9381 Nunc Rd.', 'South Island', '41009', 7);
INSERT INTO TBL_ADDRESS VALUES( 7, 'Whitby', '2', 'P.O. Box 169, 971 Netus Avenue', 'Ontario', '9034', 2);
INSERT INTO TBL_ADDRESS VALUES( 8, 'Mildura', '8', '228 Congue St.', 'Victoria', '179', 2);
INSERT INTO TBL_ADDRESS VALUES( 9, 'Southaven', '1', '349-1319 Amet Avenue', 'Mississippi', '26958', 7);
INSERT INTO TBL_ADDRESS VALUES( 10, 'Bida', '6', '609-4202 Vestibulum Road', 'NI', '5458', 5);
INSERT INTO TBL_ADDRESS VALUES( 11, 'San Miguel', '4', '3541 Ridiculus Avenue', 'San José', '826706', 1);
INSERT INTO TBL_ADDRESS VALUES( 12, 'Uddevalla', '10', 'Ap #402-1440 Dignissim Street', 'Västra Götalands län', '79251', 5);
INSERT INTO TBL_ADDRESS VALUES( 13, 'Caledon', '1', 'Ap #216-9016 Euismod Rd.', 'ON', '82160-383', 1);
INSERT INTO TBL_ADDRESS VALUES( 14, 'Bandırma', '1', 'Ap #421-8024 Consectetuer Rd.', 'Bal', '26918', 4);
INSERT INTO TBL_ADDRESS VALUES( 15, 'Codognè', '3', '350-7576 Tincidunt Rd.', 'Veneto', 'XW7C 3HC', 2);

/* TBL_ADMIN */
INSERT INTO TBL_ADMIN VALUES( 1, 'eu.metus@nonhendreritid.ca', 'Timon', 'Oliver', '81dc9bdb52d04dc20036dbd8313ed055');
INSERT INTO TBL_ADMIN VALUES( 2, 'et@diamPellentesque.co.uk', 'Yolanda', 'Jordan', '81dc9bdb52d04dc20036dbd8313ed056');
INSERT INTO TBL_ADMIN VALUES( 3, 'Etiam.vestibulum.massa@cursus.org', 'Lacey', 'Watson', '81dc9bdb52d04dc20036dbd8313ed057');
INSERT INTO TBL_ADMIN VALUES( 4, 'lobortis@loremutaliquam.net', 'Zenaida', 'Fitzgerald', '81dc9bdb52d04dc20036dbd8313ed058');
INSERT INTO TBL_ADMIN VALUES( 5, 'ut.lacus@sit.co.uk', 'Kitra', 'Bass', '81dc9bdb52d04dc20036dbd8313ed059');

/* TBL_USER */
INSERT INTO TBL_USER VALUES( 1, 'Kyle', 'Burton', '9999999999999', 'kyle@live.co.za', '0229999999', 'O-', 6, '1995-02-03', 'Mr', 'M', 'English', '', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER VALUES( 2, 'Chris', 'Etheridge', '8888888888888', 'chirs@live.co.za', '0228888888', 'AB+', 7, '1990-03-04', 'Mr', 'M', 'English', '','e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER VALUES( 3, 'Tyron', 'deAndrade', '7777777777777', 'tyron@live.co.za', '0227777777', 'A+', 8, '1985-04-05', 'Mrs', 'F', 'Afrikaans', '','e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER VALUES( 4, 'David', 'Abrahams', '6666666666666', 'david@live.co.za', '0225555555', 'B-', 9, '1980-05-06', 'Mrs', 'F', 'isiXhosa', '','e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER VALUES( 5, 'Daniel', 'Erasmus', '', 'daniel@live.co.za', '0224444444', 'O+', 10, '1975-06-07', 'Mr', 'M', 'English', '3333333333333','e731a7b612ab389fcb7f973c452f33df3eb69c99');

/* TBL_CLINIC */
INSERT INTO TBL_CLINIC VALUES( 1, 1, '0769999999', '0219999999', 'clinic 1');
INSERT INTO TBL_CLINIC VALUES( 2, 2, '0768888888', '0218888888', 'clinic 2');
INSERT INTO TBL_CLINIC VALUES( 3, 3, '0847777777', '0217777777', 'clinic 3');
INSERT INTO TBL_CLINIC VALUES( 4, 4, '0846666666', '0216666666', 'clinic 4');
INSERT INTO TBL_CLINIC VALUES( 5, 5, '0725555555', '0215555555', 'clinic 5');


/* TBL_EVENT_TYPE */
insert into TBL_EVENT_TYPE
(TYPE_ID,DESCRIPTION, URGENCY)
values
('1','Low Blood O-', '5'),
('2','Low Blood B+', '5'),
('3','Social Event', '2'),
('4','Mobile Outreach','1'),
('5','College Ourreach', '1'),
('6','Corpoate Event', '3');


/* TBL_ALERT */
insert into TBL_ALERT
(ALERT_ID,TYPE_ID, TITLE, DESCRIPTION)
values
(1,1,'Alert for low blood O-',2),
(2,2,'Alert for low blood B+', 2);


/* TBL_EVENT */
insert into TBL_EVENT
(EVENT_ID, EVENT_DATE, ADDRESS_ID, TYPE_ID, DESCRIPTION, TITLE, ACTIVE, CREATOR_ID)
values
(1,'2015-10-24',1,3,'Social Event, for all happening in Cape Town','CT Social Event',false,1),
(2,'2015-08-31',2,4,'MObile blood drive event','Blood Drive',false,2),
(3,'2015-10-25',3,5,'College outreach and educational','College Outreach',true,3),
(4,'2016-06-29',4,6,'Corporate Internal administrative meeting','Corporate Private Event',true,4);

/* views */
CREATE OR REPLACE VIEW VIEW_CLINICSWADDRESS AS
SELECT TBL_CLINIC.*, CITY, OFFICE, STREET, AREA, AREA_CODE, BUILDING_NUMBER
FROM TBL_CLINIC
JOIN TBL_ADDRESS ON TBL_ADDRESS.ADDRESS_ID = TBL_CLINIC.ADDRESS_ID;

CREATE OR REPLACE VIEW VIEW_EVENTSWADDRESS AS
SELECT TBL_EVENT.*, CITY, OFFICE, STREET, AREA, AREA_CODE, BUILDING_NUMBER, TBL_EVENT_TYPE.DESCRIPTION AS TYPE_DESCRIPTION, URGENCY
FROM TBL_EVENT
JOIN TBL_ADDRESS ON TBL_ADDRESS.ADDRESS_ID = TBL_EVENT.ADDRESS_ID
JOIN TBL_EVENT_TYPE ON TBL_EVENT_TYPE.TYPE_ID = TBL_EVENT.TYPE_ID;

