
DELIMITER $$


DROP PROCEDURE IF EXISTS `inserisciTransazione`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserisciTransazione` (IN `IDAccount` INT, IN `Importo` DECIMAL(10,2), IN `DataTransazione` DATE, IN `IDCategoriaPrimaria` INT, IN `IDCategoriaSecondaria` INT, IN `Descrizione` TEXT, IN `IsEntrata` TINYINT(1))   BEGIN
    -- Inserimento nella tabella transazioni
    INSERT INTO transazioni
        (IDAccount, Importo, DataTransazione, 
         IDCategoriaPrimaria, IDCategoriaSecondaria, Descrizione, IsEntrata)
    VALUES 
        (IDAccount, Importo, DataTransazione, 
         IDCategoriaPrimaria, IDCategoriaSecondaria, Descrizione, IsEntrata);

    -- Aggiornamento del saldo dell'account associato
    UPDATE account
    SET Saldo = Saldo + (Importo * CASE WHEN IsEntrata = 1 THEN 1 ELSE -1 END)
    WHERE IdAccount = IDAccount; 
END$$




CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminaTransazione` (IN `IDTransazione` INT)
BEGIN
  -- Recupera i valori di Importo e IsEntrata per aggiornare il saldo dell'account
  DECLARE Importo DECIMAL(10,2);
  DECLARE IsEntrata TINYINT(1);

  SELECT Importo, IsEntrata INTO Importo, IsEntrata
  FROM transazioni
  WHERE ID = IDTransazione;

  DELETE FROM transazioni WHERE ID = IDTransazione;

  -- Aggiorna il saldo dell'account
  UPDATE account
  SET Saldo = Saldo - (Importo * CASE WHEN IsEntrata = 1 THEN 1 ELSE -1 END)
  WHERE IdAccount = (SELECT IDAccount FROM transazioni WHERE ID = IDTransazione LIMIT 1);
END$$




-- Procedure per la creazione di un nuovo account
CREATE PROCEDURE creaAccount(IN nomeAccount VARCHAR(255), IN saldo DECIMAL(10,2))
BEGIN
    -- Qui va la logica per inserire un nuovo account nel database
    INSERT INTO account(Nome_Account, saldo) VALUES (nomeAccount, saldo);
END //



-- Procedure per l'eliminazione di un account esistente
CREATE PROCEDURE `EliminaAccount` (IN `IdAccount` INT)
BEGIN
    -- Eliminazione delle eventuali dipendenze: transazioni, risparmi, spese ricorrenti, obiettivi, crediti, debiti
    -- Assicurati di aggiornare o rimuovere questa logica in base alla struttura effettiva del tuo DB e alle relazioni tra le tabelle
    
    -- Elimina transazioni associate all'account
    DELETE FROM transazioni WHERE IDAccount = IdAccount;
    
    -- Qui potresti aggiungere altre istruzioni SQL per gestire la cancellazione di altre entità correlate all'account
    -- Ad esempio: DELETE FROM risparmi WHERE IDRisparmio = (SELECT IDRisparmio FROM account WHERE IdAccount = IdAccount);
    
    -- Eliminazione dell'account
    DELETE FROM account WHERE IdAccount = IdAccount;
END$$


DELIMITER ;
