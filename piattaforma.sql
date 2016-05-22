drop database PIATTAFORMA;
CREATE DATABASE PIATTAFORMA;
USE PIATTAFORMA;

/* -------------------------------------------------------------*/
/* Definizione delle tabelle SQL			        */
CREATE TABLE IF NOT EXISTS Punto_Noleggio(

	Nome VARCHAR(40) NOT NULL PRIMARY KEY,
	Sito_Web VARCHAR(50),
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
	Foto VARCHAR(200),
	FOREIGN KEY (Punto_Noleggio) REFERENCES Punto_Noleggio(Nome) 
	ON DELETE CASCADE
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
	ON DELETE CASCADE
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Pista_Ciclabile(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Chilometri INT,
	Pendenza_Media DECIMAL(6,2),
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
	Telefono VARCHAR(20),
	Foto VARCHAR(200)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Messaggio( 

	Id_Messaggio INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Email_Mittente VARCHAR(20) NOT NULL,
	Titolo VARCHAR(100),
	Email_Destinatario VARCHAR(20) NOT NULL,
	Tipo ENUM('Personale','Globale'),
	Testo_Messaggio VARCHAR(500),
	DataInvio DATETIME,
	FOREIGN KEY (Email_Mittente) REFERENCES Utente(Email)
	ON DELETE CASCADE,
	FOREIGN KEY (Email_Destinatario) REFERENCES Utente(Email)
	ON DELETE CASCADE
	) ENGINE=INNODB;
	
	
CREATE TABLE IF NOT EXISTS Prenotazione_Veicolo(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	Veicolo VARCHAR(20) NOT NULL, 
	Prezzo_Prenotazione INT,
	Data_Inizio DATETIME, 
	Data_Fine DATETIME,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	ON DELETE CASCADE,
	FOREIGN KEY (Veicolo) REFERENCES Veicolo_elettrico(Targa)
	ON DELETE CASCADE
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Prenotazione_Bici(
	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	IdBici INT NOT NULL,
	Data_Inizio DATETIME, 
	Data_Fine DATETIME,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	ON DELETE CASCADE,
	FOREIGN KEY (IdBici) REFERENCES Bici(Id)
	ON DELETE CASCADE
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS ForumPost(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(50) NOT NULL,
	Titolo VARCHAR(100),
	Testo_Messaggio VARCHAR(500),
	Data_Inserimento DATETIME,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	ON DELETE CASCADE
	) ENGINE=INNODB;
	
CREATE TABLE IF NOT EXISTS Segnalazione(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Pista_Ciclabile INT NOT NULL,
	EmailUtente VARCHAR(50) NOT NULL,
	Titolo VARCHAR(100),
	Testo_Messaggio VARCHAR(500),
	Data_Inserimento DATETIME,
	FOREIGN KEY (Pista_Ciclabile) REFERENCES Pista_Ciclabile(Id)
	ON DELETE CASCADE,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	ON DELETE CASCADE
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Colonnina_Elettrica(

	Indirizzo VARCHAR(50) NOT NULL PRIMARY KEY,
	Ente_Fornitore VARCHAR(20),
	Max_KWH INT,
	Data_Inserimento DATE,
	Latitudine FLOAT(10,6),
	Longitudine FLOAT(10,6)
	) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Prenotazione_Colonnina(

	Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EmailUtente VARCHAR(20) NOT NULL,
	Indirizzo VARCHAR(50) NOT NULL,
	Slot_Inizio INT, 
	Slot_Fine INT,
	Data_pren DATE,
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
	ON DELETE CASCADE,
	FOREIGN KEY (Indirizzo) REFERENCES Colonnina_Elettrica(Indirizzo)
	ON DELETE CASCADE
	) ENGINE=INNODB;








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
 		WHILE (@rowcount > 0)  DO
 			SET @email_dest = (SELECT Email FROM foo WHERE Id = @rowcount);
 			INSERT INTO Messaggio(Email_Mittente,Titolo,Email_Destinatario,Tipo,Testo_Messaggio,DataInvio)  VALUES (NEW.EmailUtente,NEW.Titolo,@email_dest,'Personale',NEW.Testo_Messaggio, NEW.Data_Inserimento);
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
     SET @testo = 'Nuova news inserita nel forum'; 
     SET @dat = NEW.Data_Inserimento;
     SET @email = NEW.EmailUtente;
     SET @tit = NEW.Titolo;
	  INSERT INTO Messaggio(Email_Mittente,Titolo,Email_Destinatario,Tipo,Testo_Messaggio,DataInvio) VALUES (@email,@tit,'admin@gmail.com','Globale',@testo,@dat);
     END
*
DELIMITER ;
/*Elimino Messaggi Globali in inbox dopo che un admin ha tolto un messaggio nel forum*/
DELIMITER * 
CREATE TRIGGER AggiornaInbox AFTER DELETE ON ForumPost
     FOR EACH ROW 
     BEGIN
     DECLARE id INT;
     SET @id = Id; 
     DELETE FROM Messaggio WHERE (Id_Messaggio = @id);
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
/*trigger che segue il trigger precedente, entrambi effettuati prima di un inserimento in prenotazione bici*/
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
SELECT Indirizzo,Numero_Bici_Disponibili,Numero_Bici_Totale,Latitudine,Longitudine FROM Postazione_Prelievo;
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
CREATE TEMPORARY TABLE foo SELECT  DISTINCT @n := @n + 1 AS Id ,   Email
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
DELIMITER ^
CREATE PROCEDURE VisualizzaPrenotazioniTotaliPassate()
visu:BEGIN
SELECT * FROM Prenotazione_Bici WHERE (Data_Inizio < NOW());
SELECT * FROM Prenotazione_Veicolo WHERE (Data_Inizio < NOW());
SELECT * FROM Prenotazione_Colonnina WHERE (Data_pren < NOW());
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------------------------------------------------------------*/
DELIMITER ^
CREATE PROCEDURE VisualizzaPrenotazioniTotaliinCorso()
visu:BEGIN
SELECT * FROM Prenotazione_Bici WHERE (Data_Inizio > NOW()) ;
SELECT * FROM Prenotazione_Veicolo WHERE (Data_Inizio > NOW()) ;
SELECT * FROM Prenotazione_Colonnina WHERE (Data_pren > NOW()) ;
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- VISUALIZZAPOSTFORUM----------------*/
DELIMITER ^
CREATE PROCEDURE VisualizzaForum()
visu:BEGIN
SELECT * FROM ForumPost
ORDER BY Data_Inserimento DESC;
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- VISUALIZZAINBOX----------------*/
DELIMITER ^
CREATE PROCEDURE VisualizzaINBOX(IN Email VARCHAR(50))
visu:BEGIN
SELECT Id_Messaggio,Email_Mittente,Titolo,Email_Destinatario,Tipo,Testo_Messaggio,DataInvio 
FROM Messaggio WHERE (Email_Destinatario = Email) OR (Tipo = 'Globale')
ORDER BY DataInvio DESC;
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAMSGINBOX----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaINBOX(IN Id VARCHAR(50))
visu:BEGIN
DELETE FROM Messaggio WHERE (Id_Messaggio = Id);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPOST----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPOST(IN Id VARCHAR(50))
visu:BEGIN
DELETE FROM ForumPost WHERE (Id = Id);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAUTENTE----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaUTENTE(IN EmailInserito VARCHAR(50))
visu:BEGIN
DELETE FROM Utente WHERE (Email = EmailInserito);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAVEICOLO----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaVEICOLO(IN TargaInserita VARCHAR(50))
visu:BEGIN
DELETE FROM Veicolo_Elettrico WHERE (Targa = TargaInserita);
END;
^
DELIMITER ;EliminaBICI
/*------------------------------------------------------------------*/
/*------------- ELIMINABICI----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaBICI(IN IdInserito INT)
visu:BEGIN
DELETE FROM Bici WHERE (Id = IdInserito);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINACOLONNINA----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaCOLONNINA(IN Ind VARCHAR(40))
visu:BEGIN
DELETE FROM Colonnina_Elettrica WHERE (Indirizzo = Ind);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPOSTAZIONE----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPOSTAZIONE(IN Ind VARCHAR(40))
visu:BEGIN
DELETE FROM Postazione_Prelievo WHERE (Indirizzo = Ind);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPISTA----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPISTA(IN IdIns INT)
visu:BEGIN
DELETE FROM Pista_Ciclabile WHERE (Id = IdIns);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPUNTONOLEGGIO----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPUNTONOLEGGIO(IN NomeInserito VARCHAR(40))
visu:BEGIN
DELETE FROM Punto_Noleggio WHERE (Nome = NomeInserito);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPRENINCORSO BICI----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPrenInCorsoBici(IN IdInserito INT)
visu:BEGIN
DELETE FROM Prenotazione_Bici WHERE (Id= IdInserito);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPRENINCORSO VEICOLO----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPrenInCorsoVeicoli(IN IdInserito INT)
visu:BEGIN
DELETE FROM Prenotazione_Veicolo WHERE (Id=IdInserito);
END;
^
DELIMITER ;
/*------------------------------------------------------------------*/
/*------------- ELIMINAPRENINCORSO COLONNINA----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPrenInCorsoColonnina(IN IdInserito INT)
visu:BEGIN
DELETE FROM Prenotazione_Colonnina WHERE (Id=IdInserito);
END;
^
DELIMITER ;
/*----------------------------------------------------------------*/
/*------------- ELIMINAZIONE PRENOTAZIONI PASSATE(ADMIN)----------------*/
DELIMITER ^
CREATE PROCEDURE EliminaPrenotazioni()
visu:BEGIN
DELETE FROM Prenotazione_Bici WHERE (Data_Inizio < NOW());
DELETE FROM Prenotazione_Veicolo WHERE (Data_Inizio < NOW());
DELETE FROM Prenotazione_Colonnina WHERE (Data_pren < NOW());
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
CREATE PROCEDURE InserimentoSegnalazione(IN Pista_Ciclabile INT,IN EmailUtente VARCHAR(50),IN Titolo VARCHAR(100),IN Testo_Messaggio VARCHAR(500))
visu:BEGIN
DECLARE timenow DATETIME;
SET timenow = NOW();
INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES (Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,timenow);
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
CREATE PROCEDURE InserimentoPost(IN EmailUtente VARCHAR(50),IN Titolo VARCHAR(100),IN Testo_Messaggio VARCHAR(500))
visu:BEGIN
DECLARE timenow DATETIME;
SET timenow = NOW();
INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES (EmailUtente,Titolo,Testo_Messaggio,timenow);
END;
^
DELIMITER ;
/*----------------------------------------------------------------*/
/*--------------------------inserimento NUOVA BICI---------------------*/
DELIMITER ^ 
CREATE PROCEDURE InserimentonewBici(IN Id INT , IN Postazione VARCHAR(20),IN Marca VARCHAR(20),IN Colore VARCHAR(20),IN Anno INT)
visu:BEGIN
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES (Id,Postazione,Marca,Colore,Anno);
END;
^
DELIMITER ;
/*----------------------------------------------------------------*/
/*--------------------------inserimento NUOVO VEICOLO---------------------*/
DELIMITER ^ 
CREATE PROCEDURE InserimentonewVeicolo(IN Targa VARCHAR(20),IN PuntoNoleggio VARCHAR(20) , IN Tipologia VARCHAR(20),IN NomeModello VARCHAR(40),IN Colore VARCHAR(40),IN CostoH INT,IN Cilindrata INT,IN AutonomiaKm INT,IN MaxPasseggeri INT,IN Km_Attuale INT,IN Foto BLOB)
visu:BEGIN
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES (Targa,PuntoNoleggio,Tipologia,NomeModello,Colore,CostoH,Cilindrata,AutonomiaKm,MaxPasseggeri,Km_Attuale,Foto);
END;
^
DELIMITER ;

/*----------------------------------------------------------------*/
/*---------------inserimento NUOVA POSTAZIONE---------------------*/
DELIMITER ^ 
CREATE PROCEDURE InserimentonewPostazione(IN Indirizzo VARCHAR(40),IN Numero_Bici_Totale INT, IN Numero_Bici_Disponibili INT,IN Latitudine FLOAT(10,6),IN Longitudine FLOAT(10,6))
visu:BEGIN
INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES (Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine);
END;
^
DELIMITER ;

/*----------------------------------------------------------------*/
/*----------inserimento NUOVA PISTA CICLABILE---------------------*/
DELIMITER ^ 
CREATE PROCEDURE InserimentonewPistaCiclabile(IN Chilometri INT,IN Pendenza_Media DECIMAL(6,4), IN Latitudine FLOAT(10,6),IN Longitudine FLOAT(10,6))
visu:BEGIN
INSERT INTO Pista_Ciclabile(Chilometri,Pendenza_Media,Latitudine,Longitudine) VALUES (Chilometri,Pendenza_Media,Latitudine,Longitudine);
END;
^
DELIMITER ;

/*----------------------------------------------------------------*/
/*-----------inserimento NUOVO PUNTO NOLEGGIO---------------------*/
DELIMITER ^ 
CREATE PROCEDURE InserimentonewPuntoNoleggio(IN Nome VARCHAR(20),IN Sito_Web VARCHAR(50),IN Email VARCHAR(40),IN Telefono VARCHAR(20),IN Indirizzo VARCHAR(40), IN Latitudine FLOAT(10,6),IN Longitudine FLOAT(10,6))
visu:BEGIN
INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES (Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine);
END;
^
DELIMITER ;

/*----------------------------------------------------------------*/
/*-------inserimento NUOVA COLONNINA RICARICA---------------------*/
DELIMITER ^ 
CREATE PROCEDURE InserimentonewColonninaRicarica(IN Indirizzo VARCHAR(40),IN Ente_Fornitore VARCHAR(20),IN Max_KWH INT,IN Data_Inserimento DATE, IN Latitudine FLOAT(10,6),IN Longitudine FLOAT(10,6))
visu:BEGIN
INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES (Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine);
END;
^
DELIMITER ;










/*--------------------------------------------------------------------------*/
/*------ CLASSIFICA UTENTI ORDER BY Numero PRENOTAZIONI BICI----------------*/
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
/*--------- CLASSIFICA UTENTI ORDER BY Numero PRENOTAZIONI Veicoli----------*/
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
/*------------------------------------------*/
/*------------- LISTA UTENTI----------------*/
DELIMITER ^
CREATE PROCEDURE ListaUtenti()
visu:BEGIN
SELECT Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono 
FROM Utente;

END;
^
DELIMITER ;

/* -------------------------------------------------------------*/
/* --------------Inserimento dati nelle tabelle-----------------*/

INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono,Foto) VALUES ('utente1@gmail.com','Franco','Battelli','password','Semplice','1989-12-12','Monteparco','via santoparco',331231231,'utente1.jpg');
INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono,Foto) VALUES ('utente2@gmail.com','Pippo','Peppo','password','Premium','1993-05-11','Bononia','via ciaociao 6',323333222,'utente2.jpg');
INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono,Foto) VALUES ('utente3@gmail.com','ProvaNome','ProvaCognome','password','Premium','1992-11-11','Tralalla','via saluti 9',323333222,'utente3.jpg');
INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono,Foto) VALUES ('admin@gmail.com','Zeus','Dei','admin','Amministratore','1969-05-01','Olimpo','via degli dei 66',12345678,'zeus.jpg');


INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES ('Hertz','www.hertz.it','hertz@gmail.com',3441908587,'Via Boldrini, 4',44.491131, 11.335640);
INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES ('Car Italy','www.caritaly.it','caritaly@gmail.com',0515876770,'Via Milazzo 12/A', 44.486025, 11.347772);
INSERT INTO Punto_Noleggio(Nome,Sito_Web,Email,Telefono,Indirizzo,Latitudine,Longitudine) VALUES ('Avis','www.avisautonoleggio.it','avis@gmail.com',0516341632,'Via Nicolo Dall Arca 2',44.506678, 11.330749);


INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('123ABC456','Hertz','Auto','Renault Zoe','Grigio',25,88,125,4,12500,'zoe1.jpg');
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('4BCG554KS','Hertz','Scooter','Volt City60','Rosso',15,43,99,NULL,NULL,'City60-volt1.png');
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('LAL123TFG','Avis','Auto','Nissan Leaf','Rosso',30,99,199,5,15000,'nissan-leaf1.jpg');
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('FF95JGKHF','Hertz','Scooter','Trefor Tripl','Bianco',23,39,125,NULL,NULL,'trefor-tripl.jpg');
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('ALOPR6D6F','Avis','Auto','Tesla ModelS','Rosso',45,77,144,5,11000,'Tesla-modelS.jpg');
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('WOW202049','Car Italy','Auto','E-UP','Bianca',33,34,166,5,3000,'up_e-up.jpg');
INSERT INTO Veicolo_elettrico(Targa,Punto_Noleggio,Tipologia,Nome_Modello,Colore,Costo_orario,Cilindrata,Autonomia_km,Max_Passeggeri,Chilometraggio_Attuale,Foto) VALUES ('Z58GZ36HZ','Car Italy','Scooter','Askoll eS1','Bianco',64,88,123,NULL,NULL,NULL);


INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via santo stefano 3',10,9,44.495603, 11.353665);
INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via irnerio 4',25,24,44.500859, 11.346164);
INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via clavature 2',22,18,44.493449, 11.343733);
INSERT INTO Postazione_Prelievo(Indirizzo,Numero_Bici_Totale,Numero_Bici_Disponibili,Latitudine,Longitudine) VALUES ('via paglia 2',15,11,44.488376, 11.340799);


INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('01','via santo stefano 3','Scott Genius','Blu','2014');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('02','via irnerio 4','Diadora','Rosso','2011');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('03','via paglia 2','SRAM','Azzurro','2010');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('04','via clavature 2','Synchros','Nero','2016');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('05','via irnerio 4','XBionic','Bianco','2008');
INSERT INTO Bici(Id,Postazione_Prelievo,Marca,Colore,Anno_Acquisizione) VALUES ('06','via clavature 2','Topeak','Grigio','2999');


INSERT INTO Pista_Ciclabile(Chilometri,Pendenza_Media,Latitudine,Longitudine) VALUES (25,30.12,44.499554, 11.326543);
INSERT INTO Pista_Ciclabile(Chilometri,Pendenza_Media,Latitudine,Longitudine) VALUES (11,11,44.504853,11.345467);
INSERT INTO Pista_Ciclabile(Chilometri,Pendenza_Media,Latitudine,Longitudine) VALUES (8,0,44.486669, 11.339229);
INSERT INTO Pista_Ciclabile(Chilometri,Pendenza_Media,Latitudine,Longitudine) VALUES (3,99.99,44.521599, 11.362375);


INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','WOW202049',12,'2016-04-04 05:05:00','2016-04-05 11:05:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','123ABC456',200,'2016-05-11 04:01:00','2016-05-11 14:23:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','123ABC456',50,'2016-04-16 08:05:00','2016-04-23 08:05:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','WOW202049',12,'2016-01-02 10:05:22','2016-01-03 12:05:22');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','LAL123TFG',200,'2016-05-01 20:00:00','2016-05-02 10:30:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','123ABC456',50,'2016-04-01 00:01:00','2016-04-03 10:00:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','WOW202049',12,'2016-03-19 19:45:52','2016-03-21 21:05:39');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','Z58GZ36HZ',200,'2016-05-21 09:15:00','2016-05-22 16:35:40');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','Z58GZ36HZ',50,'2016-04-03 17:05:22','2016-04-07 20:15:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','123ABC456',50,'2016-07-16 08:05:00','2016-07-23 08:05:00');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','WOW202049',12,'2016-06-02 10:05:22','2016-06-03 12:05:22');	
INSERT INTO Prenotazione_Veicolo(EmailUtente,Veicolo,Prezzo_Prenotazione,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','LAL123TFG',200,'2016-08-01 20:00:00','2016-08-02 10:30:00');	

	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','01','2016-05-01 01:05:00','2016-05-01 03:55:00');
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','02','2016-04-22 13:25:02','2016-04-22 22:05:41');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','05','2016-05-23 09:19:19','2016-05-23 19:27:56');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','05','2016-05-03 15:29:23','2016-05-03 18:45:12');
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','01','2016-03-12 04:05:00','2016-03-12 07:23:10');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','03','2016-04-18 16:05:22','2016-04-18 16:55:22');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','02','2016-04-04 01:00:00','2016-04-04 01:15:00');
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','01','2016-05-09 16:33:10','2016-05-09 22:00:00');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','01','2016-05-11 07:05:00','2016-05-11 14:50:24');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','06','2016-04-26 04:11:25','2016-04-26 08:22:22');
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','04','2016-02-29 05:05:05','2016-02-29 07:07:07');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','02','2016-03-18 22:45:00','2016-03-19 04:12:12');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente2@gmail.com','06','2016-06-26 04:11:25','2016-06-26 08:22:22');
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente3@gmail.com','04','2016-07-29 05:05:05','2016-07-29 07:07:07');	
INSERT INTO Prenotazione_Bici(EmailUtente,IdBici,Data_Inizio,Data_Fine) VALUES ('utente1@gmail.com','02','2016-06-18 22:45:00','2016-06-19 04:12:12');	


INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('admin@gmail.com','News','A breve nuove news riguardanti il sito','2016-05-11 17:13:22');	
INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('admin@gmail.com','Aggiornamento sito','il sito &eacute stato aggiornato. A breve le info','2016-04-21 11:43:41');	
INSERT INTO ForumPost(EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('admin@gmail.com','Inserimento veicolo','Inserito nuovo veicolo','2016-05-17 22:11:10');	


INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via panto cane 5','Enel',150,'2016-05-02',44.501218, 11.361283);
INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via parigi 12','Hera',200,'2016-05-07',44.496566, 11.341283);
INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via saragozza 74','AIM Energy',233,'2016-05-02',44.490060, 11.332197);
INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via santo stefano 103','Hera',145,'2016-05-01',44.486947, 11.353282);
INSERT INTO Colonnina_Elettrica(Indirizzo,Ente_Fornitore,Max_KWH,Data_Inserimento,Latitudine,Longitudine) VALUES ('via Giovanni Amendola 12','Edison Energia',200,'2016-05-12',44.504589, 11.341035);


INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('utente2@gmail.com','via panto cane 5',5,7,'2016-11-15');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('utente2@gmail.com','via parigi 12',3,4,'2016-06-01');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('utente3@gmail.com','via saragozza 74',3,4,'2016-08-15');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('utente3@gmail.com','via santo stefano 103',7,9,'2016-08-15');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('utente2@gmail.com','via Giovanni Amendola 12',12,17,'2016-07-01');
INSERT INTO Prenotazione_Colonnina(EmailUtente,Indirizzo,Slot_Inizio,Slot_Fine,Data_pren) VALUES ('utente3@gmail.com','via santo stefano 103',1,6,'2016-09-22');


INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('1','utente2@gmail.com','Buca','incidente','2015-11-12 13:49:02');
INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('3','utente3@gmail.com','Mancanza Segnaletica','Chiamate la polizia','2016-04-18 16:17:02');
INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('4','utente2@gmail.com','Segnalazione di prova','segnalo qualcosa','2015-11-12 13:49:02');
INSERT INTO Segnalazione(Pista_Ciclabile,EmailUtente,Titolo,Testo_Messaggio,Data_Inserimento) VALUES ('3','utente3@gmail.com','Incidente','Bici tutte rotte','2016-04-18 16:17:02');

