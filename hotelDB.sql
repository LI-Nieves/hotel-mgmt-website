CREATE DATABASE hotelDB;

CREATE TABLE Guest (
	GuestID varchar(10),
    GuestLogin varchar(50),
    GuestPass varchar(50),
    CreditCard varchar(16),
    PhoneNo varchar(11),
    GuestName varchar(100),
    PRIMARY KEY (GuestID)
);

CREATE TABLE GuestAddress (
	GuestID varchar(10) NOT NULL,
    Address varchar(100) NOT NULL,
    PRIMARY KEY (GuestID, Address)
);

CREATE TABLE Employee (
	SSN varchar(9) NOT NULL,
    Fname varchar(50),
    Lname varchar(50),
    Address varchar(100),
    Salary int,
    Sex varchar(10),
    DoB date,
    EmpLogin varchar(50),
    EmpPass varchar(50),
    SuperSSN varchar(9),
    BusiPhone varchar(11),
    BusiEmail varchar (50),
    ERole varchar(50),
    AdminLogin varchar(50),
    AdminPass varchar(50),
    RecepLogin varchar(50),
    RecepPass varchar(50),
    EmpFlag varchar(50),
    PRIMARY KEY (SSN),
	FOREIGN KEY (SuperSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Floors (
	FloorNo int NOT NULL,
    NumUtilities int,
    PRIMARY KEY (FloorNo)
);

CREATE TABLE FloorAmenities (
	FloorNo int NOT NULL,
    FAmenities varchar(100) NOT NULL,
    PRIMARY KEY (FloorNo, FAmenities),
	FOREIGN KEY (FloorNo) REFERENCES Floors(FloorNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE MaintHandling (
	MaintSSN varchar(9) NOT NULL,
    FloorNo int NOT NULL,
    PRIMARY KEY (MaintSSN, FloorNo),
	FOREIGN KEY (MaintSSN) REFERENCES Employee(SSN)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (FloorNo) REFERENCES Floors(FloorNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Room (
	FloorNo int NOT NULL,
    RoomNo INT UNSIGNED NOT NULL,
    Cost int,
    Beds int,
    Availability boolean,
    CleanStatus boolean, 
    RoomType varchar(100),
    GCheckIn varchar(10),
    ChkInDate datetime,
    GCheckOut varchar(10),
    ChkOutDate datetime,
    PRIMARY KEY (FloorNo, RoomNo),
    FOREIGN KEY (FloorNo) REFERENCES Floors(FloorNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (GCheckIn) REFERENCES Guest(GuestID)
		ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (GCheckOut) REFERENCES Guest(GuestID)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE RoomAmenities (
	FloorNo int NOT NULL,
    RoomNo INT UNSIGNED NOT NULL,
    RAmenities varchar(100),
    PRIMARY KEY (FloorNo, RoomNo),
    FOREIGN KEY (FloorNo) REFERENCES Floors(FloorNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE PhoneCall (
	CallID varchar(10) NOT NULL,
    Duration int,
    CallDate datetime,
    GuestID varchar(10),
    EmpSSN varchar(10),
    PRIMARY KEY (CallID),
    FOREIGN KEY (GuestID) REFERENCES Guest(GuestID)
		ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (EmpSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Reservation (
	GuestID varchar(10) NOT NULL,
    FloorNo int NOT NULL,
    RoomNo INT UNSIGNED NOT NULL,
    ResID varchar(10) NOT NULL,
    StartDate date,
    EndDate date,
    ConfirmNo varchar(10),
    NumPeople int,
    RecepSSN varchar(9),
    PRIMARY KEY (GuestID, FloorNo, RoomNo, ResID),
    FOREIGN KEY (GuestID) REFERENCES Guest(GuestID)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (FloorNo, RoomNo) REFERENCES Room(FloorNo, RoomNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (RecepSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Transactions (
	TransID varchar(10) NOT NULL,
    TransDate datetime,
    PaymentType varchar(50),
    Cost int, 
    Deposit int, 
    GuestID varchar(10),
    MgrSSN varchar(10),
    RecepSSN varchar(10),
    PRIMARY KEY (TransID),
    FOREIGN KEY (GuestID) REFERENCES Guest(GuestID)
		ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (MgrSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (RecepSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Dependent (
	EmpSSN varchar(10) NOT NULL,
	DepSSN varchar(10) NOT NULL,
    DepName varchar(50),
    PRIMARY KEY (EmpSSN, DepSSN),
    FOREIGN KEY (EmpSSN) REFERENCES Employee(SSN)
		ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE DepBenefits (
	EmpSSN varchar(10) NOT NULL,
	DepSSN varchar(10) NOT NULL,
    DepBenefits varchar(500) NOT NULL,
    PRIMARY KEY (EmpSSN, DepSSN, DepBenefits),
    FOREIGN KEY (EmpSSN, DepSSN) REFERENCES Dependent(EmpSSN, DepSSN)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO Guest VALUES ('1111111111', 'GuestLoginA', 'GuestPassA', '1234567890123456', '14031234567','Guest A');
INSERT INTO Guest VALUES ('2222222222', 'GuestLoginB', 'GuestPassB', '1234567890123457', '14031234568','Guest B');
INSERT INTO Guest VALUES ('3333333333', 'GuestLoginC', 'GuestPassC', '1234567890123458', '14031234569','Guest C');

INSERT INTO GuestAddress VALUES ('1111111111', 'Calgary, AB');
INSERT INTO GuestAddress VALUES ('1111111111', 'Edmonton, AB');
INSERT INTO GuestAddress VALUES ('2222222222', 'Vancouver, BC');
INSERT INTO GuestAddress VALUES ('3333333333', 'Toronto, ON');

INSERT INTO Employee VALUES ('444444444', 'Marion', 'Moseby', 'Boston, PA', 53000, 'Male', '1990-01-01', 'EmpLoginA', 'EmpPassA', '444444444', '14031234560', 'bossemail@hotel.com', NULL, 'AdminLogin', 'AdminPass', NULL, NULL, 'Admin');
INSERT INTO Employee VALUES ('555555555', 'Maddie', 'Fitzpatrick', 'Boston, PA', 40000, 'Female', '1995-01-01', 'EmpLoginB', 'EmpPassB', '444444444', '14031234511', 'maddyemail@hotel.com', NULL, NULL, NULL, 'RecepLogin', 'RecepPass', 'Receptionist');
INSERT INTO Employee VALUES ('666666666', 'Esteban', 'Ramirez', 'Boston, PA', 30000, 'Male', '1992-01-01', 'EmpLoginC', 'EmpPassC', '444444444', NULL, NULL, 'Housekeeper', NULL, NULL, NULL, NULL, 'Maintenance');

INSERT INTO Floors VALUES (1, 3);
INSERT INTO Floors VALUES (2, 1);
INSERT INTO Floors VALUES (3, 1);

INSERT INTO FloorAmenities VALUES (1, "Swimming pool");
INSERT INTO FloorAmenities VALUES (1, "Parking lot");
INSERT INTO FloorAmenities VALUES (2, "Gymnasium");

CREATE TABLE MaintHandling (
	MaintSSN varchar(9) NOT NULL,
    FloorNo int NOT NULL,
    PRIMARY KEY (MaintSSN, FloorNo),
	FOREIGN KEY (MaintSSN) REFERENCES Employee(SSN)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (FloorNo) REFERENCES Floors(FloorNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);