drop table if exists 
TBL_EVENT_RSVP,
TBL_ALERT, 
TBL_EVENT, 
TBL_EVENT_TYPE, 
TBL_ADMIN, 
TBL_CLINIC, 
TBL_USER, 
TBL_ADDRESS,
TBL_DEVICES;


create table TBL_ADDRESS(
	ADDRESS_ID int primary key AUTO_INCREMENT,
	STREET_NO INT,
	CITY varchar(50),
	OFFICE varchar(50),
	STREET varchar(50),
	AREA varchar(50),
	AREA_CODE varchar(10),
	BUILDING_NUMBER int,
	LONGITUDE DECIMAL(9, 6),
	LATITUDE DECIMAL(9, 6)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
	PWD varchar(255),
	DEVICE_TOKEN varchar(255),
	
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table TBL_CLINIC(
	CLINIC_ID int primary key AUTO_INCREMENT,
	ADDRESS_ID int,
	CONTACT_1 varchar(15),
	CONTACT_2 varchar(15),
	DESCRIPTION varchar(255),	
	OPERATING_HOURS VARCHAR(255),
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table TBL_ADMIN(
	ADMIN_ID int primary key,
	EMAIL varchar(50),
	FIRST_NAME varchar(20),
	LAST_NAME varchar(50),
	PASSWORD varchar(100)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table TBL_EVENT_TYPE(
	TYPE_ID int primary key,
	DESCRIPTION varchar(255),
	URGENCY varchar(5)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table TBL_EVENT(
	EVENT_ID int primary key AUTO_INCREMENT, 
	EVENT_DATE datetime,
	ADDRESS_ID int,
	TYPE_ID int,
	DESCRIPTION varchar(255),
	TITLE varchar(50),
	ACTIVE boolean,
	CREATOR_ID int,
	EVENT_ADMIN_ID INT,
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID),
	foreign key (TYPE_ID) references TBL_EVENT_TYPE(TYPE_ID),
	foreign key (CREATOR_ID) references TBL_ADMIN(ADMIN_ID),
	foreign key (EVENT_ADMIN_ID) references TBL_ADMIN(ADMIN_ID)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table TBL_ALERT(
	ALERT_ID int primary key AUTO_INCREMENT,
	TITLE varchar(50),
	BODY varchar(255),
	DESCRIPTION varchar(255) /* JSON string for processing on the client side. */
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE TBL_EVENT_RSVP(
	USER_ID INT,
	EVENT_ID INT,
	ATTENDING INT,
	PRIMARY KEY(USER_ID, EVENT_ID),
	FOREIGN KEY (USER_ID) REFERENCES TBL_USER(USER_ID),
	FOREIGN KEY (EVENT_ID) REFERENCES TBL_EVENT(EVENT_ID)
)DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* inserts */
/* TBL_ADDRESS */
INSERT INTO TBL_ADDRESS VALUES( 1, 10, 'Berlin', '6', 'P.O. Box 622, 1849 Eu St.', 'BE', '78059', 6, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 2, 10, 'Vico del Gargano', '1', 'P.O. Box 138, 3534 Risus Avenue', 'Puglia', '25737', 4, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 3, 10, 'Istanbul', '2', 'P.O. Box 760, 5466 Pharetra St.', 'Ist', '5669', 9, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 4, 10, 'Shivapuri', '9', '4473 In, Rd.', 'Madhya Pradesh', '53958', 7, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 5, 10, 'Northumberland', '3', 'P.O. Box 290, 3201 Libero St.', 'ON', '454052', 8, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 6, 10, 'Motueka', '4', 'P.O. Box 590, 9381 Nunc Rd.', 'South Island', '41009', 7, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 7, 10, 'Whitby', '2', 'P.O. Box 169, 971 Netus Avenue', 'Ontario', '9034', 2, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 8, 10, 'Mildura', '8', '228 Congue St.', 'Victoria', '179', 2, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 9, 10, 'Southaven', '1', '349-1319 Amet Avenue', 'Mississippi', '26958', 7, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 10, 10, 'Bida', '6', '609-4202 Vestibulum Road', 'NI', '5458', 5, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 11, 10, 'San Miguel', '4', '3541 Ridiculus Avenue', 'San José', '826706', 1, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 12, 10, 'Uddevalla', '10', 'Ap #402-1440 Dignissim Street', 'Västra Götalands län', '79251', 5, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 13, 10, 'Caledon', '1', 'Ap #216-9016 Euismod Rd.', 'ON', '82160-383', 1, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 14, 10, 'Bandrma', '1', 'Ap #421-8024 Consectetuer Rd.', 'Bal', '26918', 4, 0.0, 0.0);
INSERT INTO TBL_ADDRESS VALUES( 15, 10, 'Codognè', '3', '350-7576 Tincidunt Rd.', 'Veneto', 'XW7C 3HC', 2, 0.0, 0.0);

/* TBL_ADMIN */
INSERT INTO TBL_ADMIN VALUES( 1, 'eu.metus@nonhendreritid.ca', 'Timon', 'Oliver', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_ADMIN VALUES( 2, 'et@diamPellentesque.co.uk', 'Yolanda', 'Jordan', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_ADMIN VALUES( 3, 'Etiam.vestibulum.massa@cursus.org', 'Lacey', 'Watson', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_ADMIN VALUES( 4, 'lobortis@loremutaliquam.net', 'Zenaida', 'Fitzgerald', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_ADMIN VALUES( 5, 'ut.lacus@sit.co.uk', 'Kitra', 'Bass', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_ADMIN VALUES( 6, 'admin@live.co.za', 'Admin', 'Super', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');

/* TBL_USER */
INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL, PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE, GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD) VALUES( 1, 'Kyle', 'Burton', '9999999999999', 'kyle@live.co.za', '0229999999', 'O-', 6, '1995-02-03', 'Mr', 'M', 'English', '', 'e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL, PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE, GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD) VALUES( 2, 'Chris', 'Etheridge', '8888888888888', 'chirs@live.co.za', '0228888888', 'AB+', 7, '1990-03-04', 'Mr', 'M', 'English', '','e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL, PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE, GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD) VALUES( 3, 'Tyron', 'deAndrade', '7777777777777', 'tyron@live.co.za', '0227777777', 'A+', 8, '1985-04-05', 'Mrs', 'F', 'Afrikaans', '','e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL, PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE, GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD) VALUES( 4, 'David', 'Abrahams', '6666666666666', 'david@live.co.za', '0225555555', 'B-', 9, '1980-05-06', 'Mrs', 'F', 'isiXhosa', '','e731a7b612ab389fcb7f973c452f33df3eb69c99');
INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL, PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE, GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD) VALUES( 5, 'Daniel', 'Erasmus', '', 'daniel@live.co.za', '0224444444', 'O+', 10, '1975-06-07', 'Mr', 'M', 'English', '3333333333333','e731a7b612ab389fcb7f973c452f33df3eb69c99');

/* TBL_CLINIC */
INSERT INTO TBL_CLINIC VALUES( 1, 1, '0769999999', '0219999999', 'clinic 1', 'Mon-Fri 6-7, sun 9-10');
INSERT INTO TBL_CLINIC VALUES( 2, 2, '0768888888', '0218888888', 'clinic 2', 'Mon-Fri 6-7, sun 9-10');
INSERT INTO TBL_CLINIC VALUES( 3, 3, '0847777777', '0217777777', 'clinic 3', 'Mon-Fri 6-7, sun 9-10');
INSERT INTO TBL_CLINIC VALUES( 4, 4, '0846666666', '0216666666', 'clinic 4', 'Mon-Fri 6-7, sun 9-10');
INSERT INTO TBL_CLINIC VALUES( 5, 5, '0725555555', '0215555555', 'clinic 5', 'Mon-Fri 6-7, sun 9-10');


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
(TITLE,BODY,DESCRIPTION)
values
('Alert for low blood O-','We are short of O- blood, help the cause by donating blood today!','As per the body.'),
('Alert for low blood B+','We are short of B+ blood, help the cause by donating blood today!','As per the body.');


/* TBL_EVENT */
insert into TBL_EVENT
(EVENT_ID, EVENT_DATE, ADDRESS_ID, TYPE_ID, DESCRIPTION, TITLE, ACTIVE, CREATOR_ID, EVENT_ADMIN_ID)
values
(1,'2017-10-24',1,3,'Social Event, for all happening in Cape Town','CT Social Event',false,1, 4),
(2,'2017-08-31',2,4,'MObile blood drive event','Blood Drive',false,2, 3),
(3,'2017-10-25',3,5,'College outreach and educational','College Outreach',true,3, 2),
(4,'2016-06-29',4,6,'Corporate Internal administrative meeting','Corporate Private Event',true,4, 1);

/* TBL_EVENT_RSVP */
INSERT INTO TBL_EVENT_RSVP (USER_ID, EVENT_ID, ATTENDING) VALUES (1,1, 1), (2, 1, 1), (2, 2, 1), (2, 3, 0);

/* views */
CREATE OR REPLACE VIEW VIEW_CLINICSWADDRESS AS
SELECT TBL_CLINIC.*, STREET_NO, CITY, OFFICE, STREET, AREA, AREA_CODE, BUILDING_NUMBER, LONGITUDE, LATITUDE
FROM TBL_CLINIC
JOIN TBL_ADDRESS ON TBL_ADDRESS.ADDRESS_ID = TBL_CLINIC.ADDRESS_ID;

CREATE OR REPLACE VIEW VIEW_EVENTSWADDRESS AS
SELECT TBL_EVENT.`EVENT_ID`, TBL_EVENT.EVENT_DATE AS EVENT_DATE_UNFORMATTED, DATE_FORMAT(TBL_EVENT.`EVENT_DATE`, '%d-%m-%Y') AS EVENT_DATE, TBL_EVENT.`ADDRESS_ID`, TBL_EVENT.`TYPE_ID`, TBL_EVENT.`DESCRIPTION`, TBL_EVENT.`TITLE`, TBL_EVENT.`ACTIVE`, TBL_EVENT.`CREATOR_ID`, TBL_EVENT.`EVENT_ADMIN_ID`, STREET_NO, CITY, OFFICE, STREET, AREA, AREA_CODE, BUILDING_NUMBER, LONGITUDE, LATITUDE, TBL_EVENT_TYPE.DESCRIPTION AS TYPE_DESCRIPTION, URGENCY
FROM TBL_EVENT
JOIN TBL_ADDRESS ON TBL_ADDRESS.ADDRESS_ID = TBL_EVENT.ADDRESS_ID
JOIN TBL_EVENT_TYPE ON TBL_EVENT_TYPE.TYPE_ID = TBL_EVENT.TYPE_ID
ORDER BY EVENT_DATE_UNFORMATTED ASC;

/* View for seeing rsvps and user details */
CREATE OR REPLACE VIEW VIEW_RSVP_USER_DETAILS AS
SELECT TBL_EVENT_RSVP.USER_ID AS USER_ID, TBL_EVENT_RSVP.EVENT_ID AS EVENT_ID, ATTENDING, FIRST_NAME, LAST_NAME, PHONE, EMAIL FROM TBL_EVENT_RSVP
JOIN TBL_USER ON TBL_USER.USER_ID = TBL_EVENT_RSVP.USER_ID
ORDER BY ATTENDING DESC;

