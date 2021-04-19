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
    EmpSSN varchar(9),
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

DELETE FROM GUEST;
DELETE FROM EMPLOYEE;
DELETE FROM FLOORS;
DELETE FROM ROOM;
DELETE FROM RESERVATION;
DELETE FROM TRANSACTIONS;
DELETE FROM DEPENDENT;
DELETE FROM DEPBENEFITS;
DELETE FROM PHONECALL;

INSERT INTO Guest VALUES ('1111111111', 'GuestLoginA', 'GuestPassA', '1234567890123456', '14031234567','Guest A', 'GuestA Address');
INSERT INTO Guest VALUES ('2222222222', 'GuestLoginB', 'GuestPassB', '1234567890123457', '14031234568','Guest B', 'GuestB Address');
INSERT INTO Guest VALUES ('3333333333', 'GuestLoginC', 'GuestPassC', '1234567890123458', '14031234569','Guest C', 'GuestC Address');

INSERT INTO Employee VALUES ('444444444', 'Marion', 'Moseby', 'Boston, PA', 53000, 'Male', '1990-01-01', 'EmpLoginA', 'EmpPassA', '444444444', '14031234560', 'bossemail@hotel.com', NULL, NULL, 'AdminLogin', 'AdminPass', NULL, NULL, 'Admin');
INSERT INTO Employee VALUES ('555555555', 'Maddie', 'Fitzpatrick', 'Boston, PA', 40000, 'Female', '1995-01-01', 'EmpLoginB', 'EmpPassB', '444444444', '14031234511', 'maddyemail@hotel.com', NULL, NULL, NULL, NULL, 'RecepLogin', 'RecepPass', 'Receptionist');
INSERT INTO Employee VALUES ('666666666', 'Esteban', 'Ramirez', 'Boston, PA', 30000, 'Male', '1992-01-01', 'EmpLoginC', 'EmpPassC', '444444444', NULL, NULL, 'Housekeeper', 30, NULL, NULL, NULL, NULL, 'Maintenance');

INSERT INTO Floors VALUES (1, 'Parking lot', 3);
INSERT INTO Floors VALUES (2, NULL, NULL);
INSERT INTO Floors VALUES (3, NULL, NULL);

INSERT INTO Room VALUES (2, 1, 125, 2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2, 2, 125, 2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2, 3, 125, 2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2, 4, 125, 2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2, 5, 125, 2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3, 1, 200, 2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3, 2, 200, 2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3, 3, 200, 2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3, 4, 200, 2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3, 5, 200, 2, true, 'Deluxe', NULL, NULL, NULL, NULL);

INSERT INTO Reservation VALUES ('1111111111',2,1,'1234567890','1999-01-01','1999-01-05','1234567890',2,NULL);

INSERT INTO Transactions VALUES ('7894561231',NULL,NULL,5000,NULL,NULL);
INSERT INTO Transactions VALUES ('7894561230','2021-01-01','Visa',3000,'1111111111','555555555');

INSERT INTO Dependent VALUES ("555555555","789456123","Michael Scott");
INSERT INTO DepBenefits VALUES ("555555555","789456123","Health insurance");

INSERT INTO PhoneCall VALUES ("1234567890","15","2021-01-10","1111111111","555555555");

-- STORED PROCEDURES ----------------------------------------------------------------------------------------------------------------

-- LOGINS -----------------------------------------------------------------------------------------------------------------
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

-- GUEST -----------------------------------------------------------------------------------------------------------------

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

-- Checking if certain Guest exists() NOT NEEDED
DELIMITER // 
CREATE PROCEDURE checkGuest(IN gID varchar(10))
BEGIN
	SELECT * FROM Guest WHERE GuestID = gID;
END //
DELIMITER ;

-- PHONECALL -----------------------------------------------------------------------------------------------------------------

-- Used in phoneEmpRead()
DELIMITER // 
CREATE PROCEDURE phoneEmpRead()
BEGIN
	SELECT * FROM PhoneCall;
END //
DELIMITER ;

-- Used in phoneEmpNew()
DELIMITER // 
CREATE PROCEDURE phoneEmpNew(IN cID varchar(10),IN duration int,IN pDate datetime,IN gID varchar(10),IN eSSN varchar(10))
BEGIN
	INSERT INTO PhoneCall VALUES (cID,duration,pDate,gID,eSSN);
END //
DELIMITER ;

-- Used in phoneAdminDel()
DELIMITER // 
CREATE PROCEDURE phoneAdminDel(IN cID varchar(10))
BEGIN
	DELETE FROM PhoneCall WHERE CallID = cID;
END //
DELIMITER ;

-- Checking if certain Phone Call exists()
DELIMITER // 
CREATE PROCEDURE checkCall(IN cID varchar(10))
BEGIN
	SELECT * FROM PhoneCall WHERE CallID = cID;
