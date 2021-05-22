BEGIN TRANSACTION;
--! Ajouter les contraintres à la fin des tables
DROP TABLE IF EXISTS article;

CREATE TABLE article
	(nomarticle TEXT NOT NULL,
	refarticle TEXT NOT NULL,
	marque TEXT NOT NULL,
	prix INTEGER NOT NULL,
	categorie TEXT NOT NULL);

INSERT INTO article VALUES('articletest1', '0000001', 'MarqueTest', 1, 'pabx');
INSERT INTO article VALUES('articletest2', '0000002', 'MarqueTest', 2, 'fixe');
INSERT INTO article VALUES('articletest3', '0000003', 'Xiaomi', 200, 'mobile');

DROP TABLE IF EXISTS pabx;

CREATE TABLE pabx
	(refarticle TEXT NOT NULL,
	modulable TEXT NOT NULL,
	type TEXT NOT NULL,
	nblignes TEXT NOT NULL);

INSERT INTO pabx VALUES('0000001', 'non', 'Analogique', "4");

DROP TABLE IF EXISTS fixe;

CREATE TABLE fixe
	(refarticle TEXT NOT NULL,
	filaire TEXT NOT NULL,
	type TEXT NOT NULL,
	utilisation TEXT NOT NULL,
	touchefonction TEXT NOT NULL);

INSERT INTO fixe VALUES('0000002', 'oui', 'Numérique', 'personnel', 'non');

DROP TABLE IF EXISTS mobile;

CREATE TABLE mobile
	(refarticle TEXT NOT NULL,
	cinqg TEXT NOT NULL,
	stockage TEXT NOT NULL,
	ram TEXT NOT NULL,
	os TEXT NOT NULL,
	batterie TEXT NOT NULL,
	photo TEXT NOT NULL);

INSERT INTO mobile VALUES('0000003', 'non', '64', '4', 'Android', '5000', '16');

DROP TABLE IF EXISTS stock;

CREATE TABLE stock
	(refarticle TEXT NOT NULL,
	qte INTEGER NOT NULL,
	refvendeur TEXT NOT NULL);

INSERT INTO stock VALUES('0000001', 0, '001');
INSERT INTO stock VALUES('0000002', 100, '001');
INSERT INTO stock VALUES('0000001', 10, '002');
INSERT INTO stock VALUES('0000003', 5, '003');

DROP TABLE IF EXISTS vendeur;

CREATE TABLE vendeur
	(nomvendeur TEXT NOT NULL,
	refvendeur TEXT NOT NULL,
	addrvendeur TEXT NULL,
	mailvendeur TEXT NOT NULL);

INSERT INTO vendeur VALUES('Vendeur1', '001', 'mdm', 'vendeur1@gmail.com');
INSERT INTO vendeur VALUES('Vendeur2', '002', NULL, 'vendeur2@yahoo.fr');
INSERT INTO vendeur VALUES('Vendeur3', '003', 'vdr', 'vendeur3@orange.net');

DROP TABLE IF EXISTS commande;

CREATE TABLE commande
	(refcommande TEXT NOT NULL,
	refarticle TEXT NOT NULL,
	refclient TEXT NOT NULL,
	refvendeur TEXT NOT NULL,
	qte INTEGER NOT NULL,
	terminee TEXT NOT NULL);

INSERT INTO commande VALUES('00001', '0000002', '000001', '001', 4, 'oui');
INSERT INTO commande VALUES('00002', '0000001', '000001', '003', 1, 'non');
INSERT INTO commande VALUES('00003', '0000003', '000002', '002', 2, 'oui');

DROP TABLE IF EXISTS client;

CREATE TABLE client
	(nomclient TEXT NOT NULL,
	refclient TEXT NOT NULL,
	mdpclient TEXT NOT NULL,
	addrClient TEXT NULL,
	mailClient TEXT NOT NULL);

INSERT INTO client VALUES('Guillaume', '000001', 'azerty', 'mdm', 'guillaume@clemente.fr');
INSERT INTO client VALUES('Calixte', '000002', 'password', 'vdr', 'calixte.meunier14@gmail.com');