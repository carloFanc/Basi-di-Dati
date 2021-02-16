# Progetto Basi di Dati: Web App BolognaGreen

## Specifiche
Si vuole realizzare una piattaforma a supporto della mobilità sostenibile ed ecologica all’interno della città di Bologna. Tale piattaforma gestisce i dati relativi alla disponibilità di mezzi di trasporto “green” (bici, scooter elettrici, auto elettriche) presenti sul territorio, e fornisce la possibilità -agli utenti registrati-di prenotare l’utilizzo di tali mezzi, e di accedere a servizi avanzati in tema di mobilità urbana.
In particolare, la piattaforma gestisce i dati relativi a tre tipologie di mezzi: bici, scooter elettrici ed auto elettriche. Le bici dispongono di: identificativo, marca, anno di acquisizione, colore. Le bici sono poste in postazioni di prelievo dislocate in vari punti della città. Ogni bici è collocata in una postazione; viceversa, ogni postazione di prelievo può contenere più bici. Di ogni postazione si vogliono memorizzare: indirizzo, geolocalizzazione (latitudine, longitudine), numero bici (totale, sia disponibili sia attualmente utilizzate), numero bici attualmente disponibili. Inoltre, si vuole tenere traccia delle piste ciclabili presenti all’interno della città: ogni pista dispone di: numero progressivo, lunghezza (in km), pendenza media, e di un insieme di punti (lat, long) che formano il percorso. Gli scooter e le auto elettriche dispongono di: targa, nome modello, cilindrata, colore, autonomia (numero Km), costo orario del noleggio, foto. Per le auto elettriche, si vogliono memorizzare anche: numero max di passeggeri ed attuale chilometraggio. I veicoli elettrici (scooter ed auto) sono disponibili presso i punti di noleggio, caratterizzati da: nome, indirizzo, recapito telefonico, indirizzo email, sito Web, geolocalizzazione (latitudine, longitudine). Ogni veicolo è associato ad un singolo punto di noleggio.
Oltre ad i veicoli, la piattaforma gestisce i dati degli utenti registrati. Ogni utente dispone di: email (univoca), password, nome, cognome, anno di nascita, luogo di nascita, indirizzo di residenza, recapito telefonico, foto. Inoltre, ogni utente dispone di una INBOX di messaggi di segnalazione, inviati da altri utenti.
Sono presenti tre diverse categorie di utenti: semplici, premium ed amministratori. Gli utenti (semplici/premium) possono prenotare bici o veicoli (auto/scooter) elettrici. Ogni prenotazione è associata ad un utente, ad una bici o a un veicolo, e dispone di una data/orario di inizio ed una data/orario di fine. All’atto della prenotazione online, viene generato un codice univoco della stessa. Nel caso di bici, la prenotazione non può durare più di 12 ore. Nel caso di prenotazioni di veicoli elettrici, si vuole memorizzare anche il prezzo della prenotazione (prezzo = numero ore prenotazione * costo orario del noleggio del veicolo). Non è possibile prenotare un mezzo già prenotato/in uso da altri utenti.
Gli utenti premium possono accedere a servizi avanzati nel caso delle auto elettriche. In particolare, essi possono prenotare slot di ricarica presso colonnine elettriche (=stazioni di ricarica) disponibili nella città. Ogni colonnina dispone di: indirizzo, geolocalizzazione (latitudine, longitudine), potenza massima di erogazione (KWh), ente fornitore (es. ENEL). Una prenotazione di ricarica fa riferimento ad una colonnina ed un utente, e dispone di codice univoco, data, slot di inizio, slot di fine; si assume che gli slot abbiano durata di mezz’ora (48 slot per giornata). Non è possibile prenotare uno slot già in uso/prenotato da altri utenti. Inoltre, gli utenti premium possono inserire segnalazioni circa lo stato delle piste ciclabili. Ogni segnalazione fa riferimento ad una pista ciclabile, e dispone di data/ora inserimento, titolo, testo del messaggio, e può contenere una foto.
Gli utenti amministratori possono inserire/cancellare/modificare i dati relativi a mezzi, utenti e prenotazioni. Inoltre, essi possono inserire dei post all’interno di un forum, segnalando eventuali condizioni circa la mobilità urbana (es. “strada X interrotta per lavori”). Ogni post dispone di: data/ora inserimento, titolo e testo del messaggio.

## Operazioni principali fornite dal sistema informativo
Profilo utente (semplice):
- Si può visualizzare la lista delle bici, delle postazioni di prelievo di bici con numero di bici totali in ciascuna; fornita la visualizzazione attraverso tabella, e su Google Maps.
- Si possono visualizzare le piste ciclabili presenti sul territorio
- Si può visualizzare la lista dei punti di noleggio dei veicoli, con auto/scooter disponibili in ciascun punto; fornita visualizzazione attraverso tabella, e su Google Maps.
- Si possono visualizzare i vari elementi detti in precedenza posti entro un raggio di x chilometri dalla posizione corrente dell’utente
- Si può prenotare una bici o un veicolo elettrico
- Si può visualizzare le proprie prenotazioni (passate/in corso) con la possibilità di eliminare quelle in corso
- Mandare messaggi personali ad altri utenti e visualizzare i messaggi nella propria INBOX con la possibilità di eliminare i messaggi personali (sia i messaggi personali sia i messaggi che avvertono l’utente di un nuovo post nel forum)
- Visualizzare il forum
- Visualizzare il proprio profilo (con i dati inseriti dall’utente durante la registrazione) con la possibilità di cancellarsi dalla piattaforma.
- Visualizzare la Classifica degli utenti in base al numero di prenotazioni di bici/auto/scooter

Profilo utente (premium):
L’Utente Premium, ovviamente, può usufruire degli stessi servizi dell’utente semplice ma in più può:
- Inserire una segnalazione di una pista ciclabile che poi sarà visibile agli utenti che hanno una prenotazione attiva su di essa
- Visualizzare la lista delle colonnine di ricarica, con la disponibilità oraria di ciascuna (fornendo anche una visualizzazione su Google Maps potendo scegliere il raggio di chilometri dalla posizione corrente dell’utente).
- Prenotare un’operazione di ricarica presso una colonnina.
- Visualizzare dell’utilizzo medio delle colonnine di ricarica (slot occupati/slot totali) attraverso Google Charts.

Profilo amministratore:
- Inserire/visualizzare/cancellare i dati relativi a Bici, Postazioni, Piste Ciclabili, Veicoli, Punti Noleggio, Colonnine
- Possibilità di cancellare tutte le prenotazioni passate e ogni singola prenotazione in corso
- Visualizzazione di messaggi nell’INBOX potendo eliminare ogni singolo messaggio (sia personale sia globale)
- Inserire nuovi post nel forum
- Visualizzazione lista di tutti gli utenti con la possibilità di eliminarli
