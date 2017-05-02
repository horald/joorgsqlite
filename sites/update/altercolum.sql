ALTER TABLE tblfahrtenbuch RENAME TO tblfahrtenbuch_alt;

CREATE TABLE "tblfahrtenbuch" (
  "fldIndex" integer NULL PRIMARY KEY AUTOINCREMENT,
  "fldFahrzeug" text NULL,
  "fldVondatum" text NULL,
  "fldBisdatum" text NULL DEFAULT '1970-01-01',
  "fldVonkm" text NULL,
  "fldBiskm" text NULL,
  "fldDauer" text NULL,
  "fldZeittarif" text NULL,
  "fldStatus" text NULL,
  "fldind_datum" text NULL DEFAULT '0',
  "fldid_adr" numeric NULL DEFAULT '0',
  "fldKmpreis" text NULL,
  "fldtimestamp" text NULL,
  "flddbsyncnr" integer NULL DEFAULT '8',
  "flddbsyncstatus" text NULL DEFAULT 'SYNC'
);

insert into tblfahrtenbuch select * from tblfahrtenbuch_alt;

DROP TABLE "tblfahrtenbuch_alt";