ALTER TABLE tblerledigungen RENAME TO tblerledigungen_alt;

CREATE TABLE `tblerledigungen` (
  `fldIndex` integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  `fldDetailInd` integer NULL,
  `fldRang` text NULL,
  `fldBezeichnung` text NULL,
  `fldStatus` text NULL,
  `fldBenutzer` text NULL,
  `fldDatum` text NOT NULL,
  `fldErledigDat` text NULL,
  `fldArchivDat` text NULL,
  `fldbemerkung` text NULL,
  `fldArt` text NULL,
  `fldPrior` text NULL,
  `fldGruppe` text NULL,
  `fldurl` text NULL,
  `fldcategory` text NULL,
  `fldid_erlgrp` integer NULL,
  `fldtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flddbsyncstatus` text NOT NULL DEFAULT 'SYNC'
);

insert into tblerledigungen (fldIndex,fldPrior,fldErledigDat,fldDatum,fldcategory,fldBezeichnung,fldStatus,flddbsyncstatus,fldid_erlgrp) 
select fldIndex,fldprior,fldErledigDat,fldDatum,fldcategory,fldbez,fldstatus,flddbsyncstatus,fldid_erlgrp from tblerledigungen_alt;

DROP TABLE "tblerledigungen_alt";