END //
DELIMITER ;

-- TRANSACTION -----------------------------------------------------------------------------------------------------------------

-- Used in transEmpRead()
DELIMITER // 
CREATE PROCEDURE transEmpRead()
BEGIN
	SELECT * FROM Transactions;
END //
DELIMITER ;

-- Used in transEmpNew()
DELIMITER // 
CREATE PROCEDURE transEmpNew(IN tID varchar(10),IN tDate datetime,IN tType varchar(50),IN tCost int,IN tGuestID varchar(10),IN tESSN varchar(9))
BEGIN
	INSERT INTO Transactions VALUES (tID,tDate,tType,tCost,tGuestID,tESSN);
END //
DELIMITER ;

-- Used in transAdminDel()
DELIMITER // 
CREATE PROCEDURE transAdminDel(IN tID varchar(10))
BEGIN
	DELETE FROM Transactions WHERE TransID = tID;
END //
DELIMITER ;

-- EMPLOYEE -----------------------------------------------------------------------------------------------------------------

-- Used in empEmpRead()
DELIMITER // 
CREATE PROCEDURE checkEmp(IN eSSN varchar(9))
BEGIN
	SELECT * FROM Employee WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in empAdminRead()
DELIMITER // 
CREATE PROCEDURE empAdminRead()
BEGIN
	SELECT * FROM Employee;
END //
DELIMITER ;

-- Used in transEmpNew()
DELIMITER // 
CREATE PROCEDURE transEmpNew(IN tID varchar(10),IN tDate datetime,IN tType varchar(50),IN tCost int,IN tGuestID varchar(10),IN tESSN varchar(9))
BEGIN
	INSERT INTO Transactions VALUES (tID,tDate,tType,tCost,tGuestID,tESSN);
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE newRecep(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN ePass varchar(50),IN superSSN varchar(9),IN rPhone varchar(11),
    IN rEmail varchar(50),IN rLogin varchar(50),IN rPass varchar(50))
BEGIN
	INSERT INTO Employee VALUES (eSSN,eFname,eLname,eAddress,eSal,eSex,eDOB,
		eLogin,ePass,superSSN,rPhone,rEmail,NULL,NULL,NULL,NULL,rLogin,rPass,"Receptionist");
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE newMaint(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN ePass varchar(50),IN superSSN varchar(9),IN mRole varchar(50),IN mHr int)
BEGIN
	INSERT INTO Employee VALUES (eSSN,eFname,eLname,eAddress,eSal,eSex,eDOB,
		eLogin,ePass,superSSN,NULL,NULL,mRole,mHr,NULL,NULL,NULL,NULL,"Maintenance");
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE newOther(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN ePass varchar(50),IN superSSN varchar(9))
BEGIN
	INSERT INTO Employee VALUES (eSSN,eFname,eLname,eAddress,eSal,eSex,eDOB,
		eLogin,ePass,superSSN,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"Other");
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE newAdmin(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN ePass varchar(50),IN superSSN varchar(9),IN rPhone varchar(11),
    IN rEmail varchar(50),IN rLogin varchar(50),IN rPass varchar(50))
BEGIN
	INSERT INTO Employee VALUES (eSSN,eFname,eLname,eAddress,eSal,eSex,eDOB,
		eLogin,ePass,superSSN,rPhone,rEmail,NULL,NULL,rLogin,rPass,NULL,NULL,"Admin");
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE modRecep(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN rPhone varchar(11),IN rEmail varchar(50),IN rLogin varchar(50))
BEGIN
	UPDATE Employee SET Fname = eFname, Lname = eLname, Address = eAddress, Salary = eSal,
		Sex = eSex, DoB = eDOB, EmpLogin = eLogin, BusiPhone = rPhone, BusiEmail = rEmail, RecepLogin = rLogin,
		EmpFlag = "Receptionist" WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE modMaint(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN mRole varchar(50),IN mHr int)
BEGIN
	UPDATE Employee SET Fname = eFname, Lname = eLname, Address = eAddress, Salary = eSal,
		Sex = eSex, DoB = eDOB, EmpLogin = eLogin, ERole = mRole, NumHrWeek = mHr, EmpFlag = "Maintenance" WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE modOther(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50))
BEGIN
	UPDATE Employee SET Fname = eFname, Lname = eLname, Address = eAddress, Salary = eSal,
		Sex = eSex, DoB = eDOB, EmpLogin = eLogin, EmpFlag = "Other" WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in empAdmin()
DELIMITER // 
CREATE PROCEDURE modAdmin(IN eSSN varchar(9),IN eFname varchar(50),IN eLname varchar(50),IN eAddress varchar(100),IN eSal int,
	IN eSex varchar(10),IN eDOB date,IN eLogin varchar(50),IN rPhone varchar(11),IN rEmail varchar(50),IN rLogin varchar(50))
