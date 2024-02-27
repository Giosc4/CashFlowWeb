SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `account` (
  IdAccount int(11) NOT NULL,
  Nome_Account varchar(255) DEFAULT NULL,
  Saldo decimal(10,2) DEFAULT NULL,
  IDRisparmio int(11) DEFAULT NULL,
  IDSpesaRicorrente int(11) DEFAULT NULL,
  IDObiettivo int(11) DEFAULT NULL,
  IDCredito int(11) DEFAULT NULL,
  IDDebito int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE budgetmassimominimo (
  IDBudget int(11) NOT NULL,
  IDCategoria int(11) DEFAULT NULL,
  ImportoMassimo decimal(10,2) DEFAULT NULL,
  DataFine date DEFAULT NULL,
  DataInizio date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE categoriaprimaria (
  ID int(11) NOT NULL,
  NomeCategoria varchar(255) DEFAULT NULL,
  DescrizioneCategoria text DEFAULT NULL,
  IDBudgetMassimo int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE categoriasecondaria (
  ID int(11) NOT NULL,
  IDCategoriaPrimaria int(11) DEFAULT NULL,
  NomeCategoria varchar(255) DEFAULT NULL,
  DescrizioneCategoria text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE credito (
  ID int(11) NOT NULL,
  Importo decimal(10,2) DEFAULT NULL,
  DataEstrinzione date DEFAULT NULL,
  Note text DEFAULT NULL,
  DataConcessione date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE debito (
  IDDebito int(11) NOT NULL,
  Importo decimal(10,2) DEFAULT NULL,
  DataEstrinzione date DEFAULT NULL,
  Note text DEFAULT NULL,
  DataConcessione date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE obiettivifinanziari (
  IDObiettivo int(11) NOT NULL,
  DescrizioneObiettivo text DEFAULT NULL,
  ImportoObiettivo decimal(10,2) DEFAULT NULL,
  DataScadenza date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE pianificazionepagamento (
  ID int(11) NOT NULL,
  IDAccount int(11) DEFAULT NULL,
  ImportoSpesa decimal(10,2) DEFAULT NULL,
  DataScadenza date DEFAULT NULL,
  IDCategoria int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE risparmi (
  Id int(11) NOT NULL,
  IDAccount int(11) DEFAULT NULL,
  Importo decimal(10,2) DEFAULT NULL,
  DataInizioRisparmio date DEFAULT NULL,
  DataFineRisparmio date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE template_transazioni (
  IDTemplate int(11) NOT NULL,
  NomeTemplate varchar(255) DEFAULT NULL,
  ImportoPredefinito decimal(10,2) DEFAULT NULL,
  IDCategoriaPrimaria int(11) DEFAULT NULL,
  IDCategoriaSecondaria int(11) DEFAULT NULL,
  Descrizione varchar(50) DEFAULT NULL,
  IDAccount int(11) DEFAULT NULL,
  DataTransazione date DEFAULT NULL,
  IsEntrata tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE transazioni (
  ID int(11) NOT NULL,
  Importo decimal(10,2) NOT NULL,
  IDAccount int(11) NOT NULL,
  DataTransazione date NOT NULL,
  IDCategoriaPrimaria int(11) DEFAULT NULL,
  IDCategoriaSecondaria int(11) DEFAULT NULL,
  Descrizione text DEFAULT NULL,
  IsEntrata tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE account
  ADD PRIMARY KEY (IdAccount),
  ADD KEY FK_Account_Risparmi (IDRisparmio),
  ADD KEY FK_Account_SpesaRicorrente (IDSpesaRicorrente),
  ADD KEY FK_Account_Credito (IDCredito),
  ADD KEY IDDebito (IDDebito);

ALTER TABLE budgetmassimominimo
  ADD PRIMARY KEY (IDBudget);

ALTER TABLE categoriaprimaria
  ADD PRIMARY KEY (ID);

ALTER TABLE categoriasecondaria
  ADD PRIMARY KEY (ID);

ALTER TABLE credito
  ADD PRIMARY KEY (ID);

ALTER TABLE debito
  ADD PRIMARY KEY (IDDebito);

ALTER TABLE obiettivifinanziari
  ADD PRIMARY KEY (IDObiettivo);

ALTER TABLE pianificazionepagamento
  ADD PRIMARY KEY (ID);

ALTER TABLE risparmi
  ADD PRIMARY KEY (Id);

ALTER TABLE template_transazioni
  ADD PRIMARY KEY (IDTemplate),
  ADD KEY FK_Template_CategoriaPrimaria (IDCategoriaPrimaria),
  ADD KEY FK_Template_CategoriaSecondaria (IDCategoriaSecondaria),
  ADD KEY fk_template_transazioni_IDAccount (IDAccount);

ALTER TABLE transazioni
  ADD PRIMARY KEY (ID),
  ADD KEY IDCategoriaPrimaria (IDCategoriaPrimaria),
  ADD KEY IDCategoriaSecondaria (IDCategoriaSecondaria),
  ADD KEY transazioni_ibfk_1 (IDAccount);


ALTER TABLE account
  MODIFY IdAccount int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE budgetmassimominimo
  MODIFY IDBudget int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE categoriaprimaria
  MODIFY ID int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE categoriasecondaria
  MODIFY ID int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE credito
  MODIFY ID int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE debito
  MODIFY IDDebito int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE obiettivifinanziari
  MODIFY IDObiettivo int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE pianificazionepagamento
  MODIFY ID int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE risparmi
  MODIFY Id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE template_transazioni
  MODIFY IDTemplate int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE transazioni
  MODIFY ID int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE account
  ADD CONSTRAINT FK_Account_Credito FOREIGN KEY (IDCredito) REFERENCES credito (ID),
  ADD CONSTRAINT FK_Account_Risparmi FOREIGN KEY (IDRisparmio) REFERENCES risparmi (Id),
  ADD CONSTRAINT FK_Account_SpesaRicorrente FOREIGN KEY (IDSpesaRicorrente) REFERENCES pianificazionepagamento (ID),
  ADD CONSTRAINT account_ibfk_1 FOREIGN KEY (IDDebito) REFERENCES debito (IDDebito);

ALTER TABLE template_transazioni
  ADD CONSTRAINT FK_Template_CategoriaPrimaria FOREIGN KEY (IDCategoriaPrimaria) REFERENCES categoriaprimaria (ID),
  ADD CONSTRAINT FK_Template_CategoriaSecondaria FOREIGN KEY (IDCategoriaSecondaria) REFERENCES categoriasecondaria (ID),
  ADD CONSTRAINT fk_template_transazioni_IDAccount FOREIGN KEY (IDAccount) REFERENCES account (IdAccount);

ALTER TABLE transazioni
  ADD CONSTRAINT transazioni_ibfk_1 FOREIGN KEY (IDAccount) REFERENCES account (IdAccount) ON DELETE CASCADE,
  ADD CONSTRAINT transazioni_ibfk_3 FOREIGN KEY (IDCategoriaPrimaria) REFERENCES categoriaprimaria (ID),
  ADD CONSTRAINT transazioni_ibfk_4 FOREIGN KEY (IDCategoriaSecondaria) REFERENCES categoriasecondaria (ID);
