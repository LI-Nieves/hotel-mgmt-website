# hotel-mgmt-website
Group term project for CPSC471 (Introduction to Databases) as UCalgary.

# Sample data
Here is some code you can run in MySQL that will populate the database and would prove useful when testing our website:
```
DELETE FROM Guest;
DELETE FROM Employee;
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
INSERT INTO Room VALUES (2,1,125,2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2,2,125,2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2,3,125,2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2,4,125,2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (2,5,125,2, true, 'Regular', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3,1,200,2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3,2,200,2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3,3,200,2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3,4,200,2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Room VALUES (3,5,200,2, true, 'Deluxe', NULL, NULL, NULL, NULL);
INSERT INTO Reservation VALUES ('1111111111',2,1,'1234567890','1999-01-01','1999-01-05','1234567890',2,NULL);
INSERT INTO Transactions VALUES ('7894561231',NULL,NULL,5000,NULL,NULL);
INSERT INTO Transactions VALUES ('7894561230','2021-01-01','Visa',3000,'1111111111','555555555');
INSERT INTO Dependent VALUES ("555555555","789456123","Michael Scott");
INSERT INTO DepBenefits VALUES ("555555555","789456123","Health insurance");
INSERT INTO PhoneCall VALUES ("1234567890","15","2021-01-10","1111111111","555555555");
```
