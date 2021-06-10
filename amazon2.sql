BEGIN TRANSACTION;
--!CLEMENTE MEUNIER
DROP TABLE IF EXISTS article;

CREATE TABLE article
	(nomarticle TEXT NOT NULL,
	refarticle TEXT PRIMARY KEY,
	marque TEXT NOT NULL,
	prix FLOAT NOT NULL,
	categorie TEXT NOT NULL);

INSERT INTO article VALUES('OXO Connect Large', '00001', 'Alcatel-Lucent', 1300.00, 'PABX');
INSERT INTO article VALUES('OXO Connect Medium', '00002', 'Alcatel-Lucent', 1000.00, 'PABX');
INSERT INTO article VALUES('OXO Connect Small', '00003', 'Alcatel-Lucent', 660.66, 'PABX');
INSERT INTO article VALUES('KX-HTS32', '00004', 'Panasonic', 500.00, 'PABX');
INSERT INTO article VALUES('KX-NCP1000BX', '00005', 'Panasonic', 1100.99, 'PABX');
INSERT INTO article VALUES('SL1000', '00006', 'NEC', 330.78, 'PABX');
INSERT INTO article VALUES('Temporis 180', '00007', 'Alcatel-Lucent', 15.99, 'Fixe');
INSERT INTO article VALUES('Premium Reflexes 4020', '00008', 'Alcatel-Lucent', 149, 'Fixe');
INSERT INTO article VALUES('KX-HDV230', '00009', 'Panasonic', 138.00, 'Fixe');
INSERT INTO article VALUES('KX-TGC210', '00010', 'Panasonic', 25.00, 'Fixe');
INSERT INTO article VALUES('DA210', '00011', 'Gigaset', 15.52, 'Fixe');
INSERT INTO article VALUES('Temporis 10 Pro', '00012', 'Alcatel-Lucent', 12.10, 'Fixe');
INSERT INTO article VALUES('AS690A', '00013', 'Gigaset', 40.00, 'Fixe');
INSERT INTO article VALUES('Mi 11 Ultra', '00014', 'Xiaomi', 1199.99, 'Mobile');
INSERT INTO article VALUES('Redmi Note 10', '00015', 'Xiaomi', 199.99, 'Mobile');
INSERT INTO article VALUES('IPhone 12', '00016', 'Apple', 1080.00, 'Mobile');
INSERT INTO article VALUES('Galaxy S20 FE', '00017', 'Samsung', 599.99, 'Mobile');
INSERT INTO article VALUES('Galaxy Z Fold2 5G', '00018', 'Samsung', 1799.99, 'Mobile');
INSERT INTO article VALUES('IPhone SE', '00019', 'Apple', 489.99, 'Mobile');
INSERT INTO article VALUES('Sunny2', '00020', 'Wiko', 50.00, 'Mobile');

DROP TABLE IF EXISTS PABX;

CREATE TABLE PABX
	(refarticle TEXT NOT NULL,
	modulable TEXT NOT NULL,
	supportip TEXT NOT NULL,
	nblignesmax TEXT NOT NULL);

INSERT INTO PABX VALUES('00001', 'oui', 'oui', '138');
INSERT INTO PABX VALUES('00002', 'oui', 'oui', '88');
INSERT INTO PABX VALUES('00003', 'oui', 'oui', '40');
INSERT INTO PABX VALUES('00004', 'non', 'oui', '8');
INSERT INTO PABX VALUES('00005', 'oui', 'oui', '128');
INSERT INTO PABX VALUES('00006', 'oui', 'oui', '128');

DROP TABLE IF EXISTS Fixe;

CREATE TABLE Fixe
	(refarticle TEXT NOT NULL,
	filaire TEXT NOT NULL,
	type TEXT NOT NULL,
	utilisation TEXT NOT NULL,
	touchefonction TEXT NOT NULL);

INSERT INTO Fixe VALUES('00007', 'oui', 'Analogique', 'Entreprise', 'non');
INSERT INTO Fixe VALUES('00008', 'oui', 'Numérique', 'Entreprise', 'oui');
INSERT INTO Fixe VALUES('00009', 'oui', 'Numérique', 'Entreprise', 'oui');
INSERT INTO Fixe VALUES('00010', 'non', 'Numérique', 'Personnel', 'non');
INSERT INTO Fixe VALUES('00011', 'oui', 'Analogique', 'Entreprise', 'non');
INSERT INTO Fixe VALUES('00012', 'oui', 'Analogique', 'Entreprise', 'non');
INSERT INTO Fixe VALUES('00013', 'non', 'Numérique', 'Personnel', 'non');

