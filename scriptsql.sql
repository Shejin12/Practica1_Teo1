DROP DATABASE IF EXISTS renta_autos;
CREATE DATABASE renta_autos
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_spanish_ci;
USE renta_autos;

CREATE TABLE empleados (
  dpi            CHAR(13)     PRIMARY KEY,
  rol            ENUM('gerente','limpieza','atencion') NOT NULL,
  nombres        VARCHAR(80)  NOT NULL,
  apellidos      VARCHAR(80)  NOT NULL,
  telefono       VARCHAR(20)  NOT NULL,
  correo         VARCHAR(120) NOT NULL UNIQUE,
  sueldo_mensual DECIMAL(10,2) NOT NULL CHECK (sueldo_mensual >= 0),
  username       VARCHAR(40)  NOT NULL UNIQUE,
  passwrd        VARCHAR(255) NOT NULL

) ENGINE=InnoDB;

CREATE TABLE clientes (
  dpi       CHAR(13)     PRIMARY KEY,
  nombres   VARCHAR(80)  NOT NULL,
  apellidos VARCHAR(80)  NOT NULL,
  telefono  VARCHAR(20)  NOT NULL,
  correo    VARCHAR(120) NULL

) ENGINE=InnoDB;

CREATE TABLE autos (
  placa      VARCHAR(7)  PRIMARY KEY,
  marca      VARCHAR(60) NOT NULL,
  modelo     VARCHAR(60) NOT NULL,
  disponible BOOLEAN     NOT NULL DEFAULT TRUE,
  estado     ENUM('activo','mantenimiento','baja') NOT NULL DEFAULT 'activo',
  foto       VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE alquileres (
  id_alquiler   BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  dpi_cliente   CHAR(13)     NOT NULL,
  dpi_empleado  CHAR(13)     NOT NULL,
  placa_auto    VARCHAR(7)   NOT NULL,
  hora_salida   DATETIME     NOT NULL,
  hora_llegada  DATETIME     NULL,
  total_cobrado DECIMAL(10,2) NULL CHECK (total_cobrado >= 0),

  CONSTRAINT fk_alq_cliente  FOREIGN KEY (dpi_cliente)  REFERENCES clientes(dpi),
  CONSTRAINT fk_alq_empleado FOREIGN KEY (dpi_empleado) REFERENCES empleados(dpi),
  CONSTRAINT fk_alq_auto     FOREIGN KEY (placa_auto)   REFERENCES autos(placa)
) ENGINE=InnoDB;


INSERT INTO empleados (dpi, rol, nombres, apellidos, telefono, correo, sueldo_mensual, username, passwrd)
VALUES ('1234567890123', 'gerente', 'Ana', 'García', '5555-0001', 'ana.gerente@empresa.com', 8000.00, 'ana', '1234');

INSERT INTO empleados (dpi, rol, nombres, apellidos, telefono, correo, sueldo_mensual, username, passwrd)
VALUES ('1234567890124', 'limpieza', 'Marta', 'López', '5555-0002', 'marta.limpieza@empresa.com', 3000.00, 'marta', '1234');

INSERT INTO empleados (dpi, rol, nombres, apellidos, telefono, correo, sueldo_mensual, username, passwrd)
VALUES ('1234567890125', 'atencion', 'Luis', 'Pérez', '5555-0003', 'luis.atencion@empresa.com', 4500.00, 'luis', '1234');