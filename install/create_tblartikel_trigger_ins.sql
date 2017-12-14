CREATE TRIGGER tblartikel_au
AFTER UPDATE ON tblartikel
FOR EACH ROW
BEGIN
  update tblartikel set fldtimestamp=DateTime('now','localtime') where fldindex=old.fldindex;
END