<?php

class Account {
    public $IDAccount;
    public $NomeAccount;
    public $Saldo;
    public $IDRisparmio;
    public $IDSpesaRicorrente;
    public $IDPrestito;
    public $IDObiettivo;
    public $IDCredito;

    public function __construct($IDAccount, $NomeAccount, $Saldo, $IDRisparmio, $IDSpesaRicorrente, $IDPrestito, $IDObiettivo, $IDCredito) {
        $this->IDAccount = $IDAccount;
        $this->NomeAccount = $NomeAccount;
        $this->Saldo = $Saldo;
        $this->IDRisparmio = $IDRisparmio;
        $this->IDSpesaRicorrente = $IDSpesaRicorrente;
        $this->IDPrestito = $IDPrestito;
        $this->IDObiettivo = $IDObiettivo;
        $this->IDCredito = $IDCredito;
    }
}

class BudgetMassimoMinimo {
    public $IDBudget;
    public $IDCategoria;
    public $ImportoMassimo;
    public $DataFine;
    public $DataInizio;

    public function __construct($IDBudget, $IDCategoria, $ImportoMassimo, $DataFine, $DataInizio) {
        $this->IDBudget = $IDBudget;
        $this->IDCategoria = $IDCategoria;
        $this->ImportoMassimo = $ImportoMassimo;
        $this->DataFine = $DataFine;
        $this->DataInizio = $DataInizio;
    }
}

class CategoriaPrimaria {
    public $ID;
    public $NomeCategoria;
    public $DescrizioneCategoria;
    public $IDBudgetMassimo;

    public function __construct($ID, $NomeCategoria, $DescrizioneCategoria, $IDBudgetMassimo) {
        $this->ID = $ID;
        $this->NomeCategoria = $NomeCategoria;
        $this->DescrizioneCategoria = $DescrizioneCategoria;
        $this->IDBudgetMassimo = $IDBudgetMassimo;
    }
}

class CategoriaSecondaria {
    public $ID;
    public $IDCategoriaPrimaria;
    public $NomeCategoria;
    public $DescrizioneCategoria;

    public function __construct($ID, $IDCategoriaPrimaria, $NomeCategoria, $DescrizioneCategoria) {
        $this->ID = $ID;
        $this->IDCategoriaPrimaria = $IDCategoriaPrimaria;
        $this->NomeCategoria = $NomeCategoria;
        $this->DescrizioneCategoria = $DescrizioneCategoria;
    }
}

class Credito {
    public $ID;
    public $ImportoCredito;
    public $DataConcessione;

    public function __construct($ID, $ImportoCredito, $DataConcessione) {
        $this->ID = $ID;
        $this->ImportoCredito = $ImportoCredito;
        $this->DataConcessione = $DataConcessione;
    }
}

class ObiettiviFinanziari {
    public $IDObiettivo;
    public $DescrizioneObiettivo;
    public $ImportoObiettivo;
    public $DataScadenza;

    public function __construct($IDObiettivo, $DescrizioneObiettivo, $ImportoObiettivo, $DataScadenza) {
        $this->IDObiettivo = $IDObiettivo;
        $this->DescrizioneObiettivo = $DescrizioneObiettivo;
        $this->ImportoObiettivo = $ImportoObiettivo;
        $this->DataScadenza = $DataScadenza;
    }
}

class PianificazionePagamento {
    public $ID;
    public $IDAccount;
    public $ImportoSpesa;
    public $DataScadenza;
    public $IDCategoria;

    public function __construct($ID, $IDAccount, $ImportoSpesa, $DataScadenza, $IDCategoria) {
        $this->ID = $ID;
        $this->IDAccount = $IDAccount;
        $this->ImportoSpesa = $ImportoSpesa;
        $this->DataScadenza = $DataScadenza;
        $this->IDCategoria = $IDCategoria;
    }
}

class Posizione {
    public $ID;
    public $Longitudine;
    public $Latitudine;
    public $NomeCitta;

    public function __construct($ID, $Longitudine, $Latitudine, $NomeCitta) {
        $this->ID = $ID;
        $this->Longitudine = $Longitudine;
        $this->Latitudine = $Latitudine;
        $this->NomeCitta = $NomeCitta;
    }
}

class Prestiti {
    public $IDPrestito;
    public $ImportoPrestito;
    public $DataConcessione;
    public $TassoInteresse;
    public $Durata;

    public function __construct($IDPrestito, $ImportoPrestito, $DataConcessione, $TassoInteresse, $Durata) {
        $this->IDPrestito = $IDPrestito;
        $this->ImportoPrestito = $ImportoPrestito;
        $this->DataConcessione = $DataConcessione;
        $this->TassoInteresse = $TassoInteresse;
        $this->Durata = $Durata;
    }
}

class Risparmi {
    public $Id;
    public $IDAccount;
    public $ImportoRisparmio;
    public $DataInizioRisparmio;
    public $DataFineRisparmio;

    public function __construct($Id, $IDAccount, $ImportoRisparmio, $DataInizioRisparmio, $DataFineRisparmio) {
        $this->Id = $Id;
        $this->IDAccount = $IDAccount;
        $this->ImportoRisparmio = $ImportoRisparmio;
        $this->DataInizioRisparmio = $DataInizioRisparmio;
        $this->DataFineRisparmio = $DataFineRisparmio;
    }
}

class TemplateTransazioni {
    public $IDTemplate;
    public $NomeTemplate;
    public $TipoTransazione;
    public $ImportoPredefinito;
    public $IDCategoriaPrimaria;
    public $IDCategoriaSecondaria;
    public $Frequenza;
    public $DatiAggiuntivi;

    public function __construct($IDTemplate, $NomeTemplate, $TipoTransazione, $ImportoPredefinito, $IDCategoriaPrimaria, $IDCategoriaSecondaria, $Frequenza, $DatiAggiuntivi) {
        $this->IDTemplate = $IDTemplate;
        $this->NomeTemplate = $NomeTemplate;
        $this->TipoTransazione = $TipoTransazione;
        $this->ImportoPredefinito = $ImportoPredefinito;
        $this->IDCategoriaPrimaria = $IDCategoriaPrimaria;
        $this->IDCategoriaSecondaria = $IDCategoriaSecondaria;
        $this->Frequenza = $Frequenza;
        $this->DatiAggiuntivi = $DatiAggiuntivi;
    }
}

class Transazioni {
    public $ID;
    public $Entrata_Uscita;
    public $Importo;
    public $IDAccount;
    public $IDPosizione;
    public $DataTransazione;
    public $IDCategoriaPrimaria;
    public $IDCategoriaSecondaria;
    public $Descrizione;

    public function __construct($ID, $Entrata_Uscita, $Importo, $IDAccount, $IDPosizione, $DataTransazione, $IDCategoriaPrimaria, $IDCategoriaSecondaria, $Descrizione) {
        $this->ID = $ID;
        $this->Entrata_Uscita = $Entrata_Uscita;
        $this->Importo = $Importo;
        $this->IDAccount = $IDAccount;
        $this->IDPosizione = $IDPosizione;
        $this->DataTransazione = $DataTransazione;
        $this->IDCategoriaPrimaria = $IDCategoriaPrimaria;
        $this->IDCategoriaSecondaria = $IDCategoriaSecondaria;
        $this->Descrizione = $Descrizione;
    }
}
?>