DROP TABLE IF EXISTS Mobile;

CREATE TABLE Mobile
	(refarticle TEXT NOT NULL,
	cinqg TEXT NOT NULL,
	stockage TEXT NOT NULL,
	ram TEXT NOT NULL,
	os TEXT NOT NULL,
	batterie TEXT NOT NULL,
	photo TEXT NOT NULL);

INSERT INTO Mobile VALUES('00014', 'oui', '256', '12', 'Android', '5000', '50');
INSERT INTO Mobile VALUES('00015', 'non', '64', '4', 'Android', '5000', '40');
INSERT INTO Mobile VALUES('00016', 'oui', '256', '6', 'iOS', '2815', '12');
INSERT INTO Mobile VALUES('00017', 'non', '128', '6', 'Android', '4500', '12');
INSERT INTO Mobile VALUES('00018', 'oui', '256', '12', 'Android', '4500', '12');
INSERT INTO Mobile VALUES('00019', 'non', '64', '3', 'iOS', '1821', '7');
INSERT INTO Mobile VALUES('00020', 'non', '8', '1', 'Android', '1300', '5');

DROP TABLE IF EXISTS stock;

CREATE TABLE stock
	(refarticle TEXT NOT NULL,
	qte INTEGER NOT NULL,
	refvendeur TEXT NOT NULL);

INSERT INTO stock VALUES('00001', 10, 'PABX');
INSERT INTO stock VALUES('00001', 31, 'PABX');
INSERT INTO stock VALUES('00002', 25, 'PABX');
INSERT INTO stock VALUES('00002', 2, 'PABX');
INSERT INTO stock VALUES('00003', 8, 'PABX');
INSERT INTO stock VALUES('00003', 4, 'PABX');
INSERT INTO stock VALUES('00004', 9, 'PABX');
INSERT INTO stock VALUES('00005', 2, 'PABX');
INSERT INTO stock VALUES('00006', 3, 'PABX');
INSERT INTO stock VALUES('00007', 12, 'Fixe');
INSERT INTO stock VALUES('00007', 5, 'Fixe');
INSERT INTO stock VALUES('00008', 1, 'Fixe');
INSERT INTO stock VALUES('00008', 32, 'Fixe');
INSERT INTO stock VALUES('00009', 45, 'Fixe');
INSERT INTO stock VALUES('00010', 15, 'Fixe');
INSERT INTO stock VALUES('00010', 21, 'Fixe');
INSERT INTO stock VALUES('00011', 32, 'Fixe');
INSERT INTO stock VALUES('00012', 58, 'Fixe');
INSERT INTO stock VALUES('00012', 35, 'Fixe');
INSERT INTO stock VALUES('00013', 40, 'Fixe');
INSERT INTO stock VALUES('00013', 19, 'Fixe');
INSERT INTO stock VALUES('00014', 210, 'Mobile');
INSERT INTO stock VALUES('00015', 321, 'Mobile');
INSERT INTO stock VALUES('00016', 121, 'Mobile');
INSERT INTO stock VALUES('00017', 52, 'Mobile');
INSERT INTO stock VALUES('00018', 17, 'Mobile');
INSERT INTO stock VALUES('00019', 207, 'Mobile');
INSERT INTO stock VALUES('00020', 154, 'Mobile');

DROP TABLE IF EXISTS vendeur;

CREATE TABLE vendeur
	(nomvendeur TEXT NOT NULL,
	refvendeur TEXT PRIMARY KEY,
	addrvendeur TEXT NULL,
	mailvendeur TEXT NOT NULL);

INSERT INTO vendeur VALUES('Alcatel-Lucent', '001', 'Mont-de-Marsan', 'ventes@groupeal.com');
INSERT INTO vendeur VALUES('Apple', '002', 'Paris', 'contactus.fr@euro.apple.com');
INSERT INTO vendeur VALUES('ProCommunications', '003', 'Toulouse', 'conseil@procom.fr');
INSERT INTO vendeur VALUES('SmartPoche', '004', 'New York City', 'support.commercial@smartpoche.com');
INSERT INTO vendeur VALUES('MaisonDuFutur', '005', 'Lille', 'contact@mdufutur.com');

DROP TABLE IF EXISTS commande;