BEGIN
	UPDATE Employee SET Fname = eFname, Lname = eLname, Address = eAddress, Salary = eSal,
		Sex = eSex, DoB = eDOB, EmpLogin = eLogin, BusiPhone = rPhone, BusiEmail = rEmail, AdminLogin = rLogin,
		EmpFlag = "Admin" WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in empAdminDel()
DELIMITER // 
CREATE PROCEDURE empAdminDel(IN eSSN varchar(9))
BEGIN
	DELETE FROM Employee WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in empChangePass()
DELIMITER // 
CREATE PROCEDURE changePass(IN eSSN varchar(9),IN ePass varchar(50),IN rPass varchar(50),IN aPass varchar(50))
BEGIN
	UPDATE Employee SET EmpPass = ePass, RecepPass = rPass, AdminPass = aPass WHERE SSN = eSSN;
END //
DELIMITER ;

-- Used in checkEmpType()
DELIMITER // 
CREATE PROCEDURE checkEType(IN eSSN varchar(9))
BEGIN
	SELECT EmpFlag FROM Employee WHERE SSN = eSSN;
END //
DELIMITER ;

-- RESERVATION -----------------------------------------------------------------------------------------------------------------

-- Used in resGuestRead()
DELIMITER // 
CREATE PROCEDURE resGuestRead(IN gID varchar(10))
BEGIN
	SELECT * FROM Reservation WHERE GuestID = gID;
END //
DELIMITER ;

-- Used in resGuestDel() and resEmpDel()
DELIMITER // 
CREATE PROCEDURE resDel(IN rID varchar(10),IN fNo int,IN rNo int,IN gID varchar(10))
BEGIN
	DELETE FROM Reservation WHERE ResID = rID AND FloorNo = fNo AND RoomNo = rNo AND GuestID = gID;
END //
DELIMITER ;

-- Used in resGuestNew() and resEmpNew()
DELIMITER // 
CREATE PROCEDURE resNew(IN gID varchar(10),IN fNo int,IN rNo int,IN rID varchar(10),IN aDate date,IN dDate date,
	IN cNo varchar(10),IN numPeople int,IN eSSN varchar(9))
BEGIN
	INSERT INTO Reservation VALUES (gID,fNo,rNo,rID,aDate,dDate,cNo,numPeople,eSSN);
END //
DELIMITER ;

-- Used in resGuestNew()
DELIMITER // 
CREATE PROCEDURE findRes(IN gID varchar(10),IN fNo int,IN rNo int,IN rID varchar(10))
BEGIN
	SELECT * FROM Reservation WHERE GuestID = gID AND FloorNo = fNo AND RoomNo = rNo AND ResID = rID;
END //
DELIMITER ;

-- Used in resEmpRead()
DELIMITER // 
CREATE PROCEDURE resEmpRead()
BEGIN
	SELECT * FROM Reservation;
END //
DELIMITER ;

-- FLOOR -----------------------------------------------------------------------------------------------------------------

-- used in floorAdminRead()
DELIMITER // 
CREATE PROCEDURE floorAdminRead()
BEGIN
	SELECT * FROM Floors;
END //
DELIMITER ;

-- used in maintAdminRead()
DELIMITER // 
CREATE PROCEDURE maintAdminRead()
BEGIN
	SELECT * FROM MaintHandling;
END //
DELIMITER ;

-- Used in floorAdminWrite()
DELIMITER // 
CREATE PROCEDURE floorAdminWrite(IN dFNo int,IN fAmen varchar(100),IN numUtil int)
BEGIN
	UPDATE Floors SET FAmenities = fAmen, NumUtilities = numUtil WHERE FloorNo = dFNo;
END //
DELIMITER ;

-- check if there's a certain floor number
DELIMITER // 
CREATE PROCEDURE checkFloor(IN fNo int)
BEGIN
	SELECT * FROM Floors WHERE FloorNo = fNo;
END //
DELIMITER ;

-- ROOM -----------------------------------------------------------------------------------------------------------------

-- check if there's a certain room
DELIMITER // 
CREATE PROCEDURE checkRoom(IN fNo int,IN rNo int)
BEGIN
	SELECT * FROM Room WHERE FloorNo = fNo AND RoomNo = rNo;
END //
DELIMITER ;

-- used in roomEmpRead()
DELIMITER // 
CREATE PROCEDURE roomEmpRead()
BEGIN
	SELECT * FROM Room;
END //
DELIMITER ;

-- Used in roomEmpWrite()
DELIMITER // 
CREATE PROCEDURE roomEmpWrite(IN fNo int,IN rNo int)
BEGIN
	UPDATE Room SET CleanStatus = TRUE WHERE FloorNo = fNo AND RoomNo = rNo;
END //
DELIMITER ;

