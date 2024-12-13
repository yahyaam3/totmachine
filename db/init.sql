CREATE DATABASE IF NOT EXISTS project3;
USE project3;

-- Table: Users
CREATE TABLE Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    surname VARCHAR(50),
    email VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(100),
    avatar VARCHAR(255),
    role ENUM('TECHNICAL', 'SUPERVISOR', 'ADMINISTRATOR')
);

-- Table: Machines
CREATE TABLE Machines (
    id_machine INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100),
    manufacturer VARCHAR(100),
    serial_number VARCHAR(100),
    start_date DATE,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    image VARCHAR(255),
    technician_id INT,
    FOREIGN KEY (technician_id) REFERENCES Users(id_user)
);

-- Table: Incidents
CREATE TABLE Incidents (
    id_incident INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    priority ENUM('HIGH', 'MEDIUM', 'LOW'),
    status ENUM('WAITING', 'IN_PROCESS', 'RESOLVED'),
    issued_date DATETIME,
    resolved_date DATETIME,
    id_machine INT,
    id_user INT,
    FOREIGN KEY (id_machine) REFERENCES Machines(id_machine),
    FOREIGN KEY (id_user) REFERENCES Users(id_user)
);

-- Table: Maintenance
CREATE TABLE Maintenance (
    id_maintenance INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('PREVENTIVE', 'CORRECTIVE'),
    description TEXT,
    date DATE,
    time_spent INT,
    id_machine INT,
    id_user INT,
    FOREIGN KEY (id_machine) REFERENCES Machines(id_machine),
    FOREIGN KEY (id_user) REFERENCES Users(id_user)
);

-- Table: Maintenance History
CREATE TABLE Maintenance_History (
    id_history INT AUTO_INCREMENT PRIMARY KEY,
    id_incident INT,
    id_maintenance INT,
    comment TEXT,
    FOREIGN KEY (id_incident) REFERENCES Incidents(id_incident),
    FOREIGN KEY (id_maintenance) REFERENCES Maintenance(id_maintenance)
);

-- Table: Notifications
CREATE TABLE Notifications (
    id_notification INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    sent_date DATETIME,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES Users(id_user)
);
