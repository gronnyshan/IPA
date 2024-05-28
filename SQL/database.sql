DROP DATABASE IF EXISTS marketingmaster;
CREATE DATABASE marketingmaster;
USE marketingmaster;


CREATE TABLE mitarbeiter(

    benutzer_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    b_vorname VARCHAR(50) NOT NULL,
    b_nachname VARCHAR(50) NOT NULL,
    b_abteilung VARCHAR(15) NOT NULL,
    b_email VARCHAR(50) NOT NULL,
    b_tel VARCHAR(20) NOT NULL,
    b_passwort VARCHAR(30) NOT NULL

);

CREATE TABLE kunden (
    kunden_id INT AUTO_INCREMENT PRIMARY KEY,
    k_vorname VARCHAR(50) NOT NULL,
    k_nachname VARCHAR(50) NOT NULL,
    k_firmenname VARCHAR(50) NOT NULL,
    k_strasse VARCHAR(50) NOT NULL,
    k_plz INT NOT NULL,
    k_ort VARCHAR(50) NOT NULL,
    k_email VARCHAR(100) NOT NULL,
    k_telefon VARCHAR(15) NOT NULL,
    k_webseite VARCHAR(255)

);

CREATE TABLE dienstleistung(

    dienstleistung_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    d_name VARCHAR(50) NOT NULL,
    d_paket VARCHAR(50) NOT NULL,
    d_preis DECIMAL(15,2) NOT NULL

);

CREATE TABLE vertraege (
    vertrag_id INT AUTO_INCREMENT PRIMARY KEY,
    kunden_id INT NOT NULL,
    benutzer_id INT NOT NULL,
    vertragsbeginndatum DATE DEFAULT CURRENT_DATE,
    bemerkungen TEXT,
    FOREIGN KEY(kunden_id) REFERENCES kunden(kunden_id),
    FOREIGN KEY(benutzer_id) REFERENCES mitarbeiter(benutzer_id)
);

CREATE TABLE vd (

    vertrag_id INT NOT NULL,
    dienstleistung_id INT NOT NULL,
    PRIMARY KEY(vertrag_id, dienstleistung_id),
    FOREIGN KEY(vertrag_id) REFERENCES vertraege(vertrag_id),
    FOREIGN KEY(dienstleistung_id) REFERENCES dienstleistung(dienstleistung_id)

);


-- Benutzer erstellen für die Webseite
DROP USER IF EXISTS 'marketing'@'localhost';
CREATE USER 'marketing'@'localhost' IDENTIFIED BY 'Marketingmaster@483020';
GRANT DELETE, INSERT, SELECT ON marketingmaster.* TO 'marketing'@'localhost';
GRANT SELECT ON marketingmaster.vertraege TO 'marketing'@'localhost';
GRANT UPDATE ON marketingmaster.mitarbeiter TO 'marketing'@'localhost';

-- Dienstleistungen hinzufügen
INSERT INTO dienstleistung (d_name, d_paket, d_preis) VALUES 
('Webseite', 'Bronze 1-3 Seiten', 5770.00),
('Webseite', 'Silber 4-10 Seiten', 7690.00),
('Webseite', 'Silber 11-20 Seiten', 10440.00),

('SEO', 'PLZ/Dorf | Bronze 5 Kewywords', 4060.00),
('SEO', 'PLZ/Dorf | Silber 10 Kewywords', 5160.00),
('SEO', 'PLZ/Dorf | Gold 20 Kewywords', 7360.00),

('SEO', 'Stadt/Kanton | Bronze 5 Kewywords', 6810.00),
('SEO', 'Stadt/Kanton | Silber 10 Kewywords', 8460.00),
('SEO', 'Stadt/Kanton | Gold 20 Kewywords', 11760.00),

('SEO', 'National | Bronze 5 Kewywords', 13960.00),
('SEO', 'National | Silber 10 Kewywords', 16160.00),
('SEO', 'National | Gold 20 Kewywords', 20560.00),

('Google ADS', 'Bronze', 1750.00),
('Google ADS', 'Silber', 5050.00),
('Google ADS', 'Gold', 10550.00),
 
('Virtual Tour', 'Bronze 5 Punkte', 2740.00),
('Virtual Tour', 'Silber 10 Punkte', 4390.00),
('Virtual Tour', 'Gold 20 Punkte', 7690.00),
 
('Video', 'Bronze bis zu 10 Sekunden', 5490.00),
('Video', 'Silber bis zu 30 Sekunden', 7690.00),
('Video', 'Gold bis zu 60 Sekunden', 10900.00),
 
('Digital-Listing', 'Bronze 1 Standort', 3510.00),
('Digital-Listing', 'Silber 3-5 Standorte', 3180.00),
('Digital-Listing', 'Gold ab 6 Standorte', 2960.00),
 
('Social Media Verwaltung', 'Bronze 6 Posts', 1600.00),
('Social Media Verwaltung', 'Silber 12 Posts', 3190.00),
('Social Media Verwaltung', 'Gold 24 Posts', 6380.00),
 
('Social Media ADS', 'Bronze', 1750.00),
('Social Media ADS', 'Silber', 5050.00),
('Social Media ADS', 'Gold', 6380.00);

-- Mitarbeiter hinzufügen
INSERT INTO mitarbeiter (b_vorname, b_nachname, b_abteilung, b_email, b_tel, b_passwort) VALUES 
('Ronnyshan', 'George', 'admin', 'test1@marketingmaster.ch', '0787787404', 'T1'),
('Ronnyshan', 'George', 'verkaeufer', 'test2@marketingmaster.ch', '0787787404', 'T2'),
('Ronnyshan', 'George', 'buchhaltung', 'test3@marketingmaster.ch', '0787787404', 'T3'),
('Ronnyshan', 'George', 'verkaeufer', 'test4@marketingmaster.ch', '0787787404', 'T4');


