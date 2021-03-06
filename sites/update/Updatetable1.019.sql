DROP TABLE IF EXISTS "tblhelppage";
CREATE TABLE "tblhelppage" ("fldindex" integer NOT NULL PRIMARY KEY AUTOINCREMENT,"fldpageno" integer NOT NULL,"fldpagename" text NOT NULL,"fldhelpurl" text NULL, "fldheadline" text NULL, "flddbsyncstatus" text NULL DEFAULT 'SYNC');

INSERT INTO "tblhelppage" ("fldindex", "fldpageno", "fldpagename", "fldhelpurl", "fldheadline", "flddbsyncstatus") VALUES (1,	1,	'helpindex',	'helpindex.php',	'Index',	'SYNC');
INSERT INTO "tblhelppage" ("fldindex", "fldpageno", "fldpagename", "fldhelpurl", "fldheadline", "flddbsyncstatus") VALUES (11,	2,	'einleitung',	'einleitung.html',	'Einleitung',	'SYNC');
INSERT INTO "tblhelppage" ("fldindex", "fldpageno", "fldpagename", "fldhelpurl", "fldheadline", "flddbsyncstatus") VALUES (21,	3,	'buchfuehrung',	'buchfuehrung.html',	'Buchführung',	'SYNC');
INSERT INTO "tblhelppage" ("fldindex", "fldpageno", "fldpagename", "fldhelpurl", "fldheadline", "flddbsyncstatus") VALUES (31,	4,	'shopping',	'shopping.html',	'Einkaufsliste',	'SYNC');
INSERT INTO "tblhelppage" ("fldindex", "fldpageno", "fldpagename", "fldhelpurl", "fldheadline", "flddbsyncstatus") VALUES (41,	5,	'Google Calender',	'googlecal.html',	'Google Calender',	'SYNC');
INSERT INTO "tblhelppage" ("fldindex", "fldpageno", "fldpagename", "fldhelpurl", "fldheadline", "flddbsyncstatus") VALUES (51,	6,	'zeigupdates',	'zeigupdates.php',	'Updates',	'SYNC');

ALTER TABLE "tblmenu_liste" ADD COLUMN flddbsyncstatus VARCHAR DEFAULT 'SYNC';
ALTER TABLE "tblmenu_liste" ADD COLUMN fldparam VARCHAR;
DELETE FROM "tblmenu_liste" WHERE fldbez="Vorrat";
DELETE FROM "tblmenu_liste" WHERE fldmenu="artikel";
DELETE FROM "tblmenu_liste" WHERE fldmenu="ortkurz";
INSERT INTO "tblmenu_liste" ("fldid_parent", "fldglyphicon", "fldlink", "fldsort", "fldbez", "fldindex", "fldmenu", "fldview", "flddbsyncstatus", "fldparam") VALUES ('0',	'glyphicon-barcode',	'',	'100',	'Vorrat',	206,	'SUBMENU',	'J',	'SYNC',	'');
INSERT INTO "tblmenu_liste" ("fldid_parent", "fldglyphicon", "fldlink", "fldsort", "fldbez", "fldindex", "fldmenu", "fldview", "flddbsyncstatus", "fldparam") VALUES ('206',	'',	'',	'',	'Vorrat',	207,	'vorrat',	'J',	NULL,	'');
INSERT INTO "tblmenu_liste" ("fldid_parent", "fldglyphicon", "fldlink", "fldsort", "fldbez", "fldindex", "fldmenu", "fldview", "flddbsyncstatus", "fldparam") VALUES ('206',	'glyphicon-folder-close',	'',	'',	'Artikel',	208,	'artikel',	'J',	NULL,	'');
INSERT INTO "tblmenu_liste" ("fldid_parent", "fldglyphicon", "fldlink", "fldsort", "fldbez", "fldindex", "fldmenu", "fldview", "flddbsyncstatus", "fldparam") VALUES ('206',	'glyphicon-home',	'',	'',	'Ortkurz',	209,	'ortkurz',	'J',	'SYNC',	'');

DROP TABLE IF EXISTS "tblartikel";
CREATE TABLE "tblartikel" ("fldindex" integer NULL PRIMARY KEY AUTOINCREMENT,"fldBez" text NULL,"fldArtikelnr" text NULL,"fldTyp" text NULL,"fldSort" text NULL,"fldAbteilung" text NULL,"fldOrt" text NULL,"fldPreis" text NULL,"fldKonto" text NULL,"fldAnz" text NULL,"fldJN" text NULL,"fldArchivDat" text NULL DEFAULT '''''',"fldbarcode" text NULL,"fldReihenfolge" integer NULL,"fldverpackbez" text NULL,"fldverpackmeng" text NULL,"fldtimestamp" text NULL,"flddbsyncnr" integer NULL DEFAULT '4',"flddbsyncstatus" text NULL DEFAULT 'SYNC');


DROP TABLE IF EXISTS "tblortkurz";
CREATE TABLE "tblortkurz" ("fldindex" integer NOT NULL PRIMARY KEY AUTOINCREMENT,"fldkurz" text NULL,"fldbez" text NULL,"flddbsyncstatus" text NULL DEFAULT 'SYNC');


DROP TABLE IF EXISTS "tblvorrat";
CREATE TABLE "tblvorrat" ("fldindex" integer NOT NULL PRIMARY KEY AUTOINCREMENT,"fldbarcode" text NULL,"fldanz" text NULL, fldortkurz text Null, fldmhdatum text NULL, flddbsyncstatus text DEFAULT 'SYNC');

ALTER TABLE "tblfunc" ADD COLUMN flddbsyncstatus VARCHAR DEFAULT 'SYNC';
DELETE FROM "tblfunc" WHERE fldMenuID="vorrat";
INSERT INTO "tblfunc" ("fldindex", "fldBez", "fldphp", "fldMenuID", "fldTyp", "fldTarget", "fldParam", "fldAktiv", "fldName", "fldtimestamp", "fldversion", "flddbsyncstatus") VALUES (95,	'Schnellerfass',	'schnellerfass.php',	'vorrat',	'',	'',	'',	NULL,	'',	NULL,	NULL,	'SYNC');

ALTER TABLE "tblfilter" ADD COLUMN fldmaske VARCHAR;
ALTER TABLE "tblfilter" ADD COLUMN fldName VARCHAR;
