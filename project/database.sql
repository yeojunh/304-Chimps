drop table Customer cascade constraints;
drop table Membership cascade constraints;
drop table DropIn cascade constraints;
drop table AgeDependentDeals cascade constraints;
drop table FamilyDeals cascade constraints; 

drop table Staff cascade constraints;
drop table Lifeguard cascade constraints;
drop table Manager cascade constraints;
drop table Volunteer cascade constraints;
drop table FrontDeskEmployee cascade constraints;
drop table ProgramInstructor cascade constraints; 

drop table Program cascade constraints;
drop table Manager cascade constraints;
drop table SkatingRink cascade constraints;
drop table AquaticCentre cascade constraints;
drop table FitnessCentre cascade constraints;
drop table Events cascade constraints;
drop table Gymnasium cascade constraints;

drop table WorksIn cascade constraints;
drop table Manages_AquaticCentre cascade constraints;
drop table Manages_FitnessCentre cascade constraints;
drop table Manages_Gymnasium cascade constraints;
drop table Manages_SkatingRink cascade constraints;

drop table Uses_Event cascade constraints;
drop table Uses_Gymnasium cascade constraints; 
drop table Uses_AquaticCentre cascade constraints;
drop table Uses_FitnessCentre cascade constraints;
drop table Uses_SkatingRink cascade constraints;
drop table Greets cascade constraints;
drop table VolunteersFor cascade constraints;
drop table Teaches cascade constraints;
drop table Purchases cascade constraints;


-- select 'drop table '||table_name||' cascade constraints;' from user_tables;
-- 'DROPTABLE'||TABLE_NAME||'CASCADECONSTRAINTS;'
--------------------------------------------------------------------------------
-- drop table AUTHORS cascade constraints;
-- drop table CUSTOMER cascade constraints;
-- drop table DEMOTABLE cascade constraints;
-- drop table DROPIN cascade constraints;
-- drop table DURATIONBASEDDEALS cascade constraints;
-- drop table EDITORS cascade constraints;
-- drop table EVENT cascade constraints;
-- drop table FAMILYDEALS cascade constraints;
-- drop table FITNESSCENTRE cascade constraints;
-- drop table MEMBERSHIP cascade constraints;
-- drop table PUBLISHERS cascade constraints;

-- 'DROPTABLE'||TABLE_NAME||'CASCADECONSTRAINTS;'
--------------------------------------------------------------------------------
-- drop table PURCHASES cascade constraints;
-- drop table SALES cascade constraints;
-- drop table SALESDETAILS cascade constraints;
-- drop table SKATINGRINK cascade constraints;
-- drop table TITLEAUTHORS cascade constraints;
-- drop table TITLEDITORS cascade constraints;
-- drop table TITLES cascade constraints;
-- drop table USES_EVENT cascade constraints;
-- drop table USES_SKATINGRINK cascade constraints;

-- drop table Manages_AquaticCentre cascade constraints; 

-- create tables for the database --
-- entities -- 
CREATE TABLE Customer (
	CustomerNum INTEGER PRIMARY KEY,
	DateOfBirth DATE, 
	CustomerName CHAR(255) NOT NULL
);

CREATE TABLE Registers_For(
	CustomerNum INTEGER,
	ProgramID INTEGER,
	PRIMARY KEY (CustomerNum, ProgramID)),
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE,
	FOREIGN KEY (ProgramID) REFERENCES Program (ProgramID) ON DELETE CASCADE
);

CREATE TABLE Program (
	ProgramID INTEGER,
	ProgramName CHAR(225) NOT NULL,
	Frequency INTEGER NOT NULL,
	Location CHAR(255) NOT NULL,
	Purpose CHAR(255),
	TargetAudience CHAR(255),
	Capacity INTEGER NOT NULL,
	StartDate DATE NOT NULL,
    EndDate DATE,
	PRIMARY KEY (ProgramID)
);

-- 30xx -- 
CREATE TABLE Gymnasium (
	GymName CHAR(255),
	GymNum INTEGER,
	OpeningTime NUMBER(4, 2) NOT NULL,
	ClosingTime NUMBER(4, 2) NOT NULL,
    Capacity INTEGER,
	PRIMARY KEY (GymName, GymNum)
);

-- 31xx --
CREATE TABLE FitnessCentre (
	FitnessCentreName CHAR(255),
	FitnessCentreNum INTEGER,
	NumPrivateChangingRooms INTEGER,
	OpeningTime NUMBER(4, 2) NOT NULL,
	ClosingTime NUMBER(4, 2) NOT NULL,
	Rules Char(255),
	Capacity INTEGER,
	NumEquipments INTEGER,
	PRIMARY KEY (FitnessCentreName, FitnessCentreNum)
);

-- 32xx --
CREATE TABLE AquaticCentre (
	AquaticCentreName CHAR(255),
	AquaticCentreID INTEGER,
	OpeningTime NUMBER(4, 2) NOT NULL,
	ClosingTime NUMBER(4, 2) NOT NULL,
    NumLifeguards INTEGER NOT NULL,
    Capacity INTEGER,
    KiddiePoolAvailability NUMBER(1),
    DivingBoardAvailability NUMBER(1),
	PRIMARY KEY (AquaticCentreName, AquaticCentreID)
);

-- 33xx --
CREATE TABLE SkatingRink (
	SkatingRinkName CHAR(255),
	SkatingRinkNum INTEGER,
	OpeningTime NUMBER(4, 2) NOT NULL, -- time in hours with 2 decimal places. e.g. 3:30 PM is 15.50 --
	ClosingTime NUMBER(4, 2) NOT NULL,
	PRIMARY KEY (SkatingRinkName, SkatingRinkNum)
);

-- 40xx --
CREATE TABLE Events (
	EventNum INTEGER PRIMARY KEY,
	EventName CHAR (255) NOT NULL,
	Purpose CHAR (255),
	Organization CHAR (255),
	StartDate DATE NOT NULL,
	EndDate DATE,
	IsFundraiser NUMBER(1)
);

