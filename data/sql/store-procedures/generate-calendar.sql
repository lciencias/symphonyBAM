-- DROP PROCEDURE `generate_calendar`//

DELIMITER //

CREATE PROCEDURE `generate_calendar`(IN dateStart DATE, IN dateEnd DATE)
BEGIN

  DECLARE dateAux DATE;
  DECLARE isWeekend BOOLEAN;

  TRUNCATE TABLE pcs_common_calendar;

  SET dateAux = dateStart;

  WHILE ( dateAux < dateEnd ) DO
  
     SET isWeekend = DAYNAME(dateAux) IN('Sunday', 'Saturday');

     INSERT INTO pcs_common_calendar ( date, is_weekend) VALUES ( dateAux, isWeekend);

     SET dateAux = DATE_ADD( dateAux, INTERVAL 1 DAY);

  END WHILE;

END//

DELIMITER ;

CALL `generate_calendar`('2011-01-01', '2015-01-01');

