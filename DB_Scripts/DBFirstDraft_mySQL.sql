/*
-------------------------
--NAME CHANGES FROM ERD--
-------------------------
*PREFIXED TABLE NAMES WITH 'TBL_' FOR CLARITY.
*TBL_ADDRESS>NUMBER FIELD CHANGED TO BUILDING_NUMBER FOR CLARITY AND TO PREVENT CLASH WITH SQL KEYWORD.
*TBL_USER>LANGUAGE CHANGED TO LANGUAGE_PREF TO PREVENT CLASH WITH SQL KEYWORD.
*TBL_CLINIC>PICTURE CHANGED TO PICTURE_URL FOR CLARITY.
*/
drop table if exists TBL_ALERT, 
TBL_EVENT, 
TBL_EVENT_TYPE, 
TBL_ADMIN, 
TBL_CLINIC, 
TBL_USER, 
TBL_ADDRESS;


create table TBL_ADDRESS(
	ADDRESS_ID int primary key,
	CITY varchar(20),
	OFFICE varchar(20),
	STREET varchar(50),
	AREA varchar(20),
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
	
	foreign key (ADDRESS_ID) references TBL_ADDRESS(ADDRESS_ID)
);

create table TBL_CLINIC(
	CLINIC_ID int primary key,
	ADDRESS_ID int,
	CONTACT_1 varchar(15),
	CONTACT_2 varchar(15),
	DESCRIPTION varchar(255),
	PICTURE_URL varchar(255),
	
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
