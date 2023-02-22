CREATE DATABASE gestion_alumnos;
USE gestion_alumnos;

CREATE TABLE Alumnos(
id INT AUTO_INCREMENT PRIMARY KEY,
nombres VARCHAR(255),
apellidos VARCHAR(255),
sexo CHAR(1),
fecha_nacimiento DATE,
fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Cursos(
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(255),
descripcion VARCHAR(255),
fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Alumnos_Cursos(
alumno_id INT NOT NULL,
curso_id INT NOT NULL,
fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (alumno_id, curso_id),
FOREIGN KEY (alumno_id) REFERENCES Alumnos(id) ON DELETE CASCADE,
FOREIGN KEY (curso_id) REFERENCES Cursos(id) ON DELETE CASCADE
);

CREATE TABLE Notas(
alumno_id INT NOT NULL,
curso_id INT NOT NULL,
practica1 DECIMAL(4,2),
practica2 DECIMAL(4,2),
practica3 DECIMAL(4,2),
parcial DECIMAL(4,2),
final DECIMAL(4,2),
PRIMARY KEY (alumno_id, curso_id),
FOREIGN KEY (alumno_id) REFERENCES Alumnos(id) ON DELETE CASCADE,
FOREIGN KEY (curso_id) REFERENCES Cursos(id) ON DELETE CASCADE
);


INSERT INTO Alumnos(nombres, apellidos, sexo, fecha_nacimiento)
VALUES
('Juan', 'Pérez', 'M', '1999-03-15'),
('María', 'González', 'F', '2000-07-22'),
('Pedro', 'Hernández', 'M', '1998-11-12'),
('Ana', 'Martínez', 'F', '1997-01-08');

INSERT INTO Cursos(nombre, descripcion)
VALUES
('Matemáticas', 'Curso de matemáticas básicas'),
('Inglés', 'Curso de inglés para principiantes'),
('Historia', 'Curso de historia universal'),
('Programación', 'Curso de programación con Python');

INSERT INTO Alumnos_Cursos(alumno_id, curso_id)
VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(1, 4),
(2, 4),
(3, 4);

INSERT INTO Notas(alumno_id, curso_id, practica1, practica2, practica3, parcial, final)
VALUES
(1, 1, 14.5, 15.5, 16, 12, 13),
(2, 1, 15, 16, 14, 15, 16),
(3, 2, 17, 16.5, 15, 18, 17.5),
(4, 3, 13.5, 14, 12, 15, 14),
(1, 4, 16, 15.5, 17, 18, 16.5),
(2, 4, 18, 17.5, 16, 17, 18),
(3, 4, 14, 13.5, 15, 16, 15.5);
