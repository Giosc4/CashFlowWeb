<?php

class Account {
    public $IdAccount;
    public $Nome_Account;
    public $Saldo;
    public $IDRisparmio;
    public $IDSpesaRicorrente;
    public $IDObiettivo;
    public $IDCredito;

    public function __construct($IdAccount, $Nome_Account, $Saldo, $IDRisparmio, $IDSpesaRicorrente, $IDObiettivo, $IDCredito) {
        $this->IdAccount = $IdAccount;
        $this->Nome_Account = $Nome_Account;
        $this->Saldo = $Saldo;
        $this->IDRisparmio = $IDRisparmio;
        $this->IDSpesaRicorrente = $IDSpesaRicorrente;
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
    public $Importo;
    public $DataEstrinzione;
    public $Note;
    public $DataConcessione;

    public function __construct($ID, $Importo, $DataEstrinzione, $Note, $DataConcessione) {
        $this->ID = $ID;
        $this->Importo = $Importo;
        $this->DataEstrinzione = $DataEstrinzione;
        $this->Note = $Note;
        $this->DataConcessione = $DataConcessione;
    }
}

class Debito {
    public $IDDebito;
    public $Importo;
    public $DataEstrinzione;
    public $Note;
    public $DataConcessione;

    public function __construct($IDDebito, $Importo, $DataEstrinzione, $Note, $DataConcessione) {
        $this->IDDebito = $IDDebito;
        $this->Importo = $Importo;
        $this->DataEstrinzione = $DataEstrinzione;
        $this->Note = $Note;
        $this->DataConcessione = $DataConcessione;
    }
}

// And so on for each table...

// Please ensure you add all classes for your tables following the same pattern.
?>
