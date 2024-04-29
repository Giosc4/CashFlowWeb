<?php
class Assconti
{
    private $IDProfilo;
    private $IDConto;

    public function __construct($IDProfilo, $IDConto)
    {
        $this->IDProfilo = $IDProfilo;
        $this->IDConto = $IDConto;
    }
}
?>
<?php
class BudgetMax
{
    private $NomeBudget;
    private $ImportoMax;
    private $DataInizio;
    private $DataFine;

    public function __construct($NomeBudget, $ImportoMax, $DataInizio, $DataFine)
    {
        $this->NomeBudget = $NomeBudget;
        $this->ImportoMax = $ImportoMax;
        $this->DataInizio = $DataInizio;
        $this->DataFine = $DataFine;
    }
}
?>
<?php
class CategoriaPrimaria
{
    private $NomeCategoria;
    private $DescrizioneCategoria;
    private $IDBudget;

    public function __construct($NomeCategoria, $DescrizioneCategoria, $IDBudget)
    {
        $this->NomeCategoria = $NomeCategoria;
        $this->DescrizioneCategoria = $DescrizioneCategoria;
        $this->IDBudget = $IDBudget;
    }
}
?>
<?php
class CategoriaSecondaria
{
    private $IDCategoriaPrimaria;
    private $NomeCategoria;
    private $DescrizioneCategoria;

    public function __construct($IDCategoriaPrimaria, $NomeCategoria, $DescrizioneCategoria)
    {
        $this->IDCategoriaPrimaria = $IDCategoriaPrimaria;
        $this->NomeCategoria = $NomeCategoria;
        $this->DescrizioneCategoria = $DescrizioneCategoria;
    }
}
?>
<?php
class Conto
{
    private $NomeConto;
    private $Saldo;

    public function __construct($NomeConto, $Saldo)
    {
        $this->NomeConto = $NomeConto;
        $this->Saldo = $Saldo;
    }
    public function getNomeConto()
    {
        return $this->NomeConto;
    }
}
?>
<?php
class Credit
{
    private $ImportoCredito;
    private $NomeImporto;
    private $DataConcessione;
    private $DataEstinsione;
    private $Note;
    private $IDConto;

    public function __construct($ImportoCredito, $NomeImporto, $DataConcessione, $DataEstinsione, $Note, $IDConto)
    {
        $this->ImportoCredito = $ImportoCredito;
        $this->NomeImporto = $NomeImporto;
        $this->DataConcessione = $DataConcessione;
        $this->DataEstinsione = $DataEstinsione;
        $this->Note = $Note;
        $this->IDConto = $IDConto;
    }
}
?>
<?php
class Debit
{
    private $ImportoDebito;
    private $NomeImporto;
    private $DataConcessione;
    private $DataEstinsione;
    private $Note;
    private $IDConto;

    public function __construct($ImportoDebito, $NomeImporto, $DataConcessione, $DataEstinsione, $Note, $IDConto)
    {
        $this->ImportoDebito = $ImportoDebito;
        $this->NomeImporto = $NomeImporto;
        $this->DataConcessione = $DataConcessione;
        $this->DataEstinsione = $DataEstinsione;
        $this->Note = $Note;
        $this->IDConto = $IDConto;
    }
}
?>
<?php
class ObiettiviFinanziari
{
    private $NomeObiettivo;
    private $ImportoObiettivo;
    private $DataScadenza;
    private $IDConto;

    public function __construct($NomeObiettivo, $ImportoObiettivo, $DataScadenza, $IDConto)
    {
        $this->NomeObiettivo = $NomeObiettivo;
        $this->ImportoObiettivo = $ImportoObiettivo;
        $this->DataScadenza = $DataScadenza;
        $this->IDConto = $IDConto;
    }
}
?>
<?php
class Profilo
{
    private $NomeProfilo;
    private $Saldo_totale;
    private $Email;
    private $Password;

    public function __construct($NomeProfilo, $Saldo_totale, $Email, $Password)
    {
        $this->NomeProfilo = $NomeProfilo;
        $this->Saldo_totale = $Saldo_totale;
        $this->Email = $Email;
        $this->Password = $Password;
    }
}
?>
<?php
class Risparmi
{
    private $ImportoRisparmiato;
    private $DataInizio;
    private $DataFine;
    private $IDConto;

    public function __construct($ImportoRisparmiato, $DataInizio, $DataFine, $IDConto)
    {
        $this->ImportoRisparmiato = $ImportoRisparmiato;
        $this->DataInizio = $DataInizio;
        $this->DataFine = $DataFine;
        $this->IDConto = $IDConto;
    }
}
?>
<?php
class TemplateTransazioni
{
    private $NomeTemplate;
    private $Entrata_Uscita;
    private $Importo;
    private $IDConto;
    private $IDCategoriaPrimaria;
    private $IDCategoriaSecondaria;
    private $Descrizione;

    public function __construct($NomeTemplate, $Entrata_Uscita, $Importo, $IDConto, $IDCategoriaPrimaria, $IDCategoriaSecondaria, $Descrizione)
    {
        $this->NomeTemplate = $NomeTemplate;
        $this->Entrata_Uscita = $Entrata_Uscita;
        $this->Importo = $Importo;
        $this->IDConto = $IDConto;
        $this->IDCategoriaPrimaria = $IDCategoriaPrimaria;
        $this->IDCategoriaSecondaria = $IDCategoriaSecondaria;
        $this->Descrizione = $Descrizione;
    }
}
?>
<?php
class Transazione
{
    private $Entrata_Uscita;
    private $Importo;
    private $IDTemplate;
    private $IDConto;
    private $DataTransazione;
    private $IDCategoriaPrimaria;
    private $IDCategoriaSecondaria;
    private $Descrizione;

    public function __construct($Entrata_Uscita, $Importo, $IDTemplate, $IDConto, $DataTransazione, $IDCategoriaPrimaria, $IDCategoriaSecondaria, $Descrizione)
    {
        $this->Entrata_Uscita = $Entrata_Uscita;
        $this->Importo = $Importo;
        $this->IDTemplate = $IDTemplate;
        $this->IDConto = $IDConto;
        $this->DataTransazione = $DataTransazione;
        $this->IDCategoriaPrimaria = $IDCategoriaPrimaria;
        $this->IDCategoriaSecondaria = $IDCategoriaSecondaria;
        $this->Descrizione = $Descrizione;
    }
}
?>