-- Used in maintEmpWrite()
DELIMITER // 
CREATE PROCEDURE checkMaint(IN fNo int,IN eSSN varchar(9))
BEGIN
	SELECT * FROM MaintHandling WHERE MaintSSN = eSSN AND FloorNo = fNo;
END //
DELIMITER ;

-- Used in maintEmpWrite()
DELIMITER // 
CREATE PROCEDURE maintNew(IN fNo int,IN eSSN varchar(9))
BEGIN
	INSERT INTO MaintHandling VALUES (eSSN,fNo);
END //
DELIMITER ;

-- Used in roomRecepWrite()
DELIMITER // 
CREATE PROCEDURE checkIn(IN fNo int,IN rNo int,IN gID varchar(10),IN iDate date)
BEGIN
	UPDATE Room SET CleanStatus = 0, GCheckIn = gID, ChkInDate = iDate, GCheckOut = NULL, ChkOutDate = NULL WHERE FloorNo = fNo AND RoomNo = rNo;
END //
DELIMITER ;

-- Used in roomRecepWrite()
DELIMITER // 
CREATE PROCEDURE checkOut(IN fNo int,IN rNo int,IN gID varchar(10),IN iDate date,IN oDate date)
BEGIN
	UPDATE Room SET GCheckIn = gID, ChkInDate = iDate, GCheckOut = gID, ChkOutDate = oDate WHERE FloorNo = fNo AND RoomNo = rNo;
END //
DELIMITER ;

-- Used in roomAdmin()
DELIMITER // 
CREATE PROCEDURE roomAdmin(IN fNo int,IN rNo int,IN cost int,IN bed int,IN rType varchar(100))
BEGIN
	UPDATE Room SET Cost = cost, Beds = bed, RoomType = rType WHERE FloorNo = fNo AND RoomNo = rNo;
END //
DELIMITER ;

-- DEPENDENT & DEPBENEFITS -----------------------------------------------------------------------------------------------------------------

-- Used to check if specific dependent exists
DELIMITER // 
CREATE PROCEDURE checkDep(IN eSSN varchar(9),IN dSSN varchar(9))
BEGIN
	SELECT * FROM Dependent WHERE EmpSSN = eSSN AND DepSSN = dSSN;
END //
DELIMITER ;

-- Used in depEmp()
DELIMITER // 
CREATE PROCEDURE depEmpRead(IN eSSN varchar(9))
BEGIN
	SELECT * FROM Dependent WHERE EmpSSN = eSSN;
END //
DELIMITER ;

-- Used in depEmp()
DELIMITER // 
CREATE PROCEDURE depBenEmpRead(IN eSSN varchar(9))
BEGIN
	SELECT * FROM DepBenefits WHERE EmpSSN = eSSN;
END //
DELIMITER ;

-- Used in depAdminRead()
DELIMITER // 
CREATE PROCEDURE depAdminRead()
BEGIN
	SELECT * FROM Dependent;
END //
DELIMITER ;

-- Used in depAdminRead()
DELIMITER // 
CREATE PROCEDURE depBenAdminRead()
BEGIN
	SELECT * FROM DepBenefits;
END //
DELIMITER ;

-- Used in depEmp()
DELIMITER // 
CREATE PROCEDURE depWrite(IN eSSN varchar(9),IN dSSN1 varchar(9),IN dSSN varchar(9),IN dName varchar(50))
BEGIN
	UPDATE Dependent SET DepSSN = dSSN, DepName = dName WHERE EmpSSN = eSSN and DepSSN = dSSN1;
END //
DELIMITER ;

-- Used in depEmp()
DELIMITER // 
CREATE PROCEDURE depNew(IN eSSN varchar(9),IN dSSN varchar(9),IN dName varchar(50))
BEGIN
	INSERT INTO Dependent VALUES (eSSN,dSSN,dName);
END //
DELIMITER ;

-- Used in depAdminDel()
DELIMITER // 
CREATE PROCEDURE depDel(IN eSSN varchar(9),IN dSSN varchar(9))
BEGIN
	DELETE FROM Dependent WHERE EmpSSN = eSSN AND DepSSN = dSSN;
END //
DELIMITER ;

-- Used in depBenAdminNew()
DELIMITER // 
CREATE PROCEDURE depBenNew(IN eSSN varchar(9),IN dSSN varchar(9),IN dBen varchar(500))
BEGIN
	INSERT INTO DepBenefits VALUES (eSSN,dSSN,dBen);
END //
DELIMITER ;

-- Used in depBenAdminDel()
DELIMITER // 
CREATE PROCEDURE depBenDel(IN eSSN varchar(9),IN dSSN varchar(9),IN dBen varchar(500))
BEGIN
	DELETE FROM DepBenefits WHERE EmpSSN = eSSN AND DepSSN = dSSN and DepBenefits = dBen;
END //
DELIMITER ;