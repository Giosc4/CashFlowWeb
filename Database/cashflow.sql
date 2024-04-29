

-- Creation of PianificazionePagamento table
CREATE TABLE PianificazionePagamento (
    ID INT PRIMARY KEY,
    IDTransazione INT,
    Ripetizione VARCHAR(255),
    DataScadenza DATE,
    FOREIGN KEY (IDTransazione) REFERENCES Transazione(ID)
);


-- Creation of Risparmi table
CREATE TABLE Risparmi (
    ID INT PRIMARY KEY,
    ImportoRisparmiato DECIMAL(10, 2),
    DataInizio DATE,
    DataFine DATE,
);

-- Creation of Debit table
CREATE TABLE Debit (
    ID INT PRIMARY KEY,
    ImportoDebito DECIMAL(10, 2),
    NomeImporto VARCHAR(255),
    DataConcessione DATE,
    DataEstinsione DATE,
    Note VARCHAR(255),
);

-- Creation of Credit table
CREATE TABLE Credit (
    ID INT PRIMARY KEY,
    ImportoCredito DECIMAL(10, 2),
    NomeImporto VARCHAR(255),
    DataConcessione DATE,
    DataEstinsione DATE,
    Note VARCHAR(255),
);

-- Creation of ObiettiviFinanziari table
CREATE TABLE ObiettiviFinanziari (
    ID INT PRIMARY KEY,
    NomeObiettivo VARCHAR(255),
    ImportoObiettivo DECIMAL(10, 2),
    DataScadenza DATE,
);

-- Creation of BudgetMax table 
CREATE TABLE BudgetMax (
    IDBudget INT PRIMARY KEY,
    NomeBudget VARCHAR(255),
    ImportoMax DECIMAL(10, 2),
    DataInizio DATE,
    DataFine DATE,
);

-- Creation of Conto table
CREATE TABLE Conto (
    IDConto INT PRIMARY KEY,
    NomeConto VARCHAR(255),
    Saldo DECIMAL(10, 2)
    IdRisparmio INT,
    IDDebit INT,
    IDCredit INT,
    IDObiettivo INT,
    FOREIGN KEY (IdRisparmio) REFERENCES Risparmi(ID),
    FOREIGN KEY (IDDebit) REFERENCES Debit(ID),
    FOREIGN KEY (IDCredit) REFERENCES Credit(ID),
    FOREIGN KEY (IDObiettivo) REFERENCES ObiettiviFinanziari(ID),
);

-- Creation of CategoriaPrimaria table
CREATE TABLE CategoriaPrimaria (
    ID INT PRIMARY KEY,
    NomeCategoria VARCHAR(255),
    DescrizioneCategoria VARCHAR(255)
    IDBudget INT,
    FOREIGN KEY (IDBudget) REFERENCES BudgetMax(IDBudget)
);

-- Creation of CategoriaSecondaria table
CREATE TABLE CategoriaSecondaria (
    ID INT PRIMARY KEY,
    IDCategoriaPrimaria INT,
    NomeCategoria VARCHAR(255),
    DescrizioneCategoria VARCHAR(255),
    FOREIGN KEY (IDCategoriaPrimaria) REFERENCES CategoriaPrimaria(ID)
);

-- Creation of AssConti table
CREATE TABLE AssConti (
    IDAssegnazione INT PRIMARY KEY,
    IDProfilo INT,
    IDConto INT,
    FOREIGN KEY (IDProfilo) REFERENCES Profili(IDProfilo),
    FOREIGN KEY (IDConto) REFERENCES Conto(IDConto)
);

-- Creation of Profili table
CREATE TABLE Profili (
    IDProfilo INT PRIMARY KEY,
    NomeProfilo VARCHAR(255),
    Saldo_totale DECIMAL(10, 2),
    Email VARCHAR(255),
    Password VARCHAR(255)
);

-- Creation of Template_Transazioni table
CREATE TABLE Template_Transazioni (
    IDTemplate INT PRIMARY KEY,
    NomeTemplate VARCHAR(255),
    Entrata_Uscita BOOLEAN,
    Importo DECIMAL(10, 2),
    IDConto INT,
    IDCategoriaPrimaria INT,
    IDCategoriaSecondaria INT,
    Descrizione VARCHAR(255),
    FOREIGN KEY (IDConto) REFERENCES Conto(IDConto),
    FOREIGN KEY (IDCategoriaPrimaria) REFERENCES CategoriaPrimaria(ID),
    FOREIGN KEY (IDCategoriaSecondaria) REFERENCES CategoriaSecondaria(ID)
);

