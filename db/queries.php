<?php
$selectAllAccountsQuery = "SELECT * FROM account";
$queryBudgetMassimoMinimo = "SELECT * FROM budgetmassimominimo";
$selectAllCategoriePrimarieQuery = "SELECT * FROM categoriaprimaria";
$selectAllCategorieSecondarieQuery = "SELECT * FROM categoriasecondaria";
$queryCredito = "SELECT * FROM credito";
$queryObiettiviFinanziari = "SELECT * FROM obiettivifinanziari";
$queryPianificazionePagamento = "SELECT * FROM pianificazionepagamento";
$selectAllPositionsQuery = "SELECT * FROM posizione";
$queryRisparmi = "SELECT * FROM risparmi";
$queryTemplateTransazioni = "SELECT * FROM template_transazioni";
$selectAllTransactionsQuery = "SELECT * FROM transazioni";


$insertAccountQuery = "INSERT INTO account (Nome_Account, Saldo) VALUES (?, ?)";
$insertPositionQuery = "INSERT INTO posizione (Longitudine, Latitudine, NomeCitta) VALUES (?, ?, ?)";
$insertCategoriaPrimariaQuery = "INSERT INTO categoriaprimaria (NomeCategoria, DescrizioneCategoria) VALUES (?, ?)";
$insertCategoriaSecondariaQuery = "INSERT INTO categoriasecondaria (IDCategoriaPrimaria, NomeCategoria, DescrizioneCategoria) VALUES (?, ?, ?)";
$insertTransactionQuery =  "INSERT INTO transazioni (Importo, IDAccount, DataTransazione, IDCategoriaPrimaria, IDCategoriaSecondaria, Descrizione, IsEntrata) VALUES (?, ?, ?, ?, ?, ?, ?)";
