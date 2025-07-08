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
    `categorie` ENUM('Formation', 'Bureau', 'Réunion') NOT NULL,
    `adresse` varchar(255) NOT NULL,
    PRIMARY KEY (`id_salle`)
);

CREATE TABLE `produit` (
    `id_produit` int(11) NOT NULL AUTO_INCREMENT,
    `date_arrivee` datetime NOT NULL,
    `date_depart` datetime NOT NULL,
    `prix` double NOT NULL,
    `categorie` ENUM('Réunion', 'Bureau', 'Formation') NOT NULL,
    `etat` ENUM('libre', 'occupé') NOT NULL,
    `ville` varchar(155) NOT NULL,
    `capacite` int(11) NOT NULL,
    `id_salle` int(11),
    PRIMARY KEY (`id_produit`),
    FOREIGN KEY (`id_produit`) REFERENCES `salle`(`id_salle`) 
);

CREATE TABLE `membre` (
    `id_membre` int(11) NOT NULL AUTO_INCREMENT,
    `pseudo` varchar(155) NOT NULL,
    `nom` varchar(155) NOT NULL,
    `prenom` varchar(155) NOT NULL,
    `email` varchar(155) NOT NULL,
    `statut` varchar(255) NOT NULL,
    `civilite` enum('m', 'f') NOT NULL,
    PRIMARY KEY (`id_membre`)
);


CREATE TABLE `commande` (
    `id_commande` int(11) NOT NULL AUTO_INCREMENT,
    `id_membre` int(11) NOT NULL,
    `id_produit` int(11) NOT NULL,
    `commande_ref` varchar(55) NOT NULL,
    `commande_statut` enum('confirmed','closed','pending'),
    `autre_options` varchar(155),
    PRIMARY KEY (`id_commande`),
    FOREIGN KEY (`id_membre`) REFERENCES `membre`(`id_membre`),
    FOREIGN KEY (`id_produit`) REFERENCES `produit`(`id_produit`)
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


