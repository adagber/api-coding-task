DROP DATABASE IF EXISTS `lotr`;
CREATE DATABASE `lotr` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `lotr`;

DROP TABLE IF EXISTS `factions`;
CREATE TABLE `factions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faction_name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `leader` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `equipments`;
CREATE TABLE `equipments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `made_by` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `character_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `characters`;
CREATE TABLE `characters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birth_date` date NOT NULL,
  `kingdom` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `equipment_id` int NOT NULL,
  `faction_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `faction_id` (`faction_id`),
  CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`),
  CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`faction_id`) REFERENCES `factions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `equipments` ADD CONSTRAINT `equipments_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`);

SET foreign_key_checks = 0;

INSERT INTO `factions` (
  `id`,
  `faction_name`,
  `description`,
  `leader`
) VALUES (
  1,
  'MORDOR',
  'Mordor es un país situado al sureste de la Tierra Media, que tuvo gran importancia durante la Guerra del Anillo por ser el lugar donde Sauron, el Señor Oscuro, decidió edificar su fortaleza de Barad-dûr para intentar atacar y dominar a todos los pueblos de la Tierra Media.',
  'SAURON'
);

INSERT INTO `equipments` (
  `id`,
  `name`,
  `type`,
  `made_by`,
  `character_id`
) VALUES (
  1,
  'Maza de Sauron',
  'arma',
  'desconocido',
  1
);

INSERT INTO `characters` (
  `id`,
  `name`,
  `birth_date`,
  `kingdom`,
  `equipment_id`,
  `faction_id`
) VALUES (
  1,
  'SAURON',
  '3019-03-25',
  'AINUR',
  1,
  1
);

SET foreign_key_checks = 1;

DROP TABLE IF EXISTS `characters`;
CREATE TABLE `users` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
     `bcrypt_hash` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
     `registered_at` datetime NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
     `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
     PRIMARY KEY (`id`),
     UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (
    `email`,
    `bcrypt_hash`,
    `registered_at`,
    `roles`
) VALUES (
     'user@gmail.com',
     '$2y$10$QiRR7kDPO/bQOoeUiN.1TeKKgK9Bqksb2Ph1sVY7oe.fcU9559sTe', #Password -> 1234
     NOW(),
     'a:1:{i:0;s:9:"ROLE_USER";}'
 );

INSERT INTO `users` (
    `email`,
    `bcrypt_hash`,
    `registered_at`,
    `roles`
) VALUES (
     'admin@gmail.com',
     '$2y$10$QiRR7kDPO/bQOoeUiN.1TeKKgK9Bqksb2Ph1sVY7oe.fcU9559sTe', #Password -> 1234
     NOW(),
     'a:1:{i:0;s:10:"ROLE_ADMIN";}'
 );