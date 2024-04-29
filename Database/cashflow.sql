
-- Creation of Risparmi table
CREATE TABLE Risparmi (
    ID INT PRIMARY KEY,
    ImportoRisparmiato DECIMAL(10, 2),
    DataInizio DATE,
    DataFine DATE
);

-- Creation of Debit table
CREATE TABLE Debit (
    ID INT PRIMARY KEY,
    ImportoDebito DECIMAL(10, 2),
    NomeImporto VARCHAR(255),
    DataConcessione DATE,
    DataEstinsione DATE,
    Note VARCHAR(255)
);

-- Creation of Credit table
CREATE TABLE Credit (
    ID INT PRIMARY KEY,
    ImportoCredito DECIMAL(10, 2),
    NomeImporto VARCHAR(255),
    DataConcessione DATE,
    DataEstinsione DATE,
    Note VARCHAR(255)
);

-- Creation of ObiettiviFinanziari table
CREATE TABLE ObiettiviFinanziari (
    ID INT PRIMARY KEY,
    NomeObiettivo VARCHAR(255),
    ImportoObiettivo DECIMAL(10, 2),
    DataScadenza DATE
);

-- Creation of BudgetMax table 
CREATE TABLE BudgetMax (
    IDBudget INT PRIMARY KEY,
    NomeBudget VARCHAR(255),
    ImportoMax DECIMAL(10, 2),
    DataInizio DATE,
    DataFine DATE
);

-- Creation of Conto table
CREATE TABLE Conto (
    IDConto INT PRIMARY KEY,
    NomeConto VARCHAR(255),
    Saldo DECIMAL(10, 2),
    IdRisparmio INT,
    IDDebit INT,
    IDCredit INT,
    IDObiettivo INT,
    FOREIGN KEY (IdRisparmio) REFERENCES Risparmi(ID),
    FOREIGN KEY (IDDebit) REFERENCES Debit(ID),
    FOREIGN KEY (IDCredit) REFERENCES Credit(ID),
    FOREIGN KEY (IDObiettivo) REFERENCES ObiettiviFinanziari(ID)
);

