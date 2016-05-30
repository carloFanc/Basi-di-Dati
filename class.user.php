<?php

require_once ('dbconfig.php');

class USER {

	private $conn;
	public $error = "";
	public function __construct() {
		$database = new Database();
		$db = $database -> dbConnection();
		$this -> conn = $db;
	}

	public function runQuery($sql) {
		$stmt = $this -> conn -> prepare($sql);
		return $stmt;
	}

	public function errorGetter() {
		return $this -> error;

	}

	public function errorSetter($data) {
		$this -> error = $data;

	}

	public function register($uname, $ucogn, $umail, $upass, $udata, $uluogo, $uresidenza, $utel, $foto) {
		try {

			$utip = 'Semplice';
			$stmt = $this -> conn -> prepare("INSERT INTO Utente(Email, Nome, Cognome, Password, Tipologia, Data_Nascita, Luogo_Nascita, Indirizzo_Residenza, Telefono,Foto) 
		                                               VALUES(:umail, :uname, :ucogn, :upass, :utip, :udata, :uluogo, :uresidenza, :utel, :foto)");

			$stmt -> bindparam(":umail", $umail);
			$stmt -> bindparam(":uname", $uname);
			$stmt -> bindparam(":ucogn", $ucogn);
			$stmt -> bindparam(":utip", $utip);
			$stmt -> bindparam(":upass", $upass);
			$stmt -> bindparam(":udata", $udata);
			$stmt -> bindparam(":uluogo", $uluogo);
			$stmt -> bindparam(":uresidenza", $uresidenza);
			$stmt -> bindparam(":utel", $utel);
			$stmt -> bindparam(":foto", $foto);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {
			echo $e -> getMessage();
		}
	}

	public function Insertmsg($mailm, $maild, $titolo, $tipo, $text, $data) {
		try {
			$stmt = $this -> conn -> prepare("INSERT INTO Messaggio(Email_Mittente,Email_Destinatario,Titolo,Tipo,Testo_Messaggio,DataInvio) VALUES (:mailm,:maild,:titolo,:tipo,:text,:data)");

			$stmt -> bindparam(":mailm", $mailm);
			$stmt -> bindparam(":maild", $maild);
			$stmt -> bindparam(":titolo", $titolo);
			$stmt -> bindparam(":tipo", $tipo);
			$stmt -> bindparam(":text", $text);
			$stmt -> bindparam(":data", $data);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {
			echo $e -> getMessage();
		}
	}

	public function InsertPost($mailm, $titolo, $text) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentoPost(:mailm,:titolo,:text)");

			$stmt -> bindparam(":mailm", $mailm);
			$stmt -> bindparam(":titolo", $titolo);
			$stmt -> bindparam(":text", $text);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {
			echo $e -> getMessage();
		}
	}

	public function InsertBici($mailm, $id, $date1, $date2) {
		try {
			$stmt = $this -> conn -> prepare("CALL PrenotazioneBici(:mailm,:id,:date1,:date2)");

			$stmt -> bindparam(":mailm", $mailm);
			$stmt -> bindparam(":id", $id);
			$stmt -> bindparam(":date1", $date1);
			$stmt -> bindparam(":date2", $date2);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertVeicoli($mailm, $targa, $date1, $date2) {
		try {
			$stmt = $this -> conn -> prepare("CALL PrenotazioneVeicolo(:mailm,:targa,:date1,:date2)");

			$stmt -> bindparam(":mailm", $mailm);
			$stmt -> bindparam(":targa", $targa);
			$stmt -> bindparam(":date1", $date1);
			$stmt -> bindparam(":date2", $date2);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertSegnalazione($id, $mailm, $titolo, $testo) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentoSegnalazione(:id,:mailm,:titolo,:testo)");

			$stmt -> bindparam(":id", $id);
			$stmt -> bindparam(":mailm", $mailm);
			$stmt -> bindparam(":titolo", $titolo);
			$stmt -> bindparam(":testo", $testo);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertnewBici($id, $postazione, $marca, $colore, $anno) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentonewBici(:id,:postazione,:marca,:colore,:anno)");

			$stmt -> bindparam(":id", $id);
			$stmt -> bindparam(":postazione", $postazione);
			$stmt -> bindparam(":marca", $marca);
			$stmt -> bindparam(":colore", $colore);
			$stmt -> bindparam(":anno", $anno);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertnewVeicolo($Targa, $Punto_Noleggio, $Tipologia, $Nome_Modello, $Colore, $Costo_orario, $Cilindrata, $Autonomia_km, $Max_Passeggeri, $Chilometraggio_Attuale, $Foto) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentonewVeicolo(:targa,:puntonoleggio,:tipologia,:modello,:colore,:costorario,:cilindrata,:autonomia,:maxpasseggeri,:chilometri,:foto)");

			$stmt -> bindparam(":targa", $Targa);
			$stmt -> bindparam(":puntonoleggio", $Punto_Noleggio);
			$stmt -> bindparam(":tipologia", $Tipologia);
			$stmt -> bindparam(":modello", $Nome_Modello);
			$stmt -> bindparam(":colore", $Colore);
			$stmt -> bindparam(":costorario", $Costo_orario);
			$stmt -> bindparam(":cilindrata", $Cilindrata);
			$stmt -> bindparam(":autonomia", $Autonomia_km);
			$stmt -> bindparam(":maxpasseggeri", $Max_Passeggeri);
			$stmt -> bindparam(":chilometri", $Chilometraggio_Attuale);
			$stmt -> bindparam(":foto", $Foto);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertnewPostazione($indirizzo, $numbicitotale, $numbicidisp, $lat, $long) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentonewPostazione(:ind,:numbicitotale,:numbicidisp,:lat,:long)");

			$stmt -> bindparam(":ind", $indirizzo);
			$stmt -> bindparam(":numbicitotale", $numbicitotale);
			$stmt -> bindparam(":numbicidisp", $numbicidisp);
			$stmt -> bindparam(":lat", $lat);
			$stmt -> bindparam(":long", $long);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertnewPistaCiclabile($chilometri, $pendenza, $lat, $long) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentonewPistaCiclabile(:chilometri,:pen,:lat,:long)");

			$stmt -> bindparam(":chilometri", $chilometri);
			$stmt -> bindparam(":pen", $pendenza);
			$stmt -> bindparam(":lat", $lat);
			$stmt -> bindparam(":long", $long);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertnewPuntoNoleggio($nome, $sito, $email, $tel, $ind, $lat, $long) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentonewPuntoNoleggio(:nome,:sito,:email,:tel,:ind,:lat,:long)");

			$stmt -> bindparam(":nome", $nome);
			$stmt -> bindparam(":sito", $sito);
			$stmt -> bindparam(":email", $email);
			$stmt -> bindparam(":tel", $tel);
			$stmt -> bindparam(":ind", $ind);
			$stmt -> bindparam(":lat", $lat);
			$stmt -> bindparam(":long", $long);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function InsertnewColonninaRicarica($ind, $ente, $maxKWH, $data, $lat, $long) {
		try {
			$stmt = $this -> conn -> prepare("CALL InserimentonewColonninaRicarica(:ind,:ente,:maxKWH,:data,:lat,:long)");

			$stmt -> bindparam(":ind", $ind);
			$stmt -> bindparam(":ente", $ente);
			$stmt -> bindparam(":maxKWH", $maxKWH);
			$stmt -> bindparam(":data", $data);
			$stmt -> bindparam(":lat", $lat);
			$stmt -> bindparam(":long", $long);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function PrenotazioneColonnina($umail, $indirizzo, $slot1, $slot2, $data) {
		try {
			$stmt = $this -> conn -> prepare("CALL PrenotazioneColonnina(:umail,:indirizzo,:slot1,:slot2,:data)");

			$stmt -> bindparam(":umail", $umail);
			$stmt -> bindparam(":indirizzo", $indirizzo);
			$stmt -> bindparam(":slot1", $slot1);
			$stmt -> bindparam(":slot2", $slot2);
			$stmt -> bindparam(":data", $data);
			$stmt -> execute();

			return $stmt;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function doLogin($umail, $upass) {
		try {
			$stmt = $this -> conn -> prepare("SELECT * FROM Utente WHERE Email=:umail AND Password=:upass ");
			$stmt -> bindparam(":umail", $umail);
			$stmt -> bindparam(":upass", $upass);
			$stmt -> execute();
			$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			if ($stmt -> rowCount() == 1) {
				$_SESSION['user_email'] = $userRow['Email'];
				$_SESSION['user_tipologia'] = $userRow['Tipologia'];
				return true;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			echo $e -> getMessage();
		}
	}

	public function is_loggedin() {
		if (isset($_SESSION['user_email'])) {
			return true;
		}
	}

	public function redirect($url) {
		header("Location: $url");
	}

	public function doLogout() {
		session_destroy();
		unset($_SESSION['user_email']);
		return true;
	}

	public function getDataColonnina($indirizzo) {
		try {
			$stmt = $this -> conn -> prepare("SELECT Data_Inserimento FROM Colonnina_Elettrica WHERE Indirizzo=:indirizzo  ");
			$stmt -> bindparam(":indirizzo", $indirizzo);
			$stmt -> execute();
			$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);
			return $userRow;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

	public function getAllPrenotazioniColonnina($indirizzo) {
		try {
			$stmt = $this -> conn -> prepare("SELECT Slot_Inizio, Slot_Fine FROM Prenotazione_Colonnina WHERE Indirizzo=:indirizzo  ");
			$stmt -> bindparam(":indirizzo", $indirizzo);
			$stmt -> execute();
			$userRow = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			return $userRow;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}
public function getPrenotazioniColonninaUltimaData($indirizzo) {
		try {
			$stmt = $this -> conn -> prepare("SELECT MAX(Data_pren) AS Data_pren FROM Prenotazione_Colonnina WHERE Indirizzo=:indirizzo  ");
			$stmt -> bindparam(":indirizzo", $indirizzo);
			$stmt -> execute();
			$userRow = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			return $userRow;
		} catch(PDOException $e) {

			$this -> errorSetter($e -> getMessage());
		}
	}

}
?>