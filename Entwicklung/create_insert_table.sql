

CREATE TABLE Tisch(
	tischNr int NOT NULL,
	kapazitaet int,
	primary key(tischNr)
);

CREATE TABLE Maturant(
	mEmail varchar(50) not null,
	password varchar(20),
	vorname varchar(50),
	nachname varchar(50),
	primary key (mEmail)
);

CREATE TABLE Kunde(
	barcode int not null,
	vorname varchar(50),
	nachname varchar(50),
	alterK int,
	inK boolean default false,
	tischNr int,
	mEmail varchar(50),
	primary key (barcode),
	foreign key (tischNr) references Tisch (tischNr),
	foreign key (mEmail) references Maturant (mEmail)
);