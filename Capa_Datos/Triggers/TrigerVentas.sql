
DELIMITER //

CREATE TRIGGER sumar_puntos_despues_venta
AFTER INSERT ON venta
FOR EACH ROW
BEGIN
    DECLARE puntos_a_sumar INT;
    
    SET puntos_a_sumar = 50;
    

    UPDATE usuario 
    SET puntos = puntos + puntos_a_sumar 
    WHERE idUsuario = NEW.idUsuario;
    
END;//

DELIMITER ;

DELIMITER //

CREATE TRIGGER actualizar_stock_despues_venta
BEFORE INSERT ON detalle_prods
FOR EACH ROW
BEGIN
    DECLARE stock_actual INT;
    

    SELECT stock INTO stock_actual 
    FROM productos 
    WHERE idProducto = NEW.idProducto;
    

    IF stock_actual < NEW.cantidad THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Stock insuficiente para realizar la venta';
    ELSE

        UPDATE productos 
        SET stock = stock - NEW.cantidad 
        WHERE idProducto = NEW.idProducto;
    END IF;
    
END;//

DELIMITER ;