CREATE DATABASE hotelDB;

CREATE TABLE Guest (
	GuestID varchar(10) NOT NULL,
    GuestLogin varchar(50) NOT NULL UNIQUE,
    GuestPass varchar(50) NOT NULL,
    CreditCard varchar(16) NOT NULL,
    PhoneNo varchar(11) NOT NULL,
    GuestName varchar(100) NOT NULL,
    Address varchar(100) NOT NULL,
    PRIMARY KEY (GuestID)
);

CREATE TABLE Employee (
	SSN varchar(9) NOT NULL,
    Fname varchar(50) NOT NULL,
    Lname varchar(50) NOT NULL,
    Address varchar(100) NOT NULL,
    Salary int NOT NULL,
    Sex varchar(10) NOT NULL,
    DoB date NOT NULL,
    EmpLogin varchar(50) NOT NULL UNIQUE,
    EmpPass varchar(50) NOT NULL,
    SuperSSN varchar(9),
    BusiPhone varchar(11),
    BusiEmail varchar (50),
    ERole varchar(50),
    NumHrWeek int,
    AdminLogin varchar(50) UNIQUE,
    AdminPass varchar(50),
    RecepLogin varchar(50) UNIQUE,
    RecepPass varchar(50),
    EmpFlag varchar(50) NOT NULL,
    PRIMARY KEY (SSN),
	FOREIGN KEY (SuperSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Floors (
	FloorNo int NOT NULL,
    FAmenities varchar(100),
    NumUtilities int,
    PRIMARY KEY (FloorNo)
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
    Cost int NOT NULL,
    Beds int NOT NULL,
    CleanStatus boolean NOT NULL, 
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

CREATE TABLE PhoneCall (
	CallID varchar(10) NOT NULL,
    Duration int,
    CallDate datetime NOT NULL,
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
    StartDate date NOT NULL,
    EndDate date NOT NULL,
    ConfirmNo varchar(10),
    NumPeople int NOT NULL,
    EmpSSN varchar(9),
    PRIMARY KEY (GuestID, FloorNo, RoomNo, ResID),
    FOREIGN KEY (GuestID) REFERENCES Guest(GuestID)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (FloorNo, RoomNo) REFERENCES Room(FloorNo, RoomNo)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (EmpSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Transactions (
	TransID varchar(10) NOT NULL,
    TransDate datetime,
    PaymentType varchar(50),
    Cost int NOT NULL, 
    GuestID varchar(10),
    EmpSSN varchar(10),
    PRIMARY KEY (TransID),
    FOREIGN KEY (GuestID) REFERENCES Guest(GuestID)
		ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (EmpSSN) REFERENCES Employee(SSN)
		ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Dependent (
	EmpSSN varchar(9) NOT NULL,
	DepSSN varchar(9) NOT NULL,
    DepName varchar(50),
    PRIMARY KEY (EmpSSN, DepSSN),
    FOREIGN KEY (EmpSSN) REFERENCES Employee(SSN)
		ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE DepBenefits (
	EmpSSN varchar(9) NOT NULL,
	DepSSN varchar(9) NOT NULL,
    DepBenefits varchar(500) NOT NULL,
    PRIMARY KEY (EmpSSN, DepSSN, DepBenefits),
    FOREIGN KEY (EmpSSN, DepSSN) REFERENCES Dependent(EmpSSN, DepSSN)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO Guest VALUES ('1111111111', 'GuestLoginA', 'GuestPassA', '1234567890123456', '14031234567','Guest A', 'GuestA Address');
INSERT INTO Guest VALUES ('2222222222', 'GuestLoginB', 'GuestPassB', '1234567890123457', '14031234568','Guest B', 'GuestB Address');
INSERT INTO Guest VALUES ('3333333333', 'GuestLoginC', 'GuestPassC', '1234567890123458', '14031234569','Guest C', 'GuestC Address');

INSERT INTO Employee VALUES ('444444444', 'Marion', 'Moseby', 'Boston, PA', 53000, 'Male', '1990-01-01', 'EmpLoginA', 'EmpPassA', '444444444', '14031234560', 'bossemail@hotel.com', NULL, NULL, 'AdminLogin', 'AdminPass', NULL, NULL, 'Admin');
INSERT INTO Employee VALUES ('555555555', 'Maddie', 'Fitzpatrick', 'Boston, PA', 40000, 'Female', '1995-01-01', 'EmpLoginB', 'EmpPassB', '444444444', '14031234511', 'maddyemail@hotel.com', NULL, NULL, NULL, NULL, 'RecepLogin', 'RecepPass', 'Receptionist');
INSERT INTO Employee VALUES ('666666666', 'Esteban', 'Ramirez', 'Boston, PA', 30000, 'Male', '1992-01-01', 'EmpLoginC', 'EmpPassC', '444444444', NULL, NULL, 'Housekeeper', 30, NULL, NULL, NULL, NULL, 'Maintenance');

INSERT INTO Floors VALUES (1, 'Parking lot', 3);
INSERT INTO Floors VALUES (2, 'Rec room', 1);
INSERT INTO Floors VALUES (3, 'Gymnasium', 1);
INSERT INTO FLOORS VALUES (5, NULL, NULL);

INSERT INTO Room VALUES (2, 1, 125, 2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3, 1, 125, 2, false, 'Regular', '1111111111', '2021-01-01', '1111111111', NULL);
UPDATE Room SET CleanStatus = FALSE, GCheckIn = '1111111111', ChkInDate = '2021-01-01' WHERE FloorNo = 2 AND RoomNo = 1;

INSERT INTO Reservation VALUES ('1111111111',2,1,'1234567890','1999-01-01','1999-01-05','1234567890',2,NULL);

INSERT INTO Transactions VALUES ('7894561231',NULL,NULL,5000,NULL,NULL);
INSERT INTO Transactions VALUES ('7894561230','2021-01-01','Visa',3000,'1111111111','555555555');

INSERT INTO Dependent VALUES ("555555555","789456123","Michael Scott");
INSERT INTO DepBenefits VALUES ("555555555","789456123","Health insurance");

INSERT INTO PhoneCall VALUES ("1234567890","15","2021-01-10","1111111111","555555555");

DELETE FROM Guest;
DELETE FROM Employee;
DELETE FROM FLOORS;
DELETE FROM ROOM;
DELETE FROM RESERVATION;
DELETE FROM TRANSACTIONS;
DELETE FROM DEPENDENT;
DELETE FROM DEPBENEFITS;
DELETE FROM PHONECALL;

-- ------------- STORED PROCEDURES ------------- --
SELECT * FROM Guest WHERE GuestLogin = 'GuestLoginA' AND GuestPass = 'GuestPassB';

-- Used in guestLogin()
DELIMITER // 
CREATE PROCEDURE GetCurrentGuest(IN username varchar(50),IN pass varchar(50))
BEGIN
	SELECT * FROM Guest WHERE GuestLogin = username AND GuestPass = pass;
    
END //
DELIMITER ;

-- Used in adminLogin()
DELIMITER // 
CREATE PROCEDURE GetCurrentAdmin(IN username varchar(50),IN pass varchar(50))
BEGIN
	SELECT * FROM Employee WHERE AdminLogin = username AND AdminPass = pass;
    
END //
DELIMITER ;

-- Used in recepLogin()
DELIMITER // 
CREATE PROCEDURE GetCurrentRecep(IN username varchar(50),IN pass varchar(50))
BEGIN
	SELECT * FROM Employee WHERE RecepLogin = username AND RecepPass = pass;
    
END //
DELIMITER ;

-- Used in employeeLogin()
DELIMITER // 
CREATE PROCEDURE GetCurrentEmp(IN username varchar(50),IN pass varchar(50))
BEGIN
	SELECT * FROM Employee WHERE EmpLogin = username AND EmpPass = pass;
    
END //
DELIMITER ;

-- Used in guestAccountNew()
DELIMITER // 
CREATE PROCEDURE guestAccountNew(IN gID varchar(10),IN gUser varchar(50),IN gPass varchar(50),IN gCredit varchar(16),IN gPhone varchar(11),IN gName varchar(100),IN gAddress varchar(100))
BEGIN
	INSERT INTO Guest VALUES (gID,gUser,gPass,gCredit,gPhone,gName,gAddress);
END //
DELIMITER ;

-- Used in guestAdminRead()
DELIMITER // 
CREATE PROCEDURE guestAdminRead()
BEGIN
	SELECT * FROM Guest;
END //
DELIMITER ;

-- Used in guestAdminWrite()
DELIMITER // 
CREATE PROCEDURE guestAdminWrite(IN gUser varchar(50),IN gCredit varchar(16),IN gPhone varchar(11),IN gName varchar(100),IN gAddress varchar(100),IN gID varchar(10))
BEGIN
	UPDATE Guest SET GuestLogin = gUser, CreditCard = gCredit, PhoneNo = gPhone, GuestName = gName, Address = gAddress WHERE GuestID = gID;
END //
DELIMITER ;

-- Used in guestAdminDel()
DELIMITER // 
CREATE PROCEDURE guestAdminDel(IN gID varchar(10))
BEGIN
	DELETE FROM Guest WHERE GuestID = gID;
END //
DELIMITER ;

-- Checking if certain Guest exists()
DELIMITER // 
CREATE PROCEDURE checkGuest(IN gID varchar(10))
BEGIN
	SELECT * FROM Guest WHERE GuestID = gID;
END //
DELIMITER ;DELIMITER // 
CREATE PROCEDURE checkGuest(IN gID varchar(10))
BEGIN
	SELECT * FROM Guest WHERE GuestID = gID;
END //
DELIMITER ;