-- Creation of CategoriaPrimaria table
CREATE TABLE CategoriaPrimaria (
    ID INT PRIMARY KEY,
    NomeCategoria VARCHAR(255),
    DescrizioneCategoria VARCHAR(255),
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

-- Creation of Profili table
CREATE TABLE Profili (
    IDProfilo INT PRIMARY KEY,
    NomeProfilo VARCHAR(255),
    Saldo_totale DECIMAL(10, 2),
    Email VARCHAR(255),
    Password VARCHAR(255)
);

-- Creation of AssConti table
CREATE TABLE AssConti (
    IDAssegnazione INT PRIMARY KEY,
    IDProfilo INT,
    IDConto INT,
    FOREIGN KEY (IDProfilo) REFERENCES Profili(IDProfilo),
    FOREIGN KEY (IDConto) REFERENCES Conto(IDConto)
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

---------- TRIGGERS

--- Trigger per aggiornare il saldo di un conto dopo l'INSERIMENTO di una transazione
DELIMITER $$
CREATE TRIGGER aggiornaSaldoDopoInserimento
AFTER INSERT ON Transazione
FOR EACH ROW
BEGIN
    UPDATE Conto
    SET Saldo = CASE 
                    WHEN NEW.Entrata_Uscita = 1 THEN Saldo + NEW.Importo
                    ELSE Saldo - NEW.Importo
                END
    WHERE IDConto = NEW.IDConto;
END$$
DELIMITER ;


--- Trigger per aggiornare il saldo di un conto dopo l'AGGIORNAMENTO di una transazione
DELIMITER $$
CREATE TRIGGER aggiornaSaldoDopoAggiornamento
AFTER UPDATE ON Transazione
FOR EACH ROW
BEGIN
    UPDATE Conto
    SET Saldo = Saldo
              - CASE WHEN OLD.Entrata_Uscita = 1 THEN OLD.Importo ELSE -OLD.Importo END
              + CASE WHEN NEW.Entrata_Uscita = 1 THEN NEW.Importo ELSE -NEW.Importo END
    WHERE IDConto = NEW.IDConto;
END$$
DELIMITER ;

--- Trigger per aggiornare il saldo di un conto dopo l'ELIMINAZIONE di una transazione
DELIMITER $$
CREATE TRIGGER aggiornaSaldoDopoEliminazione
AFTER DELETE ON Transazione
FOR EACH ROW
BEGIN
    UPDATE Conto
    SET Saldo = CASE 
                    WHEN OLD.Entrata_Uscita = 1 THEN Saldo - OLD.Importo
                    ELSE Saldo + OLD.Importo
                END
    WHERE IDConto = OLD.IDConto;
END$$
DELIMITER ;

--- Stored Procedures per Profili
-- Create Profilo
DELIMITER $$
CREATE PROCEDURE sp_CreateProfilo(
    IN NomeProfilo VARCHAR(255),
    IN Saldo_totale DECIMAL(10, 2),
    IN Email VARCHAR(255),
    IN Password VARCHAR(255)
)
BEGIN
    INSERT INTO Profili (NomeProfilo, Saldo_totale, Email, Password)
    VALUES (NomeProfilo, Saldo_totale, Email, Password);
END$$
DELIMITER ;

-- Update Profilo
DELIMITER $$
CREATE PROCEDURE sp_UpdateProfilo(
    IN IDProfilo INT,
    IN NomeProfilo VARCHAR(255),
    IN Saldo_totale DECIMAL(10, 2),
    IN Email VARCHAR(255),
    IN Password VARCHAR(255)
)
BEGIN
    UPDATE Profili
    SET NomeProfilo = NomeProfilo,
        Saldo_totale = Saldo_totale,
        Email = Email,
        Password = Password
    WHERE IDProfilo = IDProfilo;
END$$
DELIMITER ;



-- Delete Profilo
DELIMITER $$
CREATE PROCEDURE sp_DeleteProfilo(
    IN IDProfilo INT
)
BEGIN
    DELETE FROM Profili WHERE IDProfilo = IDProfilo;
END$$
DELIMITER ;



--- Stored Procedures per Conto
-- Create Conto
DELIMITER $$
CREATE PROCEDURE sp_CreateConto(
    IN NomeConto VARCHAR(255),
    IN Saldo DECIMAL(10, 2),
    IN IdRisparmio INT,
    IN IDDebit INT,
    IN IDCredit INT,
    IN IDObiettivo INT
)
BEGIN
    INSERT INTO Conto (NomeConto, Saldo, IdRisparmio, IDDebit, IDCredit, IDObiettivo)
    VALUES (NomeConto, Saldo, IdRisparmio, IDDebit, IDCredit, IDObiettivo);
END$$
DELIMITER ;


-- Update Conto
DELIMITER $$
CREATE PROCEDURE sp_UpdateConto(
    IN IDConto INT,
    IN NomeConto VARCHAR(255),
    IN Saldo DECIMAL(10, 2),
    IN IdRisparmio INT,
    IN IDDebit INT,
    IN IDCredit INT,
    IN IDObiettivo INT
)
BEGIN
    UPDATE Conto
    SET NomeConto = NomeConto,
        Saldo = Saldo,
        IdRisparmio = IdRisparmio,
        IDDebit = IDDebit,
        IDCredit = IDCredit,
        IDObiettivo = IDObiettivo
    WHERE IDConto = IDConto;
END$$
DELIMITER ;


-- Delete Conto
DELIMITER $$
CREATE PROCEDURE sp_DeleteConto(
    IN IDConto INT
)
BEGIN
    DELETE FROM Conto WHERE IDConto = IDConto;
END$$
DELIMITER ;



--- Stored Procedures per Transazioni
-- Create Transazione
DELIMITER $$
CREATE PROCEDURE sp_CreateTransazione(
    IN Entrata_Uscita BOOLEAN,
    IN Importo DECIMAL(10, 2),
    IN IDTemplate INT,
    IN IDConto INT,
    IN DataTransazione DATE,
    IN IDCategoriaPrimaria INT,
    IN IDCategoriaSecondaria INT,
    IN Descrizione VARCHAR(255)
)
BEGIN
    INSERT INTO Transazione (Entrata_Uscita, Importo, IDTemplate, IDConto, DataTransazione, IDCategoriaPrimaria, IDCategoriaSecondaria, Descrizione)
    VALUES (Entrata_Uscita, Importo, IDTemplate, IDConto, DataTransazione, IDCategoriaPrimaria, IDCategoriaSecondaria, Descrizione);
END$$
DELIMITER ;


-- Update Transazione
DELIMITER $$
CREATE PROCEDURE sp_UpdateTransazione(
    IN ID INT,
    IN Entrata_Uscita BOOLEAN,
    IN Importo DECIMAL(10, 2),
    IN IDTemplate INT,
    IN IDConto INT,
    IN DataTransazione DATE,
    IN IDCategoriaPrimaria INT,
    IN IDCategoriaSecondaria INT,
    IN Descrizione VARCHAR(255)
)
BEGIN
    UPDATE Transazione
    SET Entrata_Uscita = Entrata_Uscita,
        Importo = Importo,
        IDTemplate = IDTemplate,
        IDConto = IDConto,
        DataTransazione = DataTransazione,
        IDCategoriaPrimaria = IDCategoriaPrimaria,
        IDCategoriaSecondaria = IDCategoriaSecondaria,
        Descrizione = Descrizione
    WHERE ID = ID;
END$$
DELIMITER ;


-- Delete Transazione
DELIMITER $$
CREATE PROCEDURE sp_DeleteTransazione(
    IN ID INT
)
BEGIN
    DELETE FROM Transazione WHERE ID = ID;
END$$
DELIMITER ;






























