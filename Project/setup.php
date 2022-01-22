<?php

$connect = mysqli_connect('localhost','root','','shophdb');

//--DROP 

$dropproduct = "DROP TABLE Product";
$run = mysqli_query($connect, $dropproduct);
if($run){echo "Product Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropstaff = "DROP TABLE Staff";
$run = mysqli_query($connect, $dropstaff);
if($run){echo "Staff Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropseller = "DROP TABLE Seller";
$run = mysqli_query($connect, $dropseller);
if($run){echo "Seller Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropcategory = "DROP TABLE Category";
$run = mysqli_query($connect, $dropcategory);
if($run){echo "Category Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropbrand = "DROP TABLE Brand";
$run = mysqli_query($connect, $dropbrand);
if($run){echo "Brand Table Dropped</p>";}
	else{echo mysqli_error($connect);};


//---CREATE---

$createseller = "CREATE TABLE Seller (SellerID VARCHAR(10) NOT NULL PRIMARY KEY, 
	SellerCompany VARCHAR(30), 
	SellerEmail VARCHAR(30), 
	SellerPassword TEXT,
	SellerPhone INT,
	SellerLogo TEXT, 
	SellerCountry VARCHAR(30),
	SellerPostalCode INT,
	SellerAddress TEXT, 
	SellerRating INT,
	CreditCardID INT,
	RegistrationFee BOOLEAN)";

$createstaff = "CREATE TABLE Staff (StaffID VARCHAR(10) NOT NULL PRIMARY KEY,
	StaffName VARCHAR(50), 
	StaffEmail VARCHAR(30), 
	StaffPassword TEXT,
	StaffPosition VARCHAR(20),
	StaffDoB DATE,
	StaffPhone INT,
	StaffAddress TEXT)";

$createbrand = "CREATE TABLE Brand (BrandID VARCHAR(20) NOT NULL PRIMARY KEY,
	BrandName VARCHAR(50),
	BrandLogo TEXT)";

$createcategory = "CREATE TABLE Category (CategoryID VARCHAR(20) NOT NULL PRIMARY KEY,
	CategoryName VARCHAR(50))";

$createproduct = "CREATE TABLE Product (ProductID VARCHAR(30) NOT NULL PRIMARY KEY,
	ProductName VARCHAR(50),
	ProductDescription TEXT,
	Price INT,
	Stock INT,
	Review TEXT,
	UploadDate DATE,
	SellerID VARCHAR(10),
	CategoryID VARCHAR(20),
	BrandID VARCHAR(20),
	ProductPicture0 TEXT,
	ProductPicture1 TEXT,
	ProductPicture2 TEXT,
	ProductPicture3 TEXT,
	ProductPicture4 TEXT,
	ProductOption1 TEXT,
	ProductOption2 TEXT,
	ProductOption3 TEXT,
	ProductOption4 TEXT,
	FOREIGN KEY(SellerID) REFERENCES Seller(SellerID),
	FOREIGN KEY(CategoryID) REFERENCES Category(CategoryID),
	FOREIGN KEY(BrandID) REFERENCES Brand(BrandID))";

//---RUN---

$runseller = mysqli_query($connect, $createseller);
$runstaff = mysqli_query($connect, $createstaff);
$runbrand = mysqli_query($connect, $createbrand);
$runcategory = mysqli_query($connect, $createcategory);
$runproduct = mysqli_query($connect, $createproduct);

if ($runseller){
	echo "Seller Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runstaff){
	echo "Staff Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runbrand){
	echo "Brand Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runcategory){
	echo "Category Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runproduct){
	echo "Product Table Created</p>";
}else{	echo mysqli_error($connect);}


//---INSERT---

$hapass = password_hash('test', PASSWORD_DEFAULT);

$insertadmin = "INSERT INTO Staff VALUES (1, 'Hein', 'admin@shoph.com', '$hapass', 'System Administrator', '1/1/1991', 09456269274, '31C Mahamyaing Sanchaung')";

//---RUN INSERT---

$runia = mysqli_query($connect, $insertadmin);


if ($runia){
	echo "Admin Data Inserted</br>";
}else{	echo mysqli_error($connect);}


?>