-- Creation of Transazioni table
CREATE TABLE Transazione (
    ID INT PRIMARY KEY,
    Entrata_Uscita BOOLEAN,
    Importo DECIMAL(10, 2),
    IDTemplate INT,
    IDConto INT,
    DataTransazione DATE,
    IDCategoriaPrimaria INT,
    IDCategoriaSecondaria INT,
    Descrizione VARCHAR(255),
    FOREIGN KEY (IDTemplate) REFERENCES Template_Transazioni(IDTemplate),
    FOREIGN KEY (IDConto) REFERENCES Conto(IDConto),
    FOREIGN KEY (IDCategoriaPrimaria) REFERENCES CategoriaPrimaria(ID),
    FOREIGN KEY (IDCategoriaSecondaria) REFERENCES CategoriaSecondaria(ID)
);













































-- Stored Procedures for Profilo table

-- Create Profilo
CREATE PROCEDURE CreateProfilo(IN p_NomeProfilo VARCHAR(255), IN p_Saldo_totale DECIMAL(10, 2), IN p_Email VARCHAR(255), IN p_Password VARCHAR(255))
BEGIN
    INSERT INTO Profili (NomeProfilo, Saldo_totale, Email, Password) VALUES (p_NomeProfilo, p_Saldo_totale, p_Email, p_Password);
END;

-- Update Profilo
CREATE PROCEDURE UpdateProfilo(IN p_IDProfilo INT, IN p_NomeProfilo VARCHAR(255), IN p_Saldo_totale DECIMAL(10, 2), IN p_Email VARCHAR(255), IN p_Password VARCHAR(255))
BEGIN
    UPDATE Profili SET NomeProfilo = p_NomeProfilo, Saldo_totale = p_Saldo_totale, Email = p_Email, Password = p_Password WHERE IDProfilo = p_IDProfilo;
END;

-- Delete Profilo
CREATE PROCEDURE DeleteProfilo(IN p_IDProfilo INT)
BEGIN
    DELETE FROM Profili WHERE IDProfilo = p_IDProfilo;
END;





-- Stored Procedures for Transazione table

-- Create Transazione
CREATE PROCEDURE CreateTransazione(...)
BEGIN
    -- INSERT statement for Transazione with parameters for each column
END;

-- Update Transazione
CREATE PROCEDURE UpdateTransazione(...)
BEGIN
    -- UPDATE statement for Transazione with parameters for each column
END;

-- Delete Transazione
CREATE PROCEDURE DeleteTransazione(IN p_ID INT)
BEGIN
    DELETE FROM Transazioni WHERE ID = p_ID;
END;




-- Stored Procedures for Conto table

-- Create Conto
CREATE PROCEDURE CreateConto(...)
BEGIN
    -- INSERT statement for Conto with parameters for each column
END;

-- Update Conto
CREATE PROCEDURE UpdateConto(...)
BEGIN
    -- UPDATE statement for Conto with parameters for each column
END;

-- Delete Conto
CREATE PROCEDURE DeleteConto(IN p_IDConto INT)
BEGIN
    DELETE FROM Conto WHERE IDConto = p_IDConto;
END;




-- Stored Procedures for Risparmi table

-- Create Risparmi
CREATE PROCEDURE CreateRisparmi(...)
BEGIN
    -- INSERT statement for Risparmi with parameters for each column
END;

-- Update Risparmi
CREATE PROCEDURE UpdateRisparmi(...)
BEGIN
    -- UPDATE statement for Risparmi with parameters for each column
END;

-- Delete Risparmi
CREATE PROCEDURE DeleteRisparmi(IN p_ID INT)
BEGIN
    DELETE FROM Risparmi WHERE ID = p_ID;
END;




-- Stored Procedures for PianificazionePagamento table

-- Create PianificazionePagamento
CREATE PROCEDURE CreatePianificazionePagamento(...)
BEGIN
    -- INSERT statement for PianificazionePagamento with parameters for each column
END;

-- Update PianificazionePagamento
CREATE PROCEDURE UpdatePianificazionePagamento(...)
BEGIN
    -- UPDATE statement for PianificazionePagamento with parameters for each column
END;

-- Delete PianificazionePagamento
CREATE PROCEDURE DeletePianificazionePagamento(IN p_ID INT)
BEGIN
    DELETE FROM PianificazionePagamento WHERE ID = p_ID;
END;




-- Stored Procedures for Budget table

-- Create Budget
CREATE PROCEDURE CreateBudget(...)
BEGIN
    -- INSERT statement for Budget with parameters for each column
END;

-- Update Budget
CREATE PROCEDURE UpdateBudget(...)
BEGIN
    -- UPDATE statement for Budget with parameters for each column
END;

-- Delete Budget
CREATE PROCEDURE DeleteBudget(IN p_IDBudget INT)
BEGIN
    DELETE FROM BudgetMassimo WHERE IDBudget = p_IDBudget;
END;
