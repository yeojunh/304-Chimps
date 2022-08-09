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

-- create tables for the database --
-- entities -- 
CREATE TABLE Customer (
	CustomerNum INTEGER PRIMARY KEY,
	DateOfBirth DATE, 
	CustomerName CHAR(255) NOT NULL
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