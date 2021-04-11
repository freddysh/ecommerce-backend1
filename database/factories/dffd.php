
DELIMITER ;;
DROP PROCEDURE IF EXISTS micursor;;
CREATE PROCEDURE micursor()
BEGIN
DECLARE done BOOLEAN DEFAULT FALSE;
DECLARE uid integer;
DECLARE nombre text;
DECLARE detalle text;
DECLARE c1 cursor for SELECT id,name,detail from products;
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = TRUE;
open c1;
c1_loop: LOOP
fetch c1 into uid,nombre,detalle;
        IF `done` THEN LEAVE c1_loop; END IF;
        UPDATE products SET name = detalle  WHERE id=uid;
END LOOP c1_loop;
CLOSE c1;
END ;;
