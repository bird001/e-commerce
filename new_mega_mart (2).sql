CREATE DATABASE  IF NOT EXISTS `new_mega_mart`  ;
USE `new_mega_mart`;

CREATE TABLE `Customer` (
  `CustomerId` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,  
  `CustomerType` varchar(50),
  `Points` int,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB   DEFAULT CHARSET=latin1;

CREATE TABLE `Contact` (
  `CustomerId` int NOT NULL,
  `ContactType` varchar(50) NOT DEFAULT NULL,
  `ContactDetail` varchar(50) NOT DEFAULT NULL,
   PRIMARY KEY (`CustomerId`,`ContactType`,`ContactDetail`),
   CONSTRAINT `fk_contact_custid` FOREIGN KEY (`CustomerId`) REFERENCES `Customer`(`CustomerId`)
) ENGINE=InnoDB   DEFAULT CHARSET=latin1;

 CREATE TABLE `Business` (
  `CustomerId` int ,
  `AgencyName` varchar(100) NOT NULL,
  `Trn` int DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL, 
  CONSTRAINT `fk_cust` FOREIGN KEY (`CustomerId`) REFERENCES `Customer` (`CustomerId`)
) ENGINE=InnoDB   DEFAULT CHARSET=latin1;
 
 
CREATE TABLE `Address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerId` int ,
  `Address1` varchar(100) DEFAULT NULL, 
  `Address2` varchar(100) DEFAULT NULL, 
  `Parish` varchar(50) DEFAULT NULL, 
  `BillingAddressFlag` char(1) DEFAULT NULL,
  `ShippingAddressflag` char(1) DEFAULT NULL,
  PRIMARY KEY (`address_id`),
   CONSTRAINT `fk_addr_cust` FOREIGN KEY (`CustomerId`) REFERENCES `Customer` (`CustomerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


 CREATE TABLE `Transaction` (
  `TransID` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int ,
  `TransDateTime` datetime DEFAULT NULL, 
  `DeliveryTime` datetime DEFAULT NULL, 
  `Subtotal` decimal(6,2) DEFAULT NULL, 
  `GCT` decimal(5,2) DEFAULT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`TransID`),
   CONSTRAINT `fk_trans_cust` FOREIGN KEY (`CustomerId`) REFERENCES `Customer` (`CustomerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

 CREATE TABLE `InventoryCategory` (
  `CategoryId` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(50),
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `Inventory` (
  `InventoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryId` int(11) NOT NULL,
  `Inventory_name` varchar(50) DEFAULT NULL,
  `Description` varchar(300) DEFAULT NULL,
  `Brand` varchar(50) DEFAULT NULL,
  `Cost` decimal(15,2) DEFAULT NULL,
  `Length` decimal(5,2) DEFAULT NULL,
  `Width` decimal(5,2) DEFAULT NULL,
  `Height` decimal(5,2) DEFAULT NULL,
  `Weight` decimal(5,2) DEFAULT NULL,
  `Volume` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`InventoryID`),
  KEY `fk_cat_id` (`CategoryId`),
  CONSTRAINT `fk_cat_id` FOREIGN KEY (`CategoryId`) REFERENCES `InventoryCategory` (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `ShoppingCart` (
  `CustomerId` int NOT NULL AUTO_INCREMENT,
  `InventoryId` int NOT NULL, 
  PRIMARY KEY (`CustomerId`,`InventoryID`),
  CONSTRAINT `fk_shop_cust` FOREIGN KEY (`CustomerId`) REFERENCES `Customer` (`CustomerId`),
  CONSTRAINT `fk_shop_invt` FOREIGN KEY (`InventoryId`) REFERENCES `Inventory` (`InventoryId`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

 CREATE TABLE `Purchases` (
  `TransID` int NOT NULL AUTO_INCREMENT,
  `InventoryId` int NOT NULL, 
  `Cost`  decimal(5,2) NOT NULL,
  PRIMARY KEY (`TransID`,`InventoryID`),
  CONSTRAINT `fk_purch_transid` FOREIGN KEY (`TransID`) REFERENCES `Transaction` (`TransID`),
  CONSTRAINT `fk_purch_invt` FOREIGN KEY (`InventoryId`) REFERENCES `Inventory`  (`InventoryId`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
  
   CREATE TABLE `Branch` (
  `BranchId` int NOT NULL AUTO_INCREMENT,
  `BranchName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`BranchId`)
) ENGINE=InnoDB   DEFAULT CHARSET=latin1; 

 
 CREATE TABLE `UserAccess` (
  `CustomerId` int NOT NULL,
  `UserName` varchar(50),
  `password` varchar(256) DEFAULT NULL,
  `UserType` varchar(50),
  `DateCreated` datetime DEFAULT NULL,
  `DateLastUpdated` datetime DEFAULT NULL,
  Primary Key (`UserName`),
  CONSTRAINT `fk_user_access` FOREIGN KEY (`CustomerId`) REFERENCES `Customer` (`CustomerId`)
  )ENGINE=InnoDB   DEFAULT CHARSET=latin1; 
 
 CREATE TABLE `Reviews` (
  `ReviewId` int NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `InventoryId` int(11) NOT NULL,
  `quality_rating` int(11) DEFAULT NULL,
  `price_rating` int(11) DEFAULT NULL,
  `review_content` text,
  `date_created` datetime DEFAULT NULL,
  `date_last_updated` datetime DEFAULT NULL,
   PRIMARY KEY (`ReviewId`),
   CONSTRAINT `fk_review_Inventory` FOREIGN KEY (`InventoryId`) REFERENCES `Inventory` (`InventoryId`), 
   CONSTRAINT `fk_review_user` FOREIGN KEY (`UserName`) REFERENCES `UserAccess` (`UserName`)  
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
 
CREATE TABLE InventoryQuantity
(
 `InventoryId` int,
 `Quantity` int,
 `BranchId` int,
 `DateLastUpdated` datetime,
 PRIMARY KEY(InventoryId,BranchId),
 CONSTRAINT `fk_iq_inventid` FOREIGN KEY (`InventoryId`) REFERENCES `Inventory` (`InventoryId`),
 CONSTRAINT `fk_iq_branchid` FOREIGN KEY (`BranchId`) REFERENCES `Branch` (`BranchId`)
)Engine=InnoDB
 
 
 DELIMITER //
Create PROCEDURE sp_login(IN p_username varchar(50),p_password varchar(256))
   BEGIN 
   SELECT UserName  FROM UserAccess where username=p_username and password=p_password ;
   END //
DELIMITER ;

#call sp_login('dd','abcdf')


DELIMITER //
Create PROCEDURE sp_CheckUserExist(IN p_username varchar(50))
   BEGIN 
   
   Set @username_exists= 0;
    
	SELECT count(*) Into @found
    FROM UserAccess 
    WHERE Username = p_username;
    IF @found > 0 THEN
        SET @username_exists = 1;
    END IF;
    
    Select  @username_exists;
   END //
DELIMITER ;

#call sp_CheckUserExsist('d')

DELIMITER //
Create PROCEDURE sp_InsertCustomer(IN p_fname varchar(100),p_lname varchar(100),p_dob date,p_type varchar(50),p_points int)
   BEGIN 
   
   INSERT INTO 
   CUSTOMER(
   `FirstName`,
   `LastName`,
   `dob`,  
   `CustomerType`,
   `Points`
   )
   VALUES
   (
   p_fname,
   p_lname,
   p_dob,
   p_type,
   p_points
   );
   END //
DELIMITER ;

#call sp_InsertCustomer('Eren','Yeager','1989-05-6','Customer',0)

DELIMITER //
Create PROCEDURE sp_InsertContactDetail(IN p_custId int,p_CustType varchar(50),p_detail varchar(50))
   BEGIN 
   
   INSERT INTO 
   Contact(
   `CustomerId`,
   `ContactType`,
   `ContactDetail`
   )
   VALUES
   (
   p_custId,
   p_CustType,
   p_detail
   );
   END //
DELIMITER ;

#Call sp_InsertContactDetail (2,'Email','danzdwyer@gmail.com')

#Call sp_InsertContactDetail (2,'Mobile','3632322')

#Call sp_InsertContactDetail (2,'Tele_Home','3632322')

#Call sp_InsertContactDetail (2,'Tele_Work','1234567')
 

DELIMITER //
Create PROCEDURE sp_GetContactDetails(IN p_custId int)
   BEGIN 
   
   SELECT CustomerId,ContactType,ContactDetail FROM Contact WHERE CustomerId=p_custid;
    
   END //
DELIMITER ;

#Call sp_GetContactDetails (2)

DELIMITER //
Create PROCEDURE sp_InsertAddress(IN p_custId int,IN p_Address1 varchar(100),p_Address2 varchar(100),
p_Parish varchar(50),p_BillingFlag varchar(1),p_ShippingFlag varchar(1))
   BEGIN 
   
   INSERT INTO 
    Address(
   `CustomerId`,
   `Address1`,
   `Address2`,
   `Parish`,
   `BillingAddressFlag`,
   `ShippingAddressflag`
   )
   VALUES
   (
   p_custId,
   p_Address1,
   p_Address2,
   p_Parish,
   p_BillingFlag,
   p_ShippingFlag
   );
   END //
DELIMITER ;
#every field except customerid can be null
#Call sp_InsertAddress (2,'5 hope boulevard','Kingston 6','Kingston','Y',null);

DELIMITER //
Create PROCEDURE sp_GetCustomerAddress(IN p_custId int)
   BEGIN 
   
 
  SELECT * FROM  Address WHERE CUSTOMERID=p_custId;
   
   END //
DELIMITER ;

#Call sp_GetCustomerAddress (2);
  
DELIMITER //
Create PROCEDURE sp_GetInventoryCategory()
   BEGIN 
   
    Select  `CategoryId`,CategoryName from InventoryCategory;
   END //
DELIMITER ;

 
DELIMITER //
Create PROCEDURE sp_InsertInventory
(IN p_CatId int,IN p_InventName varchar(50),IN p_descript varchar(300), IN p_brand varchar(50),
 IN p_Cost decimal(15,2),p_Length decimal(5,2),p_Width decimal(5,2),p_Height decimal(5,2),
 p_Weight decimal(5,2), p_volume decimal(5,2)
)
   BEGIN 
   INSERT INTO Inventory
	(
	`CategoryId`,
	`Inventory_name`,
	`Description`,
	`Brand`,
	`Cost`, 
	`Length`, 
	`Width`, 
	`Height`, 
	`Weight`,
	`Volume`
	)
	VALUES
	(
     p_CatId,
     p_InventName,
     p_descript,
     p_brand,
     p_Cost,
     p_Length,
     p_Width,
     p_Height,
     p_Weight,
     p_volume
    );
 
   END //
DELIMITER ;

#CALL sp_InsertInventory(1,'Magic Bullet','Blends fruits','LG',1500,150,75,75,5,300)




DELIMITER //
CREATE PROCEDURE sp_GetInventory
(IN p_SearchValue varchar(100),IN p_filter varchar(50))
   BEGIN 
   IF(p_filter ='Brand') 
   THEN
   SELECT * FROM Inventory WHERE BRAND like CONCAT('%',p_SearchValue,'%'); 
   END IF;
   IF(p_filter ='Price') 
   THEN
   SELECT * FROM Inventory WHERE cost like CONCAT('%',p_SearchValue,'%'); 
   END IF;
    IF(p_filter ='Description') 
   THEN
   SELECT * FROM Inventory WHERE description like CONCAT('%',p_SearchValue,'%'); 
   END IF;
   END //
DELIMITER ;



#Call sp_GetInventory('lg','Brand');
#Call sp_GetInventory(1500,'Price');
#Call sp_GetInventory('blend','Description');




DELIMITER //
Create PROCEDURE sp_InsertReview
(IN p_UserName varchar(50), IN p_InventoryId int,IN p_QualityRating int,IN p_PriceRating INT,
 IN p_content text
)
   BEGIN 
   
   INSERT INTO Reviews
	(
	 `UserName`,
     `InventoryId`,
     `quality_rating`,
  	 `price_rating`,
     `review_content`,
     `date_created`
	)
	VALUES
	(
     p_UserName,
     p_InventoryId,
     p_QualityRating,
     p_PriceRating,
     p_content,
     NOW()
    );
 
   END //
DELIMITER ;

#CALL sp_InsertReview('dd',1,4,4,'amazing product');

DELIMITER //
Create PROCEDURE sp_GetBranch()
   BEGIN 
   
    Select  `BranchId`,BranchName from Branch;
   END //
DELIMITER ;

DELIMITER //
Create PROCEDURE sp_InventoryQuantity
(IN p_InvtId int, IN p_BranchId int,IN p_Quantity int)
   BEGIN 
   
   INSERT INTO InventoryQuantity
	( 
     `InventoryId`,
     `BranchId`,
     `Quantity`,
     `DateLastUpdated`
	)
	VALUES
	(
     p_InvtId,
     p_BranchId,
     p_Quantity, 
     NOW()
    );
 
   END //
DELIMITER ;

#Call sp_InventoryQuantity(1,1,5)


DELIMITER //
Create PROCEDURE sp_GetInventoryOverview()
BEGIN
SELECT 
InventoryQuantity.InventoryID,
Inventory_name,Brand,Description,
branch.BranchId,BranchName,
Quantity,DateLastUpdated
from InventoryQuantity
inner join branch
on InventoryQuantity.BranchId=branch.BranchId
inner join Inventory
on InventoryQuantity.InventoryId=Inventory.InventoryID;
END //
DELIMITER ;

#CALL sp_GetInventoryOverview()




 