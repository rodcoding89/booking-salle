/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  kwaye
 * Created: 4 juil. 2025
 */
CREATE TABLE `salle` (
    `id_salle` int(11) NOT NULL AUTO_INCREMENT,
    `titre` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `photo` varchar(355) NOT NULL,
    `pays` varchar(155) NOT NULL,
    `ville` varchar(155) NOT NULL,
    `cp` varchar(10) NOT NULL,
    `capacite` int(11) NOT NULL,
    `caracteristic` text NOT NULL,
    `categorie` ENUM('formation', 'bureau', 'reunion') NOT NULL,
    `rue` varchar(255) NOT NULL,
    `date_debut` date NULL,
    `date_fin` date NULL,
    `heure_debut` CHAR(8) NULL,
    `heure_fin` CHAR(8) NULL,
    PRIMARY KEY (`id_salle`)
);


CREATE TABLE `membre` (
    `id_membre` int(11) NOT NULL AUTO_INCREMENT,
    `pseudo` varchar(155) NOT NULL,
    `nom` varchar(155) NOT NULL,
    `prenom` varchar(155) NOT NULL,
    `email` varchar(155) NOT NULL,
    `statut` boolean NOT NULL,
    `civilite` enum('m', 'f') NOT NULL,
    `mdp` varchar(555) NOT NULL,
    `date_enregistrement` date NOT NULL,
    PRIMARY KEY (`id_membre`)
);


CREATE TABLE `commande` (
    `id_commande` int(11) NOT NULL,
    `id_membre` int(11) NOT NULL,
    `id_salle` int(11) NOT NULL,
    `commande_ref` varchar(55) NOT NULL,
    `commande_statut` enum('confirmed','closed','pending','cancelled') NOT NULL,
    `prix_journalier` double NOT NULL,
    `nb_jours_reserve` int(11) NOT NULL,
    `prix_total` double NOT NULL,
    `date_debut` date NOT NULL,
    `date_fin` date NOT NULL,
    `heure_debut` char(8) NOT NULL,
    `heure_fin` char(8) NOT NULL,
    `other_option` text DEFAULT NULL
    PRIMARY KEY (`id_commande`),
    FOREIGN KEY (`id_membre`) REFERENCES `membre`(`id_membre`),
    FOREIGN KEY (`id_salle`) REFERENCES `salle`(`id_salle`)
);

CREATE TABLE `avis` (
    `id_avis` int(11) NOT NULL AUTO_INCREMENT,
    `note` int(11) NOT NULL,
    `date_enregistrement` datetime NOT NULL,
    `commentaire` text NOT NULL,
    `description` text NOT NULL,
    `photo` varchar(355) NOT NULL,
    `id_membre` int(11) NOT NULL,
    `id_salle` int(11) NOT NULL,
    PRIMARY KEY (`id_avis`),
    FOREIGN KEY (`id_membre`) REFERENCES `membre`(`id_membre`),
    FOREIGN KEY (`id_salle`) REFERENCES `salle`(`id_salle`)
);


