-- TRIGGER PARA SMAR PUNTOS AL CLIENTE AL REALIZAR UNA VENTA
DELIMITER //

CREATE TRIGGER sumar_puntos_despues_venta
AFTER INSERT ON venta
FOR EACH ROW
BEGIN
    DECLARE puntos_a_sumar INT;
    
    SET puntos_a_sumar = 50;
    
    -- Actualizar los puntos del usuario
    UPDATE usuario 
    SET puntos = puntos + puntos_a_sumar 
    WHERE idUsuario = NEW.idUsuario;
    
END;//

DELIMITER ;
-- TRIGGER PARA ACTUALIZAR STOCK EN UN DETALLE PROD
DELIMITER //

CREATE TRIGGER actualizar_stock_despues_venta
BEFORE INSERT ON detalle_prods
FOR EACH ROW
BEGIN
    DECLARE stock_actual INT;
    
    -- Obtener el stock actual del producto
    SELECT stock INTO stock_actual 
    FROM productos 
    WHERE idProducto = NEW.idProducto;
    
    -- Validar que haya suficiente stock
    IF stock_actual < NEW.cantidad THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Stock insuficiente para realizar la venta';
    ELSE
        -- Actualizar el stock restando la cantidad vendida
        UPDATE productos 
        SET stock = stock - NEW.cantidad 
        WHERE idProducto = NEW.idProducto;
    END IF;
    
END;//

DELIMITER ;