# hotel-mgmt-website
Group term project for CPSC471 (Introduction to Databases) as UCalgary.

# Installing software
This website and API were creating using the XAMPP development platform. Thus, it uses Apache, MySQL, and PHP. 
Before running the website, make sure to install:
1. XAMPP from the [XAMPP website](https://www.apachefriends.org/download.html) and download the latest version for your OS.
2. MySQL from the [MySQL website](https://dev.mysql.com/downloads/mysql/) and download the latest version for your OS.
3. Postman from the [Postman website](https://www.postman.com/downloads/).

# Starting XAMPP and MySQL
1. Navigate to the XAMPP application and ***run it as administrator**.
2. For the Apache module, click Start under Actions. The "Apache" name under Module should turn green if successful.
3. For the MySQL module, click Start under Actions. The "MySQL" name under Module should turn green if successful. If this isn't successful...
   1. [Make sure that xampp is being called in regedit](https://stackoverflow.com/questions/21279442/xampp-mysql-not-starting-attempting-to-start-mysql-service/41664326#:~:text=If%20my%20sql%20running%20But,.......&text=One%20of%20many%20reasons%20is,is%20run%20mySQL%20service%20manually.)
   2. Make sure the MySQL service is running 
   3. If MySQL service isn't running, open Services, go to Properties, and make sure that 
    the mySQL service is set to run automatically.
4. After both are running, you may safely start up a MySQL server.
   1. Run MySQL.
   2. Click your local server to run it.
   3. A warning will appear that your port is currently being used by something else (it is, by XAMPP). Click "Continue Anyway".

# Running the website
1. Download the files from this repository and unzip it. 
2. 

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
