<?php
$insertTransaction  = "CALL InsertTransaction(?, ?, ?, ?, ?, ?)";
$insertConto  = "CALL InsertConto(?, ?, ?)";
$insertPrimaryCategory  = "CALL  InsertPrimaryCategory(?, ?,?)";
$insertSecondaryCategory  = "CALL InsertSecondaryCategory(?, ?, ?)";
$insertRisparmio  =  "CALL InsertSavings(?, ?, ?, ?, ?)";
$insertDebit  = "CALL InsertDebt(?, ?, ?, ?, ?, ?, ?)";
$insertCredit  = "CALL InsertCredit(?, ?, ?, ?, ?, ?, ?)";
$insertBudget  = "CALL InsertBudget(?, ?, ?, ?, ?)";
$insertTransactionTemplate  = "CALL InsertTransactionTemplate(?, ?, ?, ?, ?, ?, ?)";
$insertProfile  = "CALL InsertProfile(?, ?, ?)";

$selectAllTransactions  = "CALL GetAllTransazioni()";
$selectAllConti  = "CALL GetAllConti()`";
$selectAllPrimaryCategories  = "CAll GetAllCategoriePrimarie()";
$selectAllRisparmi  = "CALL GetAllRisparmi()";
$selectAllDebiti  = "CALL GetAllDebiti()";
$selectAllCrediti  = "CALL GetAllCrediti()";
$selectAllSecondaryCategories  = "CALL GetAllCategorieSecondarie()";
$selectAllBudget  = "CALL GetAllBudget()";
$selectAllTransactionsTemplate  = "CALL GetAllTransazioniTemplate()";
$selectAllProfili  = "CALL GetAllProfili()";

$selectUserByEmail  = "CALL selectUserByEmail(?)";
$selectIDProfileByEmail  = "CALL selectIDProfileByEmail(?)";
$selectSecondaryFromPrimary  = "CALL selectSecondaryFromPrimary(?)";
$selectIdContoFromNome  = "CALL selectIdContoFromNome(?)";
$selectAccountById  = "CALL selectAccountById(?)";
$selectCategoriaPrimariaById  = "CALL selectCategoriaPrimariaById(?)";
$selectTransactionFromID  = "CALL selectTransactionFromID(?)";
$selectSecondaryCategoryFromID  = "CALL selectSecondaryCategoryFromID(?)";
$selectTemplateTransactionFromID  = "CALL selectTemplateTransactionFromID(?)";
$selectSavingFromID  = "CALL selectSavingFromID(?)";
$selectBudgetFromID  = "CALL selectBudgetFromID(?)";
$selectDebitFromID  = "CALL selectDebitFromID(?)";
$selectCreditFromID  = "CALL selectCreditFromID(?)";

$selectContoFromEmail = "CALL GetContoByEmail(?)";
$selectCategoriaPrimariaFromEmail = "CALL GetCategoriaPrimariaByEmail(?)";
$selectCategoriaSecondariaFromEmail = "CALL GetCategoriaSecondariaByEmail(?)";
$selectTransazioniFromEmail = "CALL GetTransazioniByEmail(?)";
$selectTransazioniTemplateFromEmail = "CALL GetTransazioniTemplateByEmail(?)";
$selectRisparmiFromEmail = "CALL GetRisparmiByEmail(?)";
$selectDebitiFromEmail = "CALL GetDebitiByEmail(?)";
$selectCreditiFromEmail = "CALL GetCreditiByEmail(?)";
$selectBudgetFromEmail = "CALL GetBudgetByEmail(?)";

$updateTransaction = "CALL UpdateTransaction(?,?,?,?,?,?,?)";
$deleteTransaction = "CALL DeleteTransaction(?)";

$updatePrimaryCategory = "CALL UpdatePrimaryCategory(?,?,?)";
$deletePrimaryCategory = "CALL DeletePrimaryCategory(?)";

$updateConto = "CALL UpdateConto(?,?,?)";
$deleteConto = "CALL DeleteConto(?)";

$updateSecondaryCategory = "CALL UpdateSecondaryCategory(?,?,?,?)";
$deleteSecondaryCategory = "CALL DeleteSecondaryCategory(?)";

$updateTemplateTransaction = "CALL UpdateTemplateTransaction(?,?,?,?,?,?,?,?)";
$deleteTemplateTransaction = "CALL DeleteTemplateTransaction(?)";

$updateRisparmio = "CALL UpdateRisparmio(?,?,?,?,?)";
$deleteRisparmio = "CALL DeleteRisparmio(?)";

$updateBudget = "CALL UpdateBudget(?,?,?,?,?,?)";
$deleteBudget = "CALL DeleteBudget(?)";

$updateDebito = "CALL UpdateDebito(?,?,?,?,?,?,?,?)";
$deleteDebito = "CALL DeleteDebito(?)";

$updateCredito = "CALL UpdateCredito(?,?,?,?,?,?,?,?)";
$deleteCredito = "CALL DeleteCredito(?)";
