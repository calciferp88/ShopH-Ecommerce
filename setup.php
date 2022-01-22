				<?php

$connect = mysqli_connect('localhost','root','','shophdb');

//--DROP 

$dropads = "DROP TABLE Advertisement";
$run = mysqli_query($connect, $dropads);
if($run){echo "Ads Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropadminmessage = "DROP TABLE adminmessage";
$run = mysqli_query($connect, $dropadminmessage);
if($run){echo "AdminMessage Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropmessagereply = "DROP TABLE messagereply";
$run = mysqli_query($connect, $dropmessagereply);
if($run){echo "Message REply Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropdelivery = "DROP TABLE delivery";
$run = mysqli_query($connect, $dropdelivery);
if($run){echo "Delivery Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropdeliverystaff = "DROP TABLE deliverystaff";
$run = mysqli_query($connect, $dropdeliverystaff);
if($run){echo "Delivery staff Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropdeliverycompany = "DROP TABLE deliverycompany";
$run = mysqli_query($connect, $dropdeliverycompany);
if($run){echo "Delivery company Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$droporderproduct = "DROP TABLE checkoutproduct";
$run = mysqli_query($connect, $droporderproduct);
if($run){echo "Checkoutproduct Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$AuctionID = "DROP TABLE Auction";
$run = mysqli_query($connect, $AuctionID);
if($run){echo "Auction Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropproduct = "DROP TABLE Product";
$run = mysqli_query($connect, $dropproduct);
if($run){echo "Product Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$droporder = "DROP TABLE checkout";
$run = mysqli_query($connect, $droporder);
if($run){echo "Checkout Table Dropped</br>";}
	else{echo mysqli_error($connect);};


$dropmessage = "DROP TABLE message";
$run = mysqli_query($connect, $dropmessage);
if($run){echo "Message Table Dropped</br>";}
	else{echo mysqli_error($connect);};


$dropstaff = "DROP TABLE Staff";
$run = mysqli_query($connect, $dropstaff);
if($run){echo "Staff Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropbrand = "DROP TABLE Brand";		
$run = mysqli_query($connect, $dropbrand);
if($run){echo "Brand Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropsubcategory = "DROP TABLE SubCategory";
$run = mysqli_query($connect, $dropsubcategory);
if($run){echo "SubCategory Table Dropped</br>";}
	else{echo mysqli_error($connect);};

$dropcategory = "DROP TABLE Category";
$run = mysqli_query($connect, $dropcategory);
if($run){echo "Category Table Dropped</p>";}
	else{echo mysqli_error($connect);};

$dropcustomer = "DROP TABLE Customer";
$run = mysqli_query($connect, $dropcustomer);
if($run){echo "Customer Table Dropped</br>";}
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

$createcustomer = "CREATE TABLE Customer (
 CustomerID VARCHAR(10) NOT NULL PRIMARY KEY,
	CustomerVisibleID VARCHAR(10),
	CustomerName VARCHAR(30),
	CustomerEmail VARCHAR(30),	
	CustomerPassword TEXT,
	CustomerPhone INT,
	CustomerDateofBirth DATE,
	CustomerGender VARCHAR(10),
	CustomerCountry VARCHAR(30),
	CustomerPostalCode VARCHAR(20),
	CustomerAddress TEXT,
	CustomerasSeller BOOLEAN,
	ChatWithAdmin INT(11),	
	CustomerPicture TEXT,
	CustomerVerification TEXT,
	CustomerRating INT,  
	Status VARCHAR(10))";

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

$createsubcategory = "CREATE TABLE SubCategory (SubCategoryID VARCHAR(20) NOT NULL PRIMARY KEY,
	SubCategoryName VARCHAR(50),
	CategoryID VARCHAR(20),
	FOREIGN KEY(CategoryID) REFERENCES Category(CategoryID))";

$createproduct = "CREATE TABLE Product (ProductID VARCHAR(30) NOT NULL PRIMARY KEY,
	ProductName VARCHAR(50),
	ProductDescription TEXT,
	Price INT,
	Stock INT,
	Review TEXT,
	UploadDate DATE,	
	CustomerID VARCHAR(10),
	TotalSale INT,
	SubCategoryID VARCHAR(20),
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
	FOREIGN KEY(CustomerID) REFERENCES Customer(CustomerID),
	FOREIGN KEY(SubCategoryID) REFERENCES SubCategory(SubCategoryID),
	FOREIGN KEY(BrandID) REFERENCES Brand(BrandID))";

$createcheckout = "CREATE TABLE checkout (CheckoutID VARCHAR(10) NOT NULL PRIMARY KEY,
	CheckoutDate DATE, 
	CheckoutDay INT, 
	CheckoutMonth VARCHAR(30), 
	CheckoutYear INT, 
	TotalPrice INT,		
	PaymentType VARCHAR(30),
	CardType VARCHAR(30),
	Nameoncard VARCHAR(30),	
	CardNumber TEXT, 
	Expmonth Varchar(30), 
	ExpYear Varchar(30), 
	CVV INT,
	FullAddress TEXT,
	Status VARCHAR(30),
	CustomerID VARCHAR(10),
	SellerID VARCHAR(10),
	FOREIGN KEY(SellerID) REFERENCES Customer(CustomerID),	
	FOREIGN KEY(CustomerID) REFERENCES Customer(CustomerID))";


$createcheckproduct = "CREATE TABLE checkoutproduct 
(	CheckoutID VARCHAR(10), 
	ProductID VARCHAR(30),
	FOREIGN KEY(CheckoutID) REFERENCES checkout(CheckoutID),
	FOREIGN KEY(ProductID) REFERENCES product(ProductID),
	Quantity INT
)";


$createauction = "CREATE TABLE auction 	
	(   AuctionID VARCHAR(10) NOT NULL PRIMARY KEY,
		StartDate DATE,
		StartTime Time,
		EndDate DATE, 
		EndTime Time,
		StartBid INT,
		IncreaseBid INT,
		CurrentBid INT,
		BidTimes INT,
		Maxbid INT,	
		Status VARCHAR(30),
		ProductID VARCHAR(10),
		CustomerID VARCHAR(10),
		FOREIGN KEY(ProductID) REFERENCES product(ProductID),
		FOREIGN KEY(CustomerID) REFERENCES customer(CustomerID)	
	)";


$createdeliverycompany = "CREATE TABLE deliverycompany 	
	(   CompanyID VARCHAR(10) NOT NULL PRIMARY KEY,
		CompanyName Varchar(30),
		CompanyEmail VARCHAR(40), 
		CompanyLogo TEXT,
		Description TEXT
	)";


$createdeliverystaff = "CREATE TABLE deliverystaff 	
	(   DeliveryStaffID VARCHAR(10) NOT NULL PRIMARY KEY,
		DeliveryStaffName Varchar(30),
		DeliveryStaffEmail VARCHAR(40), 
		DeliveryStaffPassword TEXT, 
		DeliveryStaffPhone VARCHAR(30),
		DeliveryStaffRole VARCHAR(30),
		Status VARCHAR(50), 
		CompanyID VARCHAR(10),
		FOREIGN KEY(CompanyID) REFERENCES deliverycompany(CompanyID)
	)";

$createdelivery = "CREATE TABLE delivery	
	(   DeliveryID VARCHAR(10) NOT NULL PRIMARY KEY,	
		OrderID VARCHAR(10),
		DeliveryStaffID VARCHAR(10),
		ArriveDate DATE,
		FOREIGN KEY(OrderID) REFERENCES checkout(CheckoutID),
		FOREIGN KEY(DeliveryStaffID) REFERENCES deliverystaff(DeliveryStaffID)
	)";

    	$createmessage = "CREATE TABLE message	
		(   MessageID VARCHAR(10) NOT NULL PRIMARY KEY,	
			Sender1 VARCHAR(10),
			Sender2 VARCHAR(10),
			FOREIGN KEY(Sender1) REFERENCES customer(CustomerID),
			FOREIGN KEY(Sender2) REFERENCES customer(CustomerID)
		)";
	 
		$createmessagereply	 = "CREATE TABLE messagereply 
		(   MessageReplyID VARCHAR(10) NOT NULL PRIMARY KEY,	
			SendDate Date,
			SendTime time,
			Message TEXT,
			ReadStatus BOOLEAN,
			Sender VARCHAR(10),
			MessageID VARCHAR(10),
			FOREIGN KEY(Sender) REFERENCES customer(CustomerID),
			FOREIGN KEY(MessageID) REFERENCES message(MessageID)
		)";

		$createadminmessage = "CREATE TABLE adminmessage	
		(   AdminMessageID VARCHAR(10) NOT NULL PRIMARY KEY,	
			CustomerID VARCHAR(10), 
			Message TEXT,
			ReadStatus Boolean,
			Sender Varchar(10),
			Time Time,
			Date Date,
			FOREIGN KEY(CustomerID) REFERENCES customer(CustomerID)
		)";

		$createadvertisement = "CREATE TABLE advertisement	
		(   AdvertisementID VARCHAR(10) NOT NULL PRIMARY KEY,
			SellerID VARCHAR(10),
			Image TEXT,
			StartDate VARCHAR(10), 
			DateLength INT,
			Day1 DATE,
			Day2 DATE,
			Day3 DATE,
			PurchasedAmount INT,
			ActiveStatus Boolean,
			PurchaseStatus Varchar(10),
			FOREIGN KEY(SellerID) REFERENCES customer(CustomerID)
		)";

//	---RUN---
	$runseller = mysqli_query($connect, $createseller);
	$runcustomer = mysqli_query($connect, $createcustomer);
	$runstaff    = mysqli_query($connect, $createstaff);
	$runbrand    = mysqli_query($connect, $createbrand);
	$runcategory = mysqli_query($connect, $createcategory);
	$runsubcategory = mysqli_query($connect, $createsubcategory);
	$runproduct     = mysqli_query($connect, $createproduct); 
	$runcheckout    = mysqli_query($connect, $createcheckout);
	$runcheckoutproduct = mysqli_query($connect, $createcheckproduct);
	$runauction  		= mysqli_query($connect, $createauction);
	$rundeliverycompany = mysqli_query($connect, $createdeliverycompany);
	$rundeliverystaff 	= mysqli_query($connect, $createdeliverystaff);
	$rundelivery 	= mysqli_query($connect, $createdelivery);
	$runmessage 	 = mysqli_query($connect, $createmessage);
	$runmessagereply = mysqli_query($connect, $createmessagereply);
	$runadminmessage = mysqli_query($connect, $createadminmessage);
	$runadvertisement = mysqli_query($connect, $createadvertisement);

if ($runseller){
	echo "Seller Table Created</br>";
}else{	echo mysqli_error($connect);}


if ($runcustomer){
	echo "Customer Table Created</br>";
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

if ($runsubcategory){
	echo "SubCategory Table Created</br>";
}
else{	echo mysqli_error($connect);}

if ($runproduct){
	echo "Product Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runcheckout){
	echo "Checkout Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runcheckoutproduct){
	echo "CheckoutProduct Table Created</br>";
}else{	echo mysqli_error($connect);}

if ($runauction){     
echo "Auction Table Created</br>"; 
}else{  echo mysqli_error($connect);}

if ($rundeliverycompany){     
echo "Delivery Company Table Created</br>"; 
}else{  echo mysqli_error($connect);}

if ($rundeliverystaff){     
echo "Delivery Staff Table Created</br>"; 
}else{  echo mysqli_error($connect);}

if ($rundelivery){     
echo "Delivery Table Created</br>"; 
}else{  echo mysqli_error($connect);}

if ($runmessage){     
echo "Message Table Created</br>"; 
}else{  echo mysqli_error($connect);}

if ($runmessagereply){     
echo "Reply Message Table Created</br>"; 
}else{  echo mysqli_error($connect);}


if ($runadminmessage){     
echo "Admin Message Table Created</br>"; 
}else{  echo mysqli_error($connect);}


if ($runadvertisement){
	echo "Advertisement Table Created</p>";
}else{	echo mysqli_error($connect);}

//---INSERT---

$hapass = password_hash('test', PASSWORD_DEFAULT);

$insertadmin = "INSERT INTO Staff VALUES (1, 'Hein', 'admin@shoph.com', '$hapass', 'System Administrator', '1/1/1991', 09456269274, '31C Mahamyaing Sanchaung')";
$insertcom = "INSERT INTO deliverycompany VALUES (1, 'Grab', 'grabcom@gmail.com', '', '')";
$insertstf	 = "INSERT INTO deliverystaff VALUES (1, 'Hein Htet Aung', 'admin@grab.com', '$hapass', '0978877666', 'Admin', '', '1')";

//---RUN INSERT---
$runia = mysqli_query($connect, $insertadmin);
$runic = mysqli_query($connect, $insertcom);
$runistf = mysqli_query($connect, $insertstf);

if ($runia){     
echo "Admin Data inserted</br>"; 
}else{  echo mysqli_error($connect);}


if ($runic){     
echo "Delivery Company inserted</br>"; 
}else{  echo mysqli_error($connect);}


if ($runistf){
	echo "Delivery Staff inserted</br>";
}else{	echo mysqli_error($connect);}



?>