CREATE TABLE commande
	(refcommande TEXT PRIMARY KEY,
	refarticle TEXT NOT NULL,
	refclient TEXT NOT NULL,
	refvendeur TEXT NOT NULL,
	qte INTEGER NOT NULL,
	dateachat date NOT NULL,
	etat TEXT NOT NULL);

INSERT INTO commande VALUES('0000001', '00003', '000003', '001', 2, '02/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000002', '00008', '000005', '003', 12, '04/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000003', '00014', '000006', '004', 1, '05/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000004', '00006', '000001', '003', 3, '07/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000005', '00005', '000004', '003', 1, '12/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000006', '00011', '000005', '003', 4, '24/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000007', '00020', '000003', '004', 10, '27/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000008', '00016', '000006', '002', 1, '30/12/2020', 'Terminée');
INSERT INTO commande VALUES('0000009', '00010', '000003', '005', 1, '01/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000010', '00001', '000004', '001', 1, '02/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000011', '00020', '000003', '004', 1, '04/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000012', '00018', '000004', '004', 2, '06/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000013', '00020', '000006', '004', 1, '11/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000014', '00002', '000001', '001', 1, '20/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000015', '00017', '000003', '004', 3, '23/01/2021', 'Terminée');
INSERT INTO commande VALUES('0000016', '00012', '000003', '003', 2, '15/02/2021', 'Terminée');
INSERT INTO commande VALUES('0000017', '00003', '000004', '001', 1, '21/02/2021', 'Terminée');
INSERT INTO commande VALUES('0000018', '00014', '000001', '004', 1, '04/03/2021', 'Terminée');
INSERT INTO commande VALUES('0000019', '00005', '000006', '003', 1, '20/03/2021', 'Terminée');
INSERT INTO commande VALUES('0000020', '00004', '000003', '003', 2, '21/03/2021', 'Terminée');
INSERT INTO commande VALUES('0000021', '00014', '000005', '004', 2, '10/04/2021', 'Terminée');
INSERT INTO commande VALUES('0000022', '00015', '000001', '004', 1, '12/04/2021', 'Terminée');
INSERT INTO commande VALUES('0000023', '00003', '000005', '001', 1, '13/04/2021', 'Terminée');
INSERT INTO commande VALUES('0000024', '00008', '000001', '001', 5, '13/04/2021', 'Terminée');
INSERT INTO commande VALUES('0000025', '00009', '000005', '003', 3, '17/04/2021', 'Terminée');
INSERT INTO commande VALUES('0000026', '00016', '000004', '002', 1, '01/05/2021', 'Terminée');
INSERT INTO commande VALUES('0000027', '00007', '000004', '001', 20, '08/05/2021', 'Terminée');
INSERT INTO commande VALUES('0000028', '00020', '000001', '004', 1, '10/05/2021', 'Terminée');
INSERT INTO commande VALUES('0000029', '00017', '000001', '004', 1, '16/05/2021', 'Terminée');
INSERT INTO commande VALUES('0000030', '00006', '000003', '003', 1, '17/05/2021', 'En cours');
INSERT INTO commande VALUES('0000031', '00019', '000006', '002', 1, '22/05/2021', 'En cours');
INSERT INTO commande VALUES('0000032', '00013', '000003', '004', 1, '23/05/2021', 'Panier');

DROP TABLE IF EXISTS client;

CREATE TABLE client
	(nomclient TEXT NOT NULL,
	refclient TEXT PRIMARY KEY,
	mdpclient TEXT NOT NULL,
	addrClient TEXT NULL,
	mailClient TEXT NOT NULL);

INSERT INTO client VALUES('Guillaume', '000001', 'azerty', 'Mont-de-Marsan', 'guillaume@clemente.fr');
INSERT INTO client VALUES('Calixte', '000002', 'password', 'Villefranche de Rouergue', 'calixte.meunier14@gmail.com');
INSERT INTO client VALUES('Raoul', '000003', 'motdepasse', 'Trappes', 'cool.raoul@orange.fr');
INSERT INTO client VALUES('Marcel', '000004', 'enroute', 'Rochefort', 'marceladsl@gmail.com');
INSERT INTO client VALUES('René', '000005', '12345678', 'Gap', 'renelataupe@yahoo.fr');
INSERT INTO client VALUES('Danielle', '000006', '13audisport', 'Marseille', 'danielle-cpl@gmail.com');

END TRANSACTION;
