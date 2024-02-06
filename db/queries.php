<?php
$selectAllAccountsQuery = "SELECT * FROM account";
$queryBudgetMassimoMinimo = "SELECT * FROM budgetmassimominimo";
$selectAllCategoriePrimarieQuery = "SELECT * FROM categoriaprimaria";
$selectAllCategorieSecondarieQuery = "SELECT * FROM categoriasecondaria";
$queryCredito = "SELECT * FROM credito";
$queryObiettiviFinanziari = "SELECT * FROM obiettivifinanziari";
$queryPianificazionePagamento = "SELECT * FROM pianificazionepagamento";
$selectAllPositionsQuery = "SELECT * FROM posizione";
$queryPrestiti = "SELECT * FROM prestiti";
$queryRisparmi = "SELECT * FROM risparmi";
$queryTemplateTransazioni = "SELECT * FROM template_transazioni";
$selectAllTransactionsQuery = "SELECT * FROM transazioni";


$insertAccountQuery = "INSERT INTO account (NomeAccount, Saldo) VALUES (?, ?)";
$insertPositionQuery = "INSERT INTO posizione (Longitudine, Latitudine, NomeCitta) VALUES (?, ?, ?)";
$insertCategoriaPrimariaQuery = "INSERT INTO categoriaprimaria (NomeCategoria, DescrizioneCategoria) VALUES (?, ?)";
$insertCategoriaSecondariaQuery = "INSERT INTO categoriasecondaria (IDCategoriaPrimaria, NomeCategoria, DescrizioneCategoria) VALUES (?, ?, ?)";
