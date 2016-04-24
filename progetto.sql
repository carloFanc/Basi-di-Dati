drop database PIATTAFORMA;
CREATE DATABASE PIATTAFORMA;
USE PIATTAFORMA;

/* -------------------------------------------------------------*/
/* Definizione delle tabelle SQL			        */
CREATE TABLE IF NOT EXISTS Punto_Noleggio(

	Nome VARCHAR(20) NOT NULL PRIMARY KEY,
	Sito_Web VARCHAR(20),
	Email VARCHAR(40),
	Telefono VARCHAR(20),
	Indirizzo VARCHAR(40),
	Latitudine FLOAT(10,6),
	Longitudine FLOAT(10,6) 
	) ENGINE=INNODB;
	
CREATE TABLE IF NOT EXISTS Veicolo_elettrico( 

	Targa VARCHAR(20) NOT NULL PRIMARY KEY,
	Punto_Noleggio VARCHAR(20) NOT NULL,
	Tipologia ENUM('Auto','Scooter') NOT NULL,
	Nome_Modello VARCHAR(40),
	Colore VARCHAR(40),
	Costo_orario INT,
	Cilindrata INT,
	Autonomia_km INT,
	Max_Passeggeri INT,
	Chilometraggio_Attuale INT,
	Foto BLOB,
	FOREIGN KEY (Punto_Noleggio) REFERENCES Punto_Noleggio(Nome) 
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Postazione_Prelievo(

	Indirizzo VARCHAR(40) NOT NULL PRIMARY KEY,
	Numero_Bici_Totale INT,
	Numero_Bici_Disponibili INT,
	Latitudine FLOAT(10,6),
	Longitudine FLOAT(10,6) 
	) ENGINE=INNODB;
	
CREATE TABLE IF NOT EXISTS Bici(

	Id INT NOT NULL PRIMARY KEY,
	Postazione_Prelievo VARCHAR(20),
	Marca VARCHAR(20),
	Colore VARCHAR(20),
	Anno_Acquisizione INT,
	FOREIGN KEY (Postazione_Prelievo) REFERENCES Postazione_Prelievo(Indirizzo) 
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Pista_Ciclabile(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Chilometri INT,
	Pendenza_Media DECIMAL(6,4),
	Latitudine FLOAT(10,6),
	Longitudine FLOAT(10,6) 
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Utente(

	Email VARCHAR(20) NOT NULL PRIMARY KEY,
	Nome VARCHAR(20) NOT NULL,
	Cognome VARCHAR(20) NOT NULL,
	password VARCHAR(20) NOT NULL,
	Tipologia ENUM('Amministratore','Premium','Semplice') DEFAULT 'Semplice',
	Data_Nascita DATE,
	Luogo_Nascita VARCHAR(20),
	Indirizzo_Residenza VARCHAR(40),
	Telefono VARCHAR(20)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Messaggio_Personale( 

	Id_Messaggio INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Email_Mittente VARCHAR(20) NOT NULL,
	Email_Destinatario VARCHAR(20) NOT NULL,
	Testo_Messaggio VARCHAR(500) NOT NULL,
	DataInvio DATETIME,
	FOREIGN KEY (Email_Mittente) REFERENCES Utente(Email),
	FOREIGN KEY (Email_Destinatario) REFERENCES Utente(Email)
	) ENGINE=INNODB;
	
CREATE TABLE IF NOT EXISTS Messaggio_Globale(

	Id_Messaggio INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Email_Mittente VARCHAR(20),
	Testo_Messaggio VARCHAR(500) NOT NULL,
	DataInvio DATETIME,
	FOREIGN KEY (Email_Mittente) REFERENCES Utente(Email)
	) ENGINE=INNODB;
	
CREATE TABLE IF NOT EXISTS Prenotazione_Veicolo(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	Veicolo VARCHAR(20) NOT NULL, 
	Prezzo_Prenotazione INT,
	Data_Inizio DATETIME, 
	Data_Fine DATETIME,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email),
	FOREIGN KEY (Veicolo) REFERENCES Veicolo_elettrico(Targa)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Prenotazione_Bici(
	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	IdBici INT NOT NULL,
	Data_Inizio DATETIME, 
	Data_Fine DATETIME,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email),
	FOREIGN KEY (IdBici) REFERENCES Bici(Id)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS ForumPost(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	Titolo VARCHAR(40),
	Testo_Messaggio VARCHAR(500),
	Data_Inserimento DATETIME,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	) ENGINE=INNODB;
	
CREATE TABLE IF NOT EXISTS Segnalazione(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Pista_Ciclabile INT NOT NULL,
	EmailUtente VARCHAR(20) NOT NULL,
	Titolo VARCHAR(20),
	Testo_Messaggio VARCHAR(500),
	Data_Inserimento DATETIME,
	/*Foto BLOB,*/
	FOREIGN KEY (Pista_Ciclabile) REFERENCES Pista_Ciclabile(Id),
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Colonnina_Elettrica(

	Indirizzo VARCHAR(40) NOT NULL PRIMARY KEY,
	Ente_Fornitore VARCHAR(20),
	Max_KWH INT,
	Data_Inserimento DATE,
	Latitudine FLOAT(10,6),
	Longitudine FLOAT(10,6)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Prenotazione_Colonnina(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	Indirizzo VARCHAR(20) NOT NULL,
	Slot_Inizio INT, 
	Slot_Fine INT,
	Data_pren DATE,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email),
	FOREIGN KEY (Indirizzo) REFERENCES Colonnina_Elettrica(Indirizzo)
	) ENGINE=INNODB;

	
/* -------------------------------------------------------------*/
/* Tabella per il debugging dei TRIGGER		        */
CREATE TABLE ErrorMessages (
  id INT(11) NOT NULL AUTO_INCREMENT,
  Message VARCHAR(30) DEFAULT NULL,
  Email VARCHAR(30),
  time TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)ENGINE=INNODB;	








/* -------------------------------------------------------------*/
/* --------------------Definizione TRIGGER--------------------- */

/*Controllo che la prenotazione sia fatta solo da utenti premium*/
DELIMITER * 
CREATE TRIGGER controlloInserimentoSegnalazione BEFORE INSERT ON Segnalazione
     FOR EACH ROW 
     BEGIN
     DECLARE premium_status VARCHAR(20);
     SET premium_status = (SELECT Tipologia FROM Utente WHERE Email = NEW.EmailUtente);
     IF (STRCMP(premium_status,'Premium')not like 0)
     THEN
     SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Vincolo violato: non sei un utente premium';
     END IF; 
     END
*
DELIMITER ;

/*Controllo che la prenotazione Colonnina sia fatta solo da utenti premium*/
DELIMITER ^ 
CREATE TRIGGER controlloPrenotazioneColonnina BEFORE INSERT ON Prenotazione_Colonnina
     FOR EACH ROW 
     BEGIN
     DECLARE premium_status VARCHAR(20);
     SET premium_status = (SELECT Tipologia FROM Utente WHERE Email = NEW.EmailUtente);
     IF (STRCMP(premium_status,'Premium')not like 0)
     THEN
     SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Vincolo violato: non sei un utente premium';
     END IF; 
     END
^
DELIMITER ;

/*Inserisco messaggio personale agli utenti che hanno prenotazioni di bici attive*/

DELIMITER ^
CREATE TRIGGER InserimentoMSGUtenticonPrenotazioni AFTER INSERT ON Segnalazione
FOR EACH ROW
BEGIN 
	DECLARE email_dest VARCHAR(20);	
	DECLARE rowcount INT;
	CALL UtentiConPrenotazioniBici(); 
	SET @rowcount = (SELECT COUNT(*) FROM foo);
	INSERT INTO ErrorMessages(Message) VALUES (@rowcount);
 		WHILE (@rowcount > 0)  DO
 			SET @email_dest = (SELECT Email FROM foo WHERE Id = @rowcount);
 			INSERT INTO Messaggio_Personale(Email_Mittente,Email_Destinatario,Testo_Messaggio,DataInvio)  VALUES (NEW.EmailUtente,@email_dest,NEW.Testo_Messaggio, NEW.Data_Inserimento);
 			SET @rowcount = @rowcount -1;
 		END WHILE;
END
^
DELIMITER ;
 

/*Controllo che la creazione dei post sia fatta solo da utenti amministratori*/
DELIMITER * 
CREATE TRIGGER controlloInserimentoAmministratore BEFORE INSERT ON ForumPost
     FOR EACH ROW 
     BEGIN
     DECLARE admin_status VARCHAR(20);
     SET admin_status = (SELECT Tipologia FROM Utente WHERE Email = NEW.EmailUtente);
     IF (STRCMP(admin_status,'Amministratore')not like 0)
     THEN
     SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Vincolo violato: non sei un utente amministratore';
     END IF; 
     END
*
DELIMITER ;

/*Inserisco messaggio inbox utenti dopo inserimento forum post*/
DELIMITER * 
CREATE TRIGGER InserimentoMessaggioInbox AFTER INSERT ON ForumPost
     FOR EACH ROW 
     BEGIN
     DECLARE testo VARCHAR(500);
     DECLARE dat DATETIME;
     DECLARE email VARCHAR(20);
     SET @testo = 'Nuova news inserita nel forum '; 
     SET @dat = NEW.Data_Inserimento;
     SET @email = NEW.EmailUtente;
	  INSERT INTO Messaggio_Globale(Email_Mittente,Testo_Messaggio,DataInvio) VALUES (@email,@testo,@dat);
     END
*
DELIMITER ;


/*Controllo che la prenotazione non superi le 12 ore*/
DELIMITER *  
CREATE TRIGGER controlloPrenotazioneBici BEFORE INSERT ON Prenotazione_Bici
     FOR EACH ROW 
     BEGIN
     DECLARE prov datetime;
     SET prov = NEW.Data_Inizio + INTERVAL 12 HOUR;
     IF (NEW.Data_Fine > prov)
     THEN
     SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Vincolo violato: non si puo prenotare per piu di 12 ore';
     END IF; 
     END
*
DELIMITER ;

/*Controllo che la prenotazione non sia già effettuata da qualcun'altro*/
DELIMITER * 
CREATE TRIGGER checkPrenotazioneBici BEFORE INSERT ON Prenotazione_Bici
     FOR EACH ROW   FOLLOWS  controlloPrenotazioneBici
     BEGIN
	  CALL DatePrenotazioniBici(NEW.IdBici);
     SET @righecount = (SELECT COUNT(Id) FROM lol);
  
    WHILE (@righecount > 0)  DO
       SET @dataInizio = (SELECT Data_Inizio FROM lol WHERE Id= @righecount);
         SET @dataFine = (SELECT Data_Fine FROM lol WHERE Id= @righecount);
        IF (( NEW.Data_Inizio BETWEEN @dataInizio AND @dataFine) OR (NEW.Data_Fine BETWEEN @dataInizio AND @dataFine))
           THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Vincolo violato: non prenotabile';
        END IF; 
     SET @righecount = @righecount -1;
 	  END WHILE;
     END
*
DELIMITER ; 

/*Controllo che la prenotazione non sia già effettuata da qualcun'altro*/
DELIMITER * 
CREATE TRIGGER checkPrenotazioneVeicoli BEFORE INSERT ON Prenotazione_Veicolo
     FOR EACH ROW  
     BEGIN
     CALL DatePrenotazioniVeicoli(NEW.Veicolo);
     SET @righecount = (SELECT COUNT(Id) FROM lol2);
  
    WHILE (@righecount > 0)  DO
       SET @dataInizio = (SELECT Data_Inizio FROM lol2 WHERE Id= @righecount);
         SET @dataFine = (SELECT Data_Fine FROM lol2 WHERE Id= @righecount);
        IF (( NEW.Data_Inizio BETWEEN @dataInizio AND @dataFine) OR (NEW.Data_Fine BETWEEN @dataInizio AND @dataFine))
           THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Vincolo violato: non prenotabile';
        END IF; 
     SET @righecount = @righecount -1;
 	  END WHILE;
     END
*
DELIMITER ;

/*Controllo che la prenotazione non sia già effettuata da qualcun'altro*/
DELIMITER * 
CREATE TRIGGER checkPrenotazioneColonnine BEFORE INSERT ON Prenotazione_Colonnina
     FOR EACH ROW  
     BEGIN
     CALL SlotPrenotazioniColonnine(NEW.Data_pren);
     SET @righecount = (SELECT COUNT(Id) FROM lol3);
    WHILE (@righecount > 0)  DO
       SET @slotInizio = (SELECT Slot_Inizio FROM lol3 WHERE Id= @righecount);
         SET @slotFine = (SELECT Slot_Fine FROM lol3 WHERE Id= @righecount);
        IF (( NEW.Slot_Inizio BETWEEN @slotInizio AND @slotFine) OR (NEW.Slot_Fine BETWEEN @slotInizio AND @slotFine))
           THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Vincolo violato: slot occupati';
        END IF; 
     SET @righecount = @righecount -1;
 	  END WHILE;
     END
*
DELIMITER ;



 /* Aggiornamento tipo Utente*/
DELIMITER $
CREATE TRIGGER AggiornaTipoUtente1 AFTER INSERT ON Prenotazione_Bici
     FOR EACH ROW 
     BEGIN  
     DECLARE num_prenotazioni_bici INT;
     DECLARE num_prenotazioni_veicoli INT;
     SET num_prenotazioni_bici = (SELECT COUNT(*) FROM Prenotazione_Bici WHERE EmailUtente = NEW.EmailUtente);
     SET num_prenotazioni_veicoli = (SELECT COUNT(*) FROM Prenotazione_Veicolo WHERE EmailUtente = NEW.EmailUtente);
	  IF( num_prenotazioni_bici+num_prenotazioni_veicoli >= 30)
     THEN
       UPDATE Utente SET Tipologia='Premium' WHERE Email = NEW.EmailUtente;
       END IF;
     END;
$
DELIMITER ;

/* Aggiornamento tipo Utente*/
DELIMITER $
CREATE TRIGGER AggiornaTipoUtente2 AFTER INSERT ON Prenotazione_Veicolo
     FOR EACH ROW 
     BEGIN  
     DECLARE num_prenotazioni_bici INT;
     DECLARE num_prenotazioni_veicoli INT;
     SET num_prenotazioni_bici = (SELECT COUNT(*) FROM Prenotazione_Bici WHERE EmailUtente = NEW.EmailUtente);
     SET num_prenotazioni_veicoli = (SELECT COUNT(*) FROM Prenotazione_Veicolo WHERE EmailUtente = NEW.EmailUtente);
	  IF( num_prenotazioni_bici+num_prenotazioni_veicoli >= 30)
     THEN
       UPDATE Utente SET Tipologia='Premium' WHERE Email = NEW.EmailUtente;
       END IF;
     END;
$
DELIMITER ;













/* -------------------------------------------------------------*/
/* ---------------------STORED PROCEDURES-----------------------*/

DELIMITER ^
CREATE PROCEDURE VisualizzaPostazioni()
BEGIN
SELECT Indirizzo,Numero_Bici_Disponibili FROM Postazione_Prelievo;
END;
^
DELIMITER ;

DELIMITER ^
CREATE PROCEDURE VisualizzaPisteCiclabili()
BEGIN
SELECT Id,Chilometri,Pendenza_Media,Latitudine,Longitudine FROM Pista_Ciclabile;
END;
^
DELIMITER ;

/*-------------------------------------------------------------*/
/*-----view temporanea per il trigger checkPrenotazioneBici----*/
DELIMITER ^
CREATE PROCEDURE DatePrenotazioniBici(IN Id INT)
BEGIN
SET @n = 0;
DROP TEMPORARY TABLE IF EXISTS lol;
CREATE TEMPORARY TABLE lol SELECT  @n := @n + 1 AS Id,Data_Inizio,Data_Fine
                           FROM Prenotazione_Bici ,  (SELECT @n := 0) m 
                           WHERE IdBici = Id;
END;
^

/*-------------------------------------------------------------*/
/*-----view temporanea per il trigger checkPrenotazioneVeicoli----*/
DELIMITER ^
CREATE PROCEDURE DatePrenotazioniVeicoli(IN TargaVeicolo VARCHAR(30))
BEGIN
SET @n = 0;
DROP TEMPORARY TABLE IF EXISTS lol2;
CREATE TEMPORARY TABLE lol2 SELECT  @n := @n + 1 AS Id,Data_Inizio,Data_Fine
                           FROM Prenotazione_Veicolo ,  (SELECT @n := 0) m 
                           WHERE Veicolo  = TargaVeicolo;
END;
^ 

/*-------------------------------------------------------------*/
/*-----view temporanea per il trigger checkPrenotazioneColonnine----*/
DELIMITER ^
CREATE PROCEDURE SlotPrenotazioniColonnine(IN datap DATE)
BEGIN
SET @n = 0;
DROP TEMPORARY TABLE IF EXISTS lol3;
CREATE TEMPORARY TABLE lol3 SELECT  @n := @n + 1 AS Id,Slot_Inizio,Slot_Fine
                           FROM Prenotazione_Colonnina ,  (SELECT @n := 0) m 
                           WHERE Data_pren = datap;
END;
^

/*---------------------------------------------------------------------------*/
/*-----view temporanea per il trigger InserimentoMSGUtenticonPrenotazioni----*/
DELIMITER ^
CREATE PROCEDURE UtentiConPrenotazioniBici() 
BEGIN
SET @n = 0;
DROP TEMPORARY TABLE IF EXISTS foo;
CREATE TEMPORARY TABLE foo SELECT   @n := @n + 1 AS Id , Email
                           FROM Utente,Prenotazione_Bici,  (SELECT @n := 0) m
                           WHERE ((Utente.Email=Prenotazione_Bici.EmailUtente) AND (Prenotazione_Bici.Data_Inizio > now()));
END;
^
/*-------------------------------------------------------*/
/*------------- visualizza PUNTI NOLEGGIO----------------*/

DELIMITER ^
CREATE PROCEDURE VisualizzaPuntiNoleggio()
visu:BEGIN
CREATE OR REPLACE VIEW ScooterinNoleggioParziale AS
    						 SELECT Punto_Noleggio.Nome,count(*)  as Numero_Scooter
    						 FROM Veicolo_elettrico,Punto_Noleggio
    						 WHERE Punto_Noleggio.Nome = Veicolo_elettrico.Punto_Noleggio AND Veicolo_elettrico.Tipologia ='Scooter'
    						 GROUP BY Punto_Noleggio.Nome;
    						 
    						 
    						 
CREATE OR REPLACE VIEW AutoinNoleggioParziale AS
    						 SELECT Punto_Noleggio.Nome,count(*)  as Numero_Auto
    						 FROM Veicolo_elettrico,Punto_Noleggio
    						 WHERE Punto_Noleggio.Nome = Veicolo_elettrico.Punto_Noleggio AND Veicolo_elettrico.Tipologia ='Auto'
    						 GROUP BY Punto_Noleggio.Nome;
    						 
CREATE OR REPLACE VIEW ScooterInNoleggio AS
							SELECT Punto_Noleggio.Nome, ScooterinNoleggioParziale.Numero_Scooter
							FROM Punto_Noleggio
							LEFT OUTER JOIN ScooterinNoleggioParziale ON Punto_Noleggio.Nome = ScooterinNoleggioParziale.Nome;

CREATE OR REPLACE VIEW AutoInNoleggio AS
							SELECT Punto_Noleggio.Nome,AutoinNoleggioParziale.Numero_Auto
							FROM Punto_Noleggio
							LEFT OUTER JOIN AutoinNoleggioParziale ON Punto_Noleggio.Nome = AutoinNoleggioParziale.Nome;

SELECT ScooterInNoleggio.Nome, IFNULL(ScooterInNoleggio.Numero_Scooter,0) AS Numero_Scooter, IFNULL(AutoInNoleggio.Numero_Auto,0) AS Numero_Auto
FROM ScooterInNoleggio
INNER JOIN AutoInNoleggio
ON ScooterInNoleggio.Nome=AutoInNoleggio.Nome; 
END;
^
DELIMITER ;
/*---------------------------------------------------------------------*/
/*------------- inserimento Prenotazioni BICI e VEICOLI----------------*/
DELIMITER ^
CREATE PROCEDURE PrenotazioneBici(IN EmailUtente VARCHAR(50),IN IdBici INT,IN Data_Inizio DATETIME,IN Data_Fine DATETIME)
visu:BEGIN
		INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES (EmailUtente,IdBici,Data_Inizio,Data_Fine);

END;
^
DELIMITER ;

DELIMITER ^ 
CREATE PROCEDURE PrenotazioneVeicolo(IN EmailUtente VARCHAR(50),IN TargaVeicolo VARCHAR(50),IN Data_Inizio DATETIME,IN Data_Fine DATETIME)
visu:BEGIN
 DECLARE prezzo INT;
 DECLARE datadiff INT;
 SET prezzo = ((SELECT Costo_orario FROM Veicolo_elettrico WHERE Targa = TargaVeicolo))*(SELECT HOUR(TIMEDIFF(Data_Fine, Data_Inizio)));
 INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Data_Inizio,Data_Fine,Prezzo_Prenotazione) VALUES (EmailUtente,TargaVeicolo,Data_Inizio,Data_Fine,prezzo);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- VISUALIZZAPRENOTAZIONINCORSO/PASSATE----------------*/
DELIMITER ^
CREATE PROCEDURE VisualizzaPrenotazioninCorso(IN Email VARCHAR(50))
visu:BEGIN
SELECT * FROM Prenotazione_Bici WHERE ((EmailUtente = Email) AND (Data_Inizio > NOW())) ;
SELECT * FROM Prenotazione_Veicolo WHERE ((EmailUtente = Email) AND (Data_Inizio > NOW())) ;
SELECT * FROM Prenotazione_Colonnina WHERE ((EmailUtente = Email) AND (Data_pren > NOW())) ;
END;
^
DELIMITER ;

DELIMITER ^
CREATE PROCEDURE VisualizzaPrenotazioniPassate(IN Email VARCHAR(50))
visu:BEGIN
SELECT * FROM Prenotazione_Bici WHERE ((EmailUtente = Email) AND (Data_Inizio < NOW())) ;
SELECT * FROM Prenotazione_Veicolo WHERE ((EmailUtente = Email) AND (Data_Inizio < NOW())) ;
SELECT * FROM Prenotazione_Colonnina WHERE ((EmailUtente = Email) AND (Data_pren < NOW())) ;
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- VISUALIZZAPOSTFORUM----------------*/
DELIMITER ^
CREATE PROCEDURE VisualizzaForum()
visu:BEGIN
SELECT * FROM ForumPost;
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- VISUALIZZAINBOX----------------*/
DELIMITER ^
CREATE PROCEDURE VisualizzaINBOX(IN Email VARCHAR(50))
visu:BEGIN
SELECT Email_Mittente,Testo_Messaggio,DataInvio FROM Messaggio_Personale WHERE (Email_Destinatario = Email)
UNION
SELECT Email_Mittente,Testo_Messaggio,DataInvio FROM Messaggio_Globale;
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- VISUALIZZACOLONNINE----------------*/

DELIMITER ^
CREATE PROCEDURE VisualizzaColonnine()
visu:BEGIN
SELECT * FROM Colonnina_Elettrica;

END;
^
DELIMITER ;

/*------------------------------------------------------------------*/
/*------------- Inserimento SEGNALAZIONE----------------*/

DELIMITER ^
CREATE PROCEDURE InserimentoSegnalazione(IN Pista_Ciclabile INT,IN EmailUtente VARCHAR(50),IN Titolo VARCHAR(50),IN Testo_Messaggio VARCHAR(500)/*,IN Foto BLOB*/)
visu:BEGIN
DECLARE timenow DATETIME;
SET timenow = NOW();
INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio/*,Foto*/,Data_Inserimento) VALUES (Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio/*,Foto*/,timenow);
END;
^
DELIMITER ;
/*----------------------------------------------------------------*/
/*------------- inserimento PRENOTAZIONE COLONNINA----------------*/
DELIMITER ^
CREATE PROCEDURE PrenotazioneColonnina(IN EmailUtente VARCHAR(50),IN Indirizzo VARCHAR(50),IN Slot_Inizio INT,IN Slot_Fine INT,IN Data_pren DATE)
visu:BEGIN
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES (EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren);
END;
^
DELIMITER ;

/*----------------------------------------------------------------*/
/*--------------------------inserimento POST---------------------*/
DELIMITER ^
CREATE PROCEDURE InserimentoPost(IN EmailUtente VARCHAR(50),IN Titolo VARCHAR(50),IN Testo_Messaggio VARCHAR(50))
visu:BEGIN
DECLARE timenow DATETIME;
SET timenow = NOW();
INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES (EmailUtente,Titolo,Testo_Messaggio,timenow);
END;
^
DELIMITER ;

/*----------------------------------------------------------------*/
/*------------- ELIMINAZIONE PRENOTAZIONI passate----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPrenotazioni()
visu:BEGIN
DELETE FROM Prenotazione_Bici WHERE (Data_Inizio < NOW());
DELETE FROM Prenotazione_Veicolo WHERE (Data_Inizio < NOW());
DELETE FROM Prenotazione_Colonnina WHERE (Data_pren < NOW());
END;
^
DELIMITER ;

/*--------------------------------------------------------------------------*/
/*------------- CLASSIFICA UTENTI ORDER BY Numero PRENOTAZIONI BICI----------------*/
DELIMITER ^
CREATE PROCEDURE ClassificaPrenBici()
visu:BEGIN
DROP TABLE IF EXISTS Pren2;
CREATE TEMPORARY TABLE Pren2
SELECT EmailUtente,COUNT(*) AS Numero_Prenotazioni_Bici FROM Prenotazione_Bici GROUP BY EmailUtente;

SELECT * from Pren2 ORDER BY Numero_Prenotazioni_Bici DESC;
END;
^
DELIMITER ;

/*--------------------------------------------------------------------------*/
/*------------- CLASSIFICA UTENTI ORDER BY Numero PRENOTAZIONI Veicoli----------------*/
DELIMITER ^
CREATE PROCEDURE ClassificaPrenVeicoli()
visu:BEGIN
DROP TABLE IF EXISTS Pren;
CREATE TEMPORARY TABLE Pren 
SELECT EmailUtente,COUNT(*) AS Numero_Prenotazioni_Veicoli FROM Prenotazione_Veicolo GROUP BY EmailUtente;

SELECT * from Pren ORDER BY Numero_Prenotazioni_Veicoli DESC;
END;

^
DELIMITER ;

/*--------------------------------------------------------------------------*/
/*------------------CLASSIFICA utilizzo medio COLONNINE---------------------*/
DELIMITER ^
CREATE PROCEDURE ClassificaColonnine()
visu:BEGIN
DROP VIEW IF EXISTS colonnineslot;
CREATE VIEW colonnineslot AS
    						 SELECT Indirizzo,Slot_Fine-Slot_Inizio AS Slot_Occupati
    						 FROM Prenotazione_Colonnina
							 GROUP BY Indirizzo;						                              
select * from colonnineslot;
END;
^
DELIMITER ;

/*CREATE TEMPORARY TABLE Appoggio  
SELECT Indirizzo, 
								
			SET @num = SELECT COUNT(*) FROM colonnineslot;
								
	 WHILE (@num>0) DO*/
	
							
-- CREATE VIEW AutoinNoleggioParziale AS
-- SELECT Punto_Noleggio.Nome,count(*)  as Numero_Auto
-- FROM Veicolo_elettrico,Punto_Noleggio
-- WHERE Punto_Noleggio.Nome = Veicolo_elettrico.Punto_Noleggio AND Veicolo_elettrico.Tipologia ='Auto'
-- GROUP BY Punto_Noleggio.Nome;
-- 
-- CREATE VIEW ScooterInNoleggio AS
-- SELECT Punto_Noleggio.Nome, ScooterinNoleggioParziale.Numero_Scooter
-- FROM Punto_Noleggio
-- LEFT OUTER JOIN ScooterinNoleggioParziale ON Punto_Noleggio.Nome = ScooterinNoleggioParziale.Nome;
-- 
-- CREATE VIEW AutoInNoleggio AS
-- SELECT Punto_Noleggio.Nome,AutoinNoleggioParziale.Numero_Auto
-- FROM Punto_Noleggio
-- LEFT OUTER JOIN AutoinNoleggioParziale ON Punto_Noleggio.Nome = AutoinNoleggioParziale.Nome;
-- 
-- 
-- SELECT ScooterInNoleggio.Nome, IFNULL(ScooterInNoleggio.Numero_Scooter,0) AS Numero_Scooter, IFNULL(AutoInNoleggio.Numero_Auto,0) AS Numero_Auto
-- FROM ScooterInNoleggio
-- INNER JOIN AutoInNoleggio
-- ON ScooterInNoleggio.Nome=AutoInNoleggio.Nome; 






/*ATE TABLE IF NOT EXISTS Colonnina_Elettrica(

	Indirizzo VARCHAR(40) NOT NULL PRIMARY KEY,
	Ente_Fornitore VARCHAR(20),
	Max_KWH INT,
	Data_Inserimento DATE,
	Latitudine FLOAT(10,6),
	Longitudine FLOAT(10,6)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Prenotazione_Colonnina(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	Indirizzo VARCHAR(20) NOT NULL,
	Slot_Inizio INT, 
	Slot_Fine INT,
	Data_pren DATE,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email),
	FOREIGN KEY (Indirizzo) REFERENCES Colonnina_Elettrica(Indirizzo)
	) ENGINE=*/

















/* -------------------------------------------------------------*/
/* --------------Inserimento dati nelle tabelle-----------------*/

INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES ('Noleggio1','www.lollo.it','lollo@gmail.com',0576123123,'via prova 1', 44.493647, 11.359051);
INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES ('Noleggio2','www.proviamoci.it','xalonf@gmail.com',123860349,'via bulld 111', 44.498918, 11.352963);
INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES ('Noleggio3','www.noleggio3.it','noleggio3@gmail.com',0578564512,'via cazzarol 13',44.498037, 11.339796);


INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('123ABC456','Noleggio1','Auto','TT','Grigio',20,213,2000,4,120,NULL);
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('4BCG554KS','Noleggio1','Scooter','Vespa','Rosso',5,20,500,NULL,NULL,NULL);
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('LAL123TFG','Noleggio2','Auto','Maggiolino','Azzurro',12,100,1000,4,120,NULL);



INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via santo stefano 3',20,14,44.495603, 11.353665);
INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via prepappo 6',1000,571,44.500912,11.337266);
INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via lollone',199,571,44.498241, 11.327787);


INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('01','via santo stefano 3','X1','Blu','2014');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('25','via prepappo 6','LOLW','Rossa','1990');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('123','via lollone','AZ5','Azzurra','1934');


INSERT INTO Pista_Ciclabile(Chilometri,Pendenza_Media,Latitudine,Longitudine) VALUES (12,30.12,44.504853,11.345467);

INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono) VALUES ('carlo@gmail.com','carlo','Paoluci','password','Semplice','1989-12-12','Monteparco','via santoparco',331231231);
INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono) VALUES ('pippo@gmail.com','Pippo','Ponti','password123','Premium','1993-05-11','Bononia','via ciaociao 3',323333222);
INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono) VALUES ('admin@gmail.com','Zeus','Dei','admin','Amministratore','1969-05-01','Olimpo','via degli dei 66',12345678);


INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('carlo@gmail.com','123ABC456',12,'2016-01-02 10:05:22','2016-01-02 12:05:22');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('pippo@gmail.com','LAL123TFG',200,'2016-01-02 12:05:12','2016-01-02 12:05:22');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('carlo@gmail.com','123ABC456',50,'2016-09-02 10:05:22','2016-10-02 12:05:22');	


	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('pippo@gmail.com','01','2016-03-12 02:05:22','2016-03-12 03:55:22');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('pippo@gmail.com','01','2016-03-12 04:05:22','2016-03-12 07:55:22');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('carlo@gmail.com','01','2016-04-18 16:05:22','2016-04-18 16:55:22');	


INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('admin@gmail.com','Provamsg','ciaociao','2016-12-24 03:44:22');	
INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('admin@gmail.com','Bona','chebellofunziona','2016-02-21 17:13:22');	

INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via panto cane 5','Enel',150,'2012-10-02',123,123);
INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via riproviamo 123','Hera',200,'2013-03-12',456,456);

INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('pippo@gmail.com','via panto cane 5',5,7,'2016-11-15');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('pippo@gmail.com','via riproviamo 123',3,4,'2016-04-01');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('pippo@gmail.com','via panto cane 5',3,4,'2016-08-15');


INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento/*,Foto*/) VALUES ('01','pippo@gmail.com','Segnalazioneprova','incidente','2015-11-12 13:49:02');
INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento/*Foto*/) VALUES ('01','pippo@gmail.com','Segnalazioneprova2','incidente','2016-04-18 16:17:02');

INSERT INTO Messaggio_Personale(Email_Mittente,Email_Destinatario,Testo_Messaggio,DataInvio) VALUES ('pippo@gmail.com','carlo@gmail.com','ciao ciao come vaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa?','2016-06-24 03:44:22');