CREATE TABLE Membership (
    CustomerMembershipNum INTEGER PRIMARY KEY,
    CustomerNum INTEGER NOT NULL,
    FitnessCentreAccess NUMBER(1),
    PoolAccess NUMBER(1),
    GymAccess NUMBER(1),
    StartDate DATE NOT NULL,
    EndDate DATE,
    FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE
);

CREATE TABLE DropIn (
	CustomerMembershipNum INTEGER PRIMARY KEY, 
    DropInDate DATE NOT NULL,
    Price NUMBER(4, 2) NOT NULL,
    FOREIGN KEY (CustomerMembershipNum) REFERENCES Membership (CustomerMembershipNum) ON DELETE CASCADE
);

CREATE TABLE AgeDependentDeals (
    CustomerMembershipNum INTEGER PRIMARY KEY,
    Age INTEGER NOT NULL,
    FOREIGN KEY (CustomerMembershipNum) REFERENCES Membership (CustomerMembershipNum) ON DELETE CASCADE
);

-- CREATE TABLE DurationBasedDeals (
--     CustomerMembershipNum INTEGER PRIMARY KEY, 
--     DurationOfMembership INTEGER NOT NULL,
--     FOREIGN KEY (CustomerMembershipNum) REFERENCES Membership (CustomerMembershipNum) ON DELETE CASCADE
-- );

CREATE TABLE FamilyDeals (
    CustomerMembershipNum INTEGER PRIMARY KEY, 
    NumberOfAdults INTEGER NOT NULL,
    NumberOfDependents INTEGER NOT NULL,
    FOREIGN KEY (CustomerMembershipNum) REFERENCES Membership (CustomerMembershipNum) ON DELETE CASCADE
);

-- 10xx --
CREATE TABLE Staff (
    StaffNum INTEGER PRIMARY KEY,
	StaffName CHAR(255) NOT NULL,
    IsFullTime NUMBER(1) NOT NULL,
    StartDate DATE NOT NULL
);

-- 11xx -- 
CREATE TABLE ProgramInstructor (
	StaffNum INTEGER,
	ProgramID INTEGER,
	CertificationNum INTEGER,
	NumClasses INTEGER,
	PRIMARY KEY (StaffNum, ProgramID),
	FOREIGN KEY (StaffNum) REFERENCES Staff (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (ProgramID) REFERENCES Program (ProgramID) ON DELETE CASCADE
);

-- 12xx --
CREATE TABLE Lifeguard (
	StaffNum INTEGER PRIMARY KEY,
	LifeguardCertificationNum INTEGER,
	FOREIGN KEY (StaffNum) REFERENCES Staff (StaffNum) ON DELETE CASCADE
);

-- 13xx --
CREATE TABLE Manager (
	StaffNum INTEGER PRIMARY KEY,
	Area CHAR (255), 
	FOREIGN KEY (StaffNum) REFERENCES Staff (StaffNum) ON DELETE CASCADE
);

-- 14xx --
CREATE TABLE FrontDeskEmployee (
	StaffNum INTEGER PRIMARY KEY,
	AdminLoginID INTEGER NOT NULL,
	FOREIGN KEY (StaffNum) REFERENCES Staff (StaffNum) ON DELETE CASCADE
);	

-- 15xx --
CREATE TABLE Volunteer (
	StaffNum INTEGER PRIMARY KEY,
	NumVolunteerHours INTEGER NOT NULL,
	Contracted NUMBER(1) NOT NULL,
	FOREIGN KEY (StaffNum) REFERENCES Staff (StaffNum) ON DELETE CASCADE
); 

-- relationships -- 
-- x2xx --
CREATE TABLE Manages_Gymnasium(
	StaffNum INTEGER NOT NULL,
	GymName CHAR(255),
	GymNum INTEGER,
    UNIQUE (StaffNum, GymNum, GymName),
	PRIMARY KEY (GymName, GymNum),
	FOREIGN KEY (StaffNum) REFERENCES Manager (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (GymName, GymNum) REFERENCES Gymnasium ON DELETE CASCADE
);

CREATE TABLE Manages_FitnessCentre(
	StaffNum INTEGER NOT NULL, 
	FitnessCentreName CHAR(255),
	FitnessCentreNum INTEGER,
	UNIQUE (StaffNum, FitnessCentreName, FitnessCentreNum),
	PRIMARY KEY (FitnessCentreName, FitnessCentreNum),
	FOREIGN KEY (StaffNum) REFERENCES Manager (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (FitnessCentreName, FitnessCentreNum) REFERENCES FitnessCentre ON DELETE CASCADE
);

CREATE TABLE Manages_AquaticCentre(
	StaffNum INTEGER NOT NULL,
	AquaticCentreName CHAR(255),
	AquaticCentreID INTEGER,
	UNIQUE (StaffNum, AquaticCentreName, AquaticCentreID),
	PRIMARY KEY (AquaticCentreName, AquaticCentreID),
	FOREIGN KEY (StaffNum) REFERENCES Manager (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (AquaticCentreName, AquaticCentreID) REFERENCES AquaticCentre ON DELETE CASCADE
);

CREATE TABLE Manages_SkatingRink(
	StaffNum INTEGER NOT NULL,
	SkatingRinkNum INTEGER,
	SkatingRinkName CHAR (255),
	UNIQUE (StaffNum, SkatingRinkNum , SkatingRinkName),
	PRIMARY KEY (SkatingRinkName, SkatingRinkNum), 
	FOREIGN KEY (StaffNum) REFERENCES Manager (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (SkatingRinkName, SkatingRinkNum) REFERENCES SkatingRink (SkatingRinkName, SkatingRinkNum) ON DELETE CASCADE
);

CREATE TABLE WorksIn (
	StaffNum INTEGER,
	AquaticCentreName CHAR(255),
	AquaticCentreID INTEGER,
	PRIMARY KEY (StaffNum, AquaticCentreName, AquaticCentreID),
	FOREIGN KEY (StaffNum) REFERENCES Lifeguard (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (AquaticCentreName, AquaticCentreID) REFERENCES AquaticCentre (AquaticCentreName, AquaticCentreID) ON DELETE CASCADE
);

CREATE TABLE Uses_Event (
	CustomerNum INTEGER,
	EventNum INTEGER, 
	PRIMARY KEY (CustomerNum, EventNum),
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE, 
	FOREIGN KEY (EventNum) REFERENCES Events (EventNum) ON DELETE CASCADE
);

CREATE TABLE Uses_Gymnasium (
	CustomerNum INTEGER,
	GymName CHAR(255), 
	GymNum INTEGER, 
	PRIMARY KEY (CustomerNum, GymName, GymNum),
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE,
	FOREIGN KEY (GymName, GymNum) REFERENCES Gymnasium (GymName, GymNum) ON DELETE CASCADE
);

CREATE TABLE Uses_FitnessCentre (
	CustomerNum INTEGER,
	FitnessCentreNum INTEGER,
	FitnessCentreName CHAR (255),
	PRIMARY KEY (CustomerNum, FitnessCentreName, FitnessCentreNum),
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE,
    FOREIGN KEY (FitnessCentreName, FitnessCentreNum) REFERENCES FitnessCentre (FitnessCentreName, FitnessCentreNum) ON DELETE CASCADE
);

CREATE TABLE Uses_AquaticCentre (
	CustomerNum INTEGER,
	AquaticCentreName CHAR(255), 
	AquaticCentreID INTEGER, 
	PRIMARY KEY (CustomerNum, AquaticCentreName, AquaticCentreID),
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE,
	FOREIGN KEY (AquaticCentreName, AquaticCentreID) REFERENCES AquaticCentre (AquaticCentreName, AquaticCentreID) ON DELETE CASCADE
);

CREATE TABLE Uses_SkatingRink (
	CustomerNum INTEGER,
	SkatingRinkName CHAR(255),  
	SkatingRinkNum INTEGER,
	PRIMARY KEY (CustomerNum, SkatingRinkNum, SkatingRinkName),
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE,
	FOREIGN KEY (SkatingRinkName, SkatingRinkNum) REFERENCES SkatingRink (SkatingRinkName, SkatingRinkNum) ON DELETE CASCADE
);

CREATE TABLE Greets (
	StaffNum INTEGER,
	CustomerNum INTEGER,
	PRIMARY KEY (CustomerNum, StaffNum), 
	FOREIGN KEY (StaffNum) REFERENCES FrontDeskEmployee (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE
);

CREATE TABLE VolunteersFor (
	StaffNum INTEGER,
	EventNum INTEGER, 
	PRIMARY KEY (StaffNum, EventNum),
	FOREIGN KEY (StaffNum) REFERENCES Volunteer (StaffNum) ON DELETE CASCADE,
	FOREIGN KEY (EventNum) REFERENCES Events (EventNum) ON DELETE CASCADE
);

CREATE TABLE Teaches (
	StaffNum INTEGER,
	ProgramID INTEGER,
	PRIMARY KEY (StaffNum, ProgramID), 
	FOREIGN KEY (StaffNum, ProgramID) REFERENCES ProgramInstructor (StaffNum, ProgramID) ON DELETE CASCADE,
	FOREIGN KEY (ProgramID) REFERENCES Program (ProgramID) ON DELETE CASCADE
);

CREATE TABLE Purchases (
	CustomerNum INTEGER,
	CustomerMembershipNum INTEGER PRIMARY KEY,
	FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerNum) ON DELETE CASCADE,
	FOREIGN KEY (CustomerMembershipNum) REFERENCES Membership (CustomerMembershipNum) ON DELETE CASCADE
);

-- insert values into ENTITIES --
-- 10xx general staffs--
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1001, 'Jane Doe', 1, TO_DATE('2022-03-20','YYYY-MM-DD'));

-- 11xx program instructors -- 
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1101, 'Yeojun Han', 1, TO_DATE('2021-03-01','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1102, 'Aaron Fos-Oy', 0, TO_DATE('2022-03-12','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1103, 'Isaac Zhu', 0, TO_DATE('2022-12-01','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1104, 'Frank Hu', 1, TO_DATE('2021-01-30','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1105, 'Kol Crooks', 0, TO_DATE('2022-12-01','YYYY-MM-DD'));

-- 12xx lifeguards -- 
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1201, 'Byron Wang', 1, TO_DATE('2020-02-02','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1202, 'Alan Wang', 1, TO_DATE('2020-12-06','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1203, 'Josh Kim', 1, TO_DATE('2020-04-04','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1204, 'John Kim', 0, TO_DATE('2020-10-30','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1205, 'Hugh McNeil', 0, TO_DATE('2020-08-22','YYYY-MM-DD'));

-- managers --
-- gymnasium 130x -- 
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1301, 'Lori Reynolds', 1, TO_DATE('2019-02-04','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1302, 'Mike Feeley', 1, TO_DATE('2020-05-12','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1303, 'Robert Xiao', 1, TO_DATE('2021-10-10','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1304, 'Jordon Johnson', 1, TO_DATE('2022-01-12','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1305, 'Jenny Lee', 0, TO_DATE('2022-03-04','YYYY-MM-DD'));
	
-- fitness centre 131x -- 
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1311, 'Jobby Jobby', 1, TO_DATE('2022-08-12','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1312, 'Bart Simpson', 0, TO_DATE('2022-03-04','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1313, 'Lisa Simpson', 0, TO_DATE('2022-04-05','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1314, 'Marge Simpson', 1, TO_DATE('2022-04-06','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1315, 'Eren Yeager', 0, TO_DATE('2022-07-01','YYYY-MM-DD'));
	
-- aquatic centre 132x --
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1321, 'Parker Milo', 0, TO_DATE('2022-03-04','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1322, 'Lipid Polysaccharide', 1, TO_DATE('2017-05-10','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1323, 'Yeoman Jello', 1, TO_DATE('2020-08-25','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1324, 'Larch Larry', 0, TO_DATE('2018-12-19','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1325, 'Ponder Oso', 0, TO_DATE('2019-11-04','YYYY-MM-DD'));
	
-- skating rink 133x --
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1331, 'Centipede Mano', 1, TO_DATE('2022-03-04','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1332, 'Perfume Fumes', 1, TO_DATE('2021-02-11','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1333, 'Pina Colada', 1, TO_DATE('2019-06-26','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1334, 'Alberta Land', 0, TO_DATE('2019-03-14','YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1335, 'Spicy Noodle', 1, TO_DATE('2022-11-15','YYYY-MM-DD'));
	
-- front desk employees -- 
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1401, 'Will Smith', 1, TO_DATE('2020-01-02', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1402, 'Chris Rock', 1, TO_DATE('2020-03-09', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1403, 'Captain Falcon', 0, TO_DATE('2020-10-04', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1404, 'Tyler Creator', 1, TO_DATE('2020-12-09', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1405, 'Ben Soy', 0, TO_DATE('2020-10-10', 'YYYY-MM-DD'));

-- volunteers -- 
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1501, 'Charles Darwin', 1, TO_DATE('2018-07-26', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1502, 'Sonic Hedgehog', 0, TO_DATE('2020-09-12', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1503, 'Mario Party', 1, TO_DATE('2022-01-02', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1504, 'Mario Kart', 0, TO_DATE('2019-12-03', 'YYYY-MM-DD'));
INSERT INTO Staff (StaffNum, StaffName, IsFullTime, StartDate) VALUES (1505, 'Luigi Mario', 0, TO_DATE('2022-05-11', 'YYYY-MM-DD'));

INSERT INTO ProgramInstructor (StaffNum, ProgramID, CertificationNum, NumClasses) VALUES (1101, 2000, 123456, 2);
INSERT INTO ProgramInstructor (StaffNum, ProgramID, CertificationNum, NumClasses) VALUES (1102, 2001, 987654, 4);
INSERT INTO ProgramInstructor (StaffNum, ProgramID, CertificationNum, NumClasses) VALUES (1102, 2002, 110222, 2);
INSERT INTO ProgramInstructor (StaffNum, ProgramID, CertificationNum, NumClasses) VALUES (1103, 2003, 110333, 3);
INSERT INTO ProgramInstructor (StaffNum, ProgramID, CertificationNum, NumClasses) VALUES (1104, 2004, 110444, 4);

-- 12xx --
INSERT INTO Lifeguard (StaffNum, LifeguardCertificationNum) VALUES (1201, 12011);
INSERT INTO Lifeguard (StaffNum, LifeguardCertificationNum) VALUES (1202, 12022);
INSERT INTO Lifeguard (StaffNum, LifeguardCertificationNum) VALUES (1203, 12033);
INSERT INTO Lifeguard (StaffNum, LifeguardCertificationNum) VALUES (1204, 12044);
INSERT INTO Lifeguard (StaffNum, LifeguardCertificationNum) VALUES (1205, 12055);

-- 13xx --
INSERT INTO Manager (StaffNum, Area) VALUES (1301, 'General');
INSERT INTO Manager (StaffNum, Area) VALUES (1302, 'Sales');
INSERT INTO Manager (StaffNum, Area) VALUES (1303, 'Customer Satisfaction');
INSERT INTO Manager (StaffNum, Area) VALUES (1304, 'Facilities');
INSERT INTO Manager (StaffNum, Area) VALUES (1305, 'Security');

-- 14xx --
INSERT INTO FrontDeskEmployee (StaffNum, AdminLoginID) VALUES (1401, 14011);
INSERT INTO FrontDeskEmployee (StaffNum, AdminLoginID) VALUES (1402, 14022);
INSERT INTO FrontDeskEmployee (StaffNum, AdminLoginID) VALUES (1403, 14033);
INSERT INTO FrontDeskEmployee (StaffNum, AdminLoginID) VALUES (1404, 14044);
INSERT INTO FrontDeskEmployee (StaffNum, AdminLoginID) VALUES (1405, 14055);

-- 15xx -- 
INSERT INTO Volunteer (StaffNum, NumVolunteerHours, Contracted) VALUES (1501, 10, 1);
INSERT INTO Volunteer (StaffNum, NumVolunteerHours, Contracted) VALUES (1502, 20, 1);
INSERT INTO Volunteer (StaffNum, NumVolunteerHours, Contracted) VALUES (1503, 14, 0);
INSERT INTO Volunteer (StaffNum, NumVolunteerHours, Contracted) VALUES (1504, 8, 0);
INSERT INTO Volunteer (StaffNum, NumVolunteerHours, Contracted) VALUES (1505, 5, 0);


INSERT INTO Program (ProgramID, ProgramName, Frequency, Location, Purpose, TargetAudience, Capacity, StartDate, EndDate)
		VALUES (2001, 'Swimming Lessons with Byron', 2, 'Community Pool 2', 'Swimming Lessons to improve your health while having fun! - T/T', 'Intermediate skill level', 15, TO_DATE('2022-05-01','YYYY-MM-DD'), TO_DATE('2022-08-31', 'YYYY-MM-DD'));
INSERT INTO Program (ProgramID, ProgramName, Frequency, Location, Purpose, TargetAudience, Capacity, StartDate, EndDate)
		VALUES (2002, 'Get Fit with Isaac', 4, 'Arcane Gym', 'Weight training - M/T/T/F', 'Anyone is welcome!', 5, TO_DATE('2021-12-01','YYYY-MM-DD'), TO_DATE('2022-05-31', 'YYYY-MM-DD'));
INSERT INTO Program (ProgramID, ProgramName, Frequency, Location, Purpose, TargetAudience, Capacity, StartDate, EndDate)
		VALUES (2003, 'Tennis Lesson', 3, 'Tennis Court 1', 'Tennis lessons for beginners - W/F', 'Beginner to intermediate', 10, TO_DATE('2020-02-01','YYYY-MM-DD'), TO_DATE('2020-03-31', 'YYYY-MM-DD'));
INSERT INTO Program (ProgramID, ProgramName, Frequency, Location, Purpose, TargetAudience, Capacity, StartDate, EndDate)
		VALUES (2004, 'Badminton with Yeojun', 6, 'Gym 3', 'Compete with national champion badminton star Yeojun! - M/W', 'Intermediate to expert', 20, TO_DATE('2021-04-20','YYYY-MM-DD'), TO_DATE('2021-04-28', 'YYYY-MM-DD'));
INSERT INTO Program (ProgramID, ProgramName, Frequency, Location, Purpose, TargetAudience, Capacity, StartDate, EndDate)
		VALUES (2005, 'Aquatic Zumba Lesson', 2, 'Community Pool 3', 'Zumba but in the water - F/S', 'Beginner skill level', 7, TO_DATE('2020-06-13','YYYY-MM-DD'), TO_DATE('2020-06-29', 'YYYY-MM-DD'));

INSERT INTO Gymnasium (GymName, GymNum, OpeningTime, ClosingTime, Capacity) VALUES ('The Great Gymnasium', 3001, 8.00, 22.00, 50);
INSERT INTO Gymnasium (GymName, GymNum, OpeningTime, ClosingTime, Capacity) VALUES ('The Werner Gymnasium', 3002, 8.00, 21.00, 40);
INSERT INTO Gymnasium (GymName, GymNum, OpeningTime, ClosingTime, Capacity) VALUES ('The Byron Gymnasium', 3003, 9.00, 21.00, 40);
INSERT INTO Gymnasium (GymName, GymNum, OpeningTime, ClosingTime, Capacity) VALUES ('The Aaron Gymnasium', 3004, 9.00, 21.00, 40);
INSERT INTO Gymnasium (GymName, GymNum, OpeningTime, ClosingTime, Capacity) VALUES ('The Yeojun Gymnasium', 3005, 9.00, 21.00, 40);


INSERT INTO FitnessCentre (FitnessCentreName, FitnessCentreNum, NumPrivateChangingRooms, OpeningTime, ClosingTime, Rules, Capacity, NumEquipments)
		VALUES ('Arcane Gym', 3101, 4, 6.00, 22.00, 'Please keep your mask on, return equipments after use.', 50, 30);
INSERT INTO FitnessCentre (FitnessCentreName, FitnessCentreNum, NumPrivateChangingRooms, OpeningTime, ClosingTime, Rules, Capacity, NumEquipments)
		VALUES ('Bird Cooper Gym', 3102, 2, 8.00, 22.00, 'Please keep your mask on, return equipments after use, be respectful!', 30, 20);
INSERT INTO FitnessCentre (FitnessCentreName, FitnessCentreNum, NumPrivateChangingRooms, OpeningTime, ClosingTime, Rules, Capacity, NumEquipments)
		VALUES ('League Gym', 3102, 4, 6.00, 22.00, 'Please keep your mask on, return equipments after use.', 30, 30);
INSERT INTO FitnessCentre (FitnessCentreName, FitnessCentreNum, NumPrivateChangingRooms, OpeningTime, ClosingTime, Rules, Capacity, NumEquipments)
		VALUES ('Legends Gym', 3103, 4, 6.00, 22.00, 'Please keep your mask on, return equipments after use.', 30, 30);
INSERT INTO FitnessCentre (FitnessCentreName, FitnessCentreNum, NumPrivateChangingRooms, OpeningTime, ClosingTime, Rules, Capacity, NumEquipments)
		VALUES ('Valorant Gym', 3104, 4, 6.00, 22.00, 'Please keep your mask on, return equipments after use.', 30, 30);

INSERT INTO AquaticCentre (AquaticCentreName, AquaticCentreID, OpeningTime, ClosingTime, NumLifeguards, Capacity, KiddiePoolAvailability, DivingBoardAvailability)
		VALUES ('Splash and Dash', 3201, 8.00, 20.00, 5, 50, 0, 0);
INSERT INTO AquaticCentre (AquaticCentreName, AquaticCentreID, OpeningTime, ClosingTime, NumLifeguards, Capacity, KiddiePoolAvailability, DivingBoardAvailability)
		VALUES ('Community Pool 1', 3202, 9.50, 22.00, 10, 60, 1, 1);
INSERT INTO AquaticCentre (AquaticCentreName, AquaticCentreID, OpeningTime, ClosingTime, NumLifeguards, Capacity, KiddiePoolAvailability, DivingBoardAvailability)
		VALUES ('Community Pool 2', 3203, 9.50, 22.00, 10, 60, 1, 1);
INSERT INTO AquaticCentre (AquaticCentreName, AquaticCentreID, OpeningTime, ClosingTime, NumLifeguards, Capacity, KiddiePoolAvailability, DivingBoardAvailability)
		VALUES ('Wave Pool', 3204, 9.50, 22.00, 10, 60, 1, 1);
INSERT INTO AquaticCentre (AquaticCentreName, AquaticCentreID, OpeningTime, ClosingTime, NumLifeguards, Capacity, KiddiePoolAvailability, DivingBoardAvailability)
		VALUES ('Surfs Up Pool', 3205, 9.50, 22.00, 10, 60, 1, 1);

INSERT INTO SkatingRink (SkatingRinkName, SkatingRinkNum, OpeningTime, ClosingTime) VALUES ('Thunderraven Rink', 3301, 8.00, 20.00);
INSERT INTO SkatingRink (SkatingRinkName, SkatingRinkNum, OpeningTime, ClosingTime) VALUES ('Public Rink 1', 3302, 10.00, 20.00);
INSERT INTO SkatingRink (SkatingRinkName, SkatingRinkNum, OpeningTime, ClosingTime) VALUES ('Public Rink 2', 3303, 10.50, 20.50);
INSERT INTO SkatingRink (SkatingRinkName, SkatingRinkNum, OpeningTime, ClosingTime) VALUES ('Public Rink 3', 3304, 11.00, 21.00);
INSERT INTO SkatingRink (SkatingRinkName, SkatingRinkNum, OpeningTime, ClosingTime) VALUES ('Bluebird Rink', 3305, 8.50, 20.50);

INSERT INTO Events (EventNum, EventName, Purpose, Organization, StartDate, EndDate, IsFundraiser) VALUES (4000, 'Back to School Event', 'Welcoming back students from local schools and creating a space for students to connect', 'Community Centre', TO_DATE('2022-09-01', 'YYYY-MM-DD'), TO_DATE('2022-09-01', 'YYYY-MM-DD'), 0);
INSERT INTO Events (EventNum, EventName, Purpose, Organization, StartDate, EndDate, IsFundraiser) VALUES (4001, 'Winter Holidays Event', 'Celebrate winter holidays with us!', 'Community Centre', TO_DATE('2022-12-20', 'YYYY-MM-DD'), TO_DATE('2022-12-20', 'YYYY-MM-DD'), 0);
INSERT INTO Events (EventNum, EventName, Purpose, Organization, StartDate, EndDate, IsFundraiser) VALUES (4002, 'Easter Hunt', '3-day long easter hunt all over the community centre', 'Community Centre', TO_DATE('2023-04-15', 'YYYY-MM-DD'), TO_DATE('2023-04-17', 'YYYY-MM-DD'), 0); 
INSERT INTO Events (EventNum, EventName, Purpose, Organization, StartDate, EndDate, IsFundraiser) VALUES (4003, 'Local School Club Fundraiser', 'Krispy Kreme donut fundraiser for a local school club.', 'Computer Science Studnt Society', TO_DATE('2022-03-30','YYYY-MM-DD'), TO_DATE('2022-03-31','YYYY-MM-DD'), 1);
INSERT INTO Events (EventNum, EventName, Purpose, Organization, StartDate, EndDate, IsFundraiser) VALUES (4004, 'Women in Computer Science social event', 'Meet other women in computer science!', 'Women in Computer Science', TO_DATE('2022-04-02', 'YYYY-MM-DD'), TO_DATE('2044-04-02', 'YYYY-MM-DD'), 0);


-- Customer Specific --
-- drop ins 000x --
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0001, TO_DATE('2001-11-04','YYYY-MM-DD'), 'Alan Wang'); 
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0002, TO_DATE('1999-04-12','YYYY-MM-DD'), 'Dora Qi');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0003, TO_DATE('1987-02-24','YYYY-MM-DD'), 'Jenny Kim');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0004, TO_DATE('2001-12-04','YYYY-MM-DD'), 'Lauren Lee');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0005, TO_DATE('2000-08-14','YYYY-MM-DD'), 'Jonathan Kang');

-- age dependent 001x -- 
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0011, TO_DATE('2001-11-04','YYYY-MM-DD'), 'Damon Rick'); 
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0012, TO_DATE('1999-04-12','YYYY-MM-DD'), 'King Kong');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0013, TO_DATE('1987-02-24','YYYY-MM-DD'), 'Mario Kart');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0014, TO_DATE('2001-12-04','YYYY-MM-DD'), 'Apple Bottom');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0015, TO_DATE('2000-08-14','YYYY-MM-DD'), 'Hugh Jean');

-- family deals 002x --
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0021, TO_DATE('2002-12-04','YYYY-MM-DD'), 'Rick Roll');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0022, TO_DATE('1979-01-12','YYYY-MM-DD'), 'Ding Dong');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0023, TO_DATE('1985-02-14','YYYY-MM-DD'), 'Metro Town');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0024, TO_DATE('2000-04-12','YYYY-MM-DD'), 'Help Us');
INSERT INTO Customer (CustomerNum, DateOfBirth, CustomerName) VALUES (0025, TO_DATE('2001-10-22','YYYY-MM-DD'), 'Smiley Face');

INSERT INTO Membership (CustomerMembershipNum, CustomerNum, FitnessCentreAccess, PoolAccess, GymAccess, StartDate, EndDate) VALUES (5001, 0001, 1, 0, 1, TO_DATE('2022-11-04','YYYY-MM-DD'), TO_DATE('2023-11-04','YYYY-MM-DD'));
INSERT INTO Membership (CustomerMembershipNum, CustomerNum, FitnessCentreAccess, PoolAccess, GymAccess, StartDate, EndDate) VALUES (5002, 0002, 0, 1, 1, TO_DATE('2021-04-12','YYYY-MM-DD'), TO_DATE('2023-11-04','YYYY-MM-DD'));
INSERT INTO Membership (CustomerMembershipNum, CustomerNum, FitnessCentreAccess, PoolAccess, GymAccess, StartDate, EndDate) VALUES (5003, 0003, 1, 1, 1, TO_DATE('2021-04-12','YYYY-MM-DD'), TO_DATE('2023-11-04','YYYY-MM-DD')); 
INSERT INTO Membership (CustomerMembershipNum, CustomerNum, FitnessCentreAccess, PoolAccess, GymAccess, StartDate, EndDate) VALUES (5004, 0004, 1, 0, 0, TO_DATE('2018-05-04','YYYY-MM-DD'), TO_DATE('2019-08-03','YYYY-MM-DD')); 
INSERT INTO Membership (CustomerMembershipNum, CustomerNum, FitnessCentreAccess, PoolAccess, GymAccess, StartDate, EndDate) VALUES (5005, 0005, 0, 0, 0, TO_DATE('2017-01-13','YYYY-MM-DD'), TO_DATE('2017-05-04','YYYY-MM-DD'));

INSERT INTO DropIn(CustomerMembershipNum, DropInDate, Price) VALUES (0001, TO_DATE('2022-11-04','YYYY-MM-DD'), 3.50);
INSERT INTO DropIn(CustomerMembershipNum, DropInDate, Price) VALUES (0002, TO_DATE('2021-04-12','YYYY-MM-DD'), 3.50);
INSERT INTO DropIn(CustomerMembershipNum, DropInDate, Price) VALUES (0003, TO_DATE('2021-04-12','YYYY-MM-DD'), 2.75);
INSERT INTO DropIn(CustomerMembershipNum, DropInDate, Price) VALUES (0004, TO_DATE('2018-05-04','YYYY-MM-DD'), 1.80);
INSERT INTO DropIn(CustomerMembershipNum, DropInDate, Price) VALUES (0005, TO_DATE('2017-01-13','YYYY-MM-DD'), 1.80);

INSERT INTO AgeDependentDeals(CustomerMembershipNum, Age: int) VALUES (0011, 35);
INSERT INTO AgeDependentDeals(CustomerMembershipNum, Age: int) VALUES (0012, 40);
INSERT INTO AgeDependentDeals(CustomerMembershipNum, Age: int) VALUES (0013, 18); 
INSERT INTO AgeDependentDeals(CustomerMembershipNum, Age: int) VALUES (0014, 12); 
INSERT INTO AgeDependentDeals(CustomerMembershipNum, Age: int) VALUES (0015, 13);

INSERT INTO FamilyDeals(CustomerMembershipNum, NumberOfAdults, NumberOfDependents) VALUES (0021, 2, 6);
INSERT INTO FamilyDeals(CustomerMembershipNum, NumberOfAdults, NumberOfDependents) VALUES (0022, 1, 2);
INSERT INTO FamilyDeals(CustomerMembershipNum, NumberOfAdults, NumberOfDependents) VALUES (0023, 3, 2);
INSERT INTO FamilyDeals(CustomerMembershipNum, NumberOfAdults, NumberOfDependents) VALUES (0024, 2, 1);
INSERT INTO FamilyDeals(CustomerMembershipNum, NumberOfAdults, NumberOfDependents) VALUES (0025, 2, 5);

-- insert data INTO RELATIONSHIPS -- 
INSERT INTO Manages_Gymnasium (StaffNum, GymName, GymNum) VALUES (1301, 'The Great Gymnasium', 3001);
INSERT INTO Manages_Gymnasium (StaffNum, GymName, GymNum) VALUES (1302, 'The Werner Gymnasium', 3002);
INSERT INTO Manages_Gymnasium (StaffNum, GymName, GymNum) VALUES (1303, 'The Byron Gymnasium', 3003);
INSERT INTO Manages_Gymnasium (StaffNum, GymName, GymNum) VALUES (1304, 'The Aaron Gymnasium', 3004);
INSERT INTO Manages_Gymnasium (StaffNum, GymName, GymNum) VALUES (1305, 'The Yeojun Gymnasium', 3005);

INSERT INTO Manages_FitnessCentre (StaffNum, FitnessCentreName, FitnessCentreNum) VALUES (1311, 'Arcane Gym', 3101);
INSERT INTO Manages_FitnessCentre (StaffNum, FitnessCentreName, FitnessCentreNum) VALUES (1312, 'Arcane Gym', 3101);
INSERT INTO Manages_FitnessCentre (StaffNum, FitnessCentreName, FitnessCentreNum) VALUES (1313, 'Arcane Gym', 3101);
INSERT INTO Manages_FitnessCentre (StaffNum, FitnessCentreName, FitnessCentreNum) VALUES (1314, 'Bird Cooper Gym', 3102);
INSERT INTO Manages_FitnessCentre (StaffNum, FitnessCentreName, FitnessCentreNum) VALUES (1315, 'Bird Cooper Gym', 3102);

INSERT INTO Manages_AquaticCentre (StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1301, 'Splash and Dash', 3201);
INSERT INTO Manages_AquaticCentre (StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1302, 'Community Pool 1', 3202);
INSERT INTO Manages_AquaticCentre (StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1302, 'Community Pool 2', 3203);
INSERT INTO Manages_AquaticCentre (StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1303, 'Wave Pool', 3204);
INSERT INTO Manages_AquaticCentre (StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1303, 'Surfs Up Pool', 3205);

INSERT INTO Manages_SkatingRink (StaffNum, SkatingRinkName, SkatingRinkNum) VALUES (1301, 'Thunderraven Rink', 3301);
INSERT INTO Manages_SkatingRink (StaffNum, SkatingRinkName, SkatingRinkNum) VALUES (1302, 'Public Rink 1', 3302);
INSERT INTO Manages_SkatingRink (StaffNum, SkatingRinkName, SkatingRinkNum) VALUES (1303, 'Public Rink 2', 3303);
INSERT INTO Manages_SkatingRink (StaffNum, SkatingRinkName, SkatingRinkNum) VALUES (1304, 'Public Rink 3', 3304);
INSERT INTO Manages_SkatingRink (StaffNum, SkatingRinkName, SkatingRinkNum) VALUES (1305, 'Bluebird Rink', 3305);

INSERT INTO Uses_Event (CustomerNum, EventNum) VALUES (0001, 4000);
INSERT INTO Uses_Event (CustomerNum, EventNum) VALUES (0011, 4000);
INSERT INTO Uses_Event (CustomerNum, EventNum) VALUES (0023, 4001);
INSERT INTO Uses_Event (CustomerNum, EventNum) VALUES (0004, 4004);
INSERT INTO Uses_Event (CustomerNum, EventNum) VALUES (0013, 4002);

INSERT INTO Uses_Gymnasium (CustomerNum, GymName, GymNum) VALUES (0001, 'The Byron Gymnasium', 3003);
INSERT INTO Uses_Gymnasium (CustomerNum, GymName, GymNum) VALUES (0002, 'The Byron Gymnasium', 3003);
INSERT INTO Uses_Gymnasium (CustomerNum, GymName, GymNum) VALUES (0011, 'The Yeojun Gymnasium', 3005);
INSERT INTO Uses_Gymnasium (CustomerNum, GymName, GymNum) VALUES (0021, 'The Aaron Gymnasium', 3004);
INSERT INTO Uses_Gymnasium (CustomerNum, GymName, GymNum) VALUES (0022, 'The Aaron Gymnasium', 3004);

INSERT INTO Uses_FitnessCentre (CustomerNum, FitnessCentreName, FitnessCentreNum) VALUES (0001, 'Arcane Gym', 3101);
INSERT INTO Uses_FitnessCentre (CustomerNum, FitnessCentreName, FitnessCentreNum) VALUES (0002, 'Arcane Gym', 3101);
INSERT INTO Uses_FitnessCentre (CustomerNum, FitnessCentreName, FitnessCentreNum) VALUES (0011, 'Bird Cooper Gym', 3102);
INSERT INTO Uses_FitnessCentre (CustomerNum, FitnessCentreName, FitnessCentreNum) VALUES (0021, 'Bird Cooper Gym', 3103);
INSERT INTO Uses_FitnessCentre (CustomerNum, FitnessCentreName, FitnessCentreNum) VALUES (0022, 'Valorant Gym', 3105);

INSERT INTO Uses_AquaticCentre (CustomerNum, AquaticCentreName, AquaticCentreID) VALUES (0001, 'Splash and Dash', 3201);
INSERT INTO Uses_AquaticCentre (CustomerNum, AquaticCentreName, AquaticCentreID) VALUES (0002, 'Splash and Dash', 3201);
INSERT INTO Uses_AquaticCentre (CustomerNum, AquaticCentreName, AquaticCentreID) VALUES (0013, 'Community Pool 1', 3202);
INSERT INTO Uses_AquaticCentre (CustomerNum, AquaticCentreName, AquaticCentreID) VALUES (0014, 'Community Pool 1', 3202);
INSERT INTO Uses_AquaticCentre (CustomerNum, AquaticCentreName, AquaticCentreID) VALUES (0023, 'Community Pool 2', 3203);

INSERT INTO Uses_SkatingRink (CustomerNum, SkatingRinkName, SkatingRinkNum) VALUES (0001, 'Public Rink 1', 3302);
INSERT INTO Uses_SkatingRink (CustomerNum, SkatingRinkName, SkatingRinkNum) VALUES (0002, 'Public Rink 1', 3302);
INSERT INTO Uses_SkatingRink (CustomerNum, SkatingRinkName, SkatingRinkNum) VALUES (0011, 'Public Rink 2', 3303);
INSERT INTO Uses_SkatingRink (CustomerNum, SkatingRinkName, SkatingRinkNum) VALUES (0012, 'Public Rink 2', 3303);
INSERT INTO Uses_SkatingRink (CustomerNum, SkatingRinkName, SkatingRinkNum) VALUES (0013, 'Public Rink 2', 3303);

INSERT INTO VolunteersFor (StaffNum, EventNum) VALUES (1501, 4002);
INSERT INTO VolunteersFor (StaffNum, EventNum) VALUES (1502, 4003);
INSERT INTO VolunteersFor (StaffNum, EventNum) VALUES (1505, 4000);
INSERT INTO VolunteersFor (StaffNum, EventNum) VALUES (1503, 4002);
INSERT INTO VolunteersFor (StaffNum, EventNum) VALUES (1504, 4001);

INSERT INTO Worksin(StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1201, 'Splash and Dash', 3201);
INSERT INTO Worksin(StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1202, 'Splash and Dash', 3201);
INSERT INTO Worksin(StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1203, 'Community Pool 1', 3202);
INSERT INTO Worksin(StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1204, 'Community Pool 1', 3202);
INSERT INTO Worksin(StaffNum, AquaticCentreName, AquaticCentreID) VALUES (1205, 'Splash and Dash', 3201);

INSERT INTO Greets (StaffNum, CustomerNum) VALUES (1401, 0001);
INSERT INTO Greets (StaffNum, CustomerNum) VALUES (1402, 0002);
INSERT INTO Greets (StaffNum, CustomerNum) VALUES (1403, 0003);
INSERT INTO Greets (StaffNum, CustomerNum) VALUES (1404, 0004);
INSERT INTO Greets (StaffNum, CustomerNum) VALUES (1405, 0005);

INSERT INTO Teaches (StaffNum, ProgramID) VALUES (1101, 2001);
INSERT INTO Teaches (StaffNum, ProgramID) VALUES (1102, 2002);
INSERT INTO Teaches (StaffNum, ProgramID) VALUES (1103, 2003);
INSERT INTO Teaches (StaffNum, ProgramID) VALUES (1104, 2004);
INSERT INTO Teaches (StaffNum, ProgramID) VALUES (1105, 2005);

INSERT INTO Purchases (CustomerNum, CustomerMembershipNum) VALUES (0001, 0001);
INSERT INTO Purchases (CustomerNum, CustomerMembershipNum) VALUES (0002, 0002);
INSERT INTO Purchases (CustomerNum, CustomerMembershipNum) VALUES (0003, 0003);
INSERT INTO Purchases (CustomerNum, CustomerMembershipNum) VALUES (0004, 0004);
INSERT INTO Purchases (CustomerNum, CustomerMembershipNum) VALUES (0005, 0005);
