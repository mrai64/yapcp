/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `pcp_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_awards` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contests.id 1:N ',
  `section_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fk: contest_section.id ',
  `section_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'from: section.id->code ',
  `award_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'free but unique in contest',
  `award_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'free',
  `is_award` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'N/Y flag, Y=award prize, N=HM or other',
  `winner_work_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fk: works.id ',
  `winner_user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fk: users.id user_contacts.user_id',
  `winner_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'winner not in previous cols',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`contest_id`,`award_code`),
  KEY `secondary_idx` (`contest_id`,`section_code`,`award_code`),
  KEY `view_idx` (`contest_id`,`section_id`,`award_code`,`winner_work_id`,`winner_user_id`,`winner_name`),
  KEY `pcp_contest_awards_deleted_at_index` (`deleted_at`),
  KEY `sixth_idx` (`winner_work_id`,`section_id`,`contest_id`),
  KEY `winner_user_id_idx` (`winner_user_id`),
  KEY `winner_work_id_idx` (`winner_work_id`),
  CONSTRAINT `pcp_contest_awards_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `pcp_contests` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contest awards contains both sections prizes and contest prizes (section code missing)';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_juries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_juries` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `section_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fx: contest_section.id 1:N ',
  `user_contact_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fx: user_contact.user_id',
  `is_president` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'N/Y flag',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`section_id`,`user_contact_id`),
  KEY `pcp_contest_juries_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_contest_juries_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `pcp_contest_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_juries_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_juries_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_contest_juries_view` AS SELECT 
 1 AS `contest_name_en`,
 1 AS `section_name_en`,
 1 AS `juror_last_name`,
 1 AS `juror_first_name`,
 1 AS `day_jury_works_opening`,
 1 AS `day_jury_works_closing`,
 1 AS `contest_id`,
 1 AS `section_id`,
 1 AS `juror_id`,
 1 AS `user_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_contest_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contests.id ',
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: user_contacts.user_id ',
  `fee_payment_completed` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'N/Y flag',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contest_idx` (`contest_id`,`user_id`),
  KEY `user_idx` (`user_id`,`contest_id`),
  KEY `pcp_contest_participants_fee_payment_completed_foreign` (`fee_payment_completed`),
  KEY `pcp_contest_participants_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_contest_participants_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `pcp_contests` (`id`),
  CONSTRAINT `pcp_contest_participants_fee_payment_completed_foreign` FOREIGN KEY (`fee_payment_completed`) REFERENCES `pcp_contest_participants_fee_payment_completed_sets` (`status`),
  CONSTRAINT `pcp_contest_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `pcp_user_contacts` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_participants_fee_payment_completed_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_participants_fee_payment_completed_sets` (
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_participants_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_participants_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_contest_participants_view` AS SELECT 
 1 AS `contest_name`,
 1 AS `country_id`,
 1 AS `last_name`,
 1 AS `first_name`,
 1 AS `fee_payment_completed`,
 1 AS `updated_at`,
 1 AS `user_id`,
 1 AS `contest_id`,
 1 AS `id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_contest_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_sections` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fx: contests.id 1:N ',
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'as fk: federationSections.code',
  `under_patronage` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'a Y/N col',
  `federation_section_id` bigint unsigned DEFAULT NULL COMMENT 'fk: federation_sections.id',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'international',
  `name_local` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'in local lang - see contests.lang_local',
  `rule_format` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jpg' COMMENT 'list of permitted extension',
  `rule_min` int unsigned NOT NULL DEFAULT '0' COMMENT 'minimum works-per-section',
  `rule_max` int unsigned NOT NULL DEFAULT '4' COMMENT 'maximum works-per-section',
  `rule_min_size` int unsigned NOT NULL DEFAULT '1024' COMMENT 'minimum short_side px',
  `rule_max_size` int unsigned NOT NULL DEFAULT '2500' COMMENT 'maximum long_side px',
  `rule_max_weight` int unsigned NOT NULL DEFAULT '6000' COMMENT 'file weight in KB',
  `rule_monochromatic` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'maybe boolean 0/N=false, 1/Y=true',
  `rule_raw_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 == false; 1 == true',
  `rule_only_one` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = only one prize per section per person not required',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`contest_id`,`code`),
  KEY `name_idx` (`contest_id`,`name_en`,`deleted_at`),
  KEY `pcp_contest_sections_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_contest_sections_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `pcp_contests` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_vote_group1_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_vote_group1_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_contest_vote_group1_view` AS SELECT 
 1 AS `vote_count`,
 1 AS `contest_name`,
 1 AS `section_name`,
 1 AS `vote`,
 1 AS `contest_id`,
 1 AS `section_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_contest_vote_single_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_vote_single_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_contest_vote_single_view` AS SELECT 
 1 AS `contest_name`,
 1 AS `code`,
 1 AS `section_name`,
 1 AS `vote`,
 1 AS `title_en`,
 1 AS `work_file`,
 1 AS `country_id`,
 1 AS `last_name`,
 1 AS `first_name`,
 1 AS `contest_id`,
 1 AS `section_id`,
 1 AS `work_id`,
 1 AS `juror_user_id`,
 1 AS `user_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_contest_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contests.id ',
  `section_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contest_sections.id ',
  `work_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: works.id contest_works.work_id',
  `juror_user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: user_contacts.user_id ',
  `vote` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'see contests.vote_rule',
  `review_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not required',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date of vote',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`contest_id`,`section_id`,`work_id`,`juror_user_id`),
  KEY `vote_idx` (`contest_id`,`section_id`,`vote`,`work_id`,`juror_user_id`),
  KEY `pcp_contest_votes_contest_id_index` (`contest_id`),
  KEY `pcp_contest_votes_section_id_index` (`section_id`),
  KEY `pcp_contest_votes_work_id_index` (`work_id`),
  KEY `pcp_contest_votes_juror_user_id_index` (`juror_user_id`),
  KEY `pcp_contest_votes_vote_index` (`vote`),
  KEY `pcp_contest_votes_updated_at_index` (`updated_at`),
  KEY `review_idx` (`section_id`,`juror_user_id`,`review_required`,`work_id`),
  KEY `pcp_contest_votes_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_contest_votes_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `pcp_contests` (`id`),
  CONSTRAINT `pcp_contest_votes_juror_user_id_foreign` FOREIGN KEY (`juror_user_id`) REFERENCES `pcp_user_contacts` (`user_id`),
  CONSTRAINT `pcp_contest_votes_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `pcp_contest_sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_waitings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_waitings` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contests.id 1:N ',
  `section_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contest_sections.id ',
  `work_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: works.id ',
  `participant_user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: users.id ',
  `portfolio_sequence` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'valid also in section counter',
  `organization_user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: users.id ',
  `because` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'why that work is out',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for notification',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `main_idx` (`contest_id`,`section_id`,`work_id`,`portfolio_sequence`,`deleted_at`),
  KEY `pcp_contest_waitings_work_id_index` (`work_id`),
  KEY `pcp_contest_waitings_deleted_at_index` (`deleted_at`),
  KEY `participant_idx` (`participant_user_id`),
  KEY `organization_idx` (`organization_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contest_works` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contests.id 1:N ',
  `section_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: contest_sections.id ',
  `country_id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: user_contacts.country_id ',
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: users.id ',
  `work_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: works.id ',
  `extension` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jpg' COMMENT 'to build file name',
  `portfolio_sequence` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'valid also in section counter',
  `is_admit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not admit, admit otherwise',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sequence_idx` (`user_id`,`contest_id`,`section_id`,`portfolio_sequence`,`work_id`,`deleted_at`),
  KEY `contest_idx` (`contest_id`,`section_id`,`country_id`,`user_id`,`work_id`,`id`),
  KEY `catalogue_idx` (`contest_id`,`country_id`,`user_id`,`section_id`,`work_id`,`id`),
  KEY `pcp_contest_works_country_id_foreign` (`country_id`),
  KEY `pcp_contest_works_section_id_foreign` (`section_id`),
  KEY `contest_works_idx` (`work_id`,`section_id`,`contest_id`),
  KEY `user_contests_idx` (`user_id`,`section_id`,`contest_id`,`portfolio_sequence`),
  KEY `admit_idx` (`section_id`,`is_admit`,`work_id`),
  KEY `pcp_contest_works_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_contest_works_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `pcp_contests` (`id`),
  CONSTRAINT `pcp_contest_works_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `pcp_countries` (`id`),
  CONSTRAINT `pcp_contest_works_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `pcp_contest_sections` (`id`),
  CONSTRAINT `pcp_contest_works_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `pcp_user_contacts` (`user_id`),
  CONSTRAINT `pcp_contest_works_work_id_foreign` FOREIGN KEY (`work_id`) REFERENCES `pcp_works` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contest_works_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_works_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_contest_works_view` AS SELECT 
 1 AS `contest_name`,
 1 AS `section_name`,
 1 AS `country_id`,
 1 AS `last_name`,
 1 AS `first_name`,
 1 AS `seq`,
 1 AS `title_en`,
 1 AS `reference_year`,
 1 AS `work_file`,
 1 AS `contest_id`,
 1 AS `section_id`,
 1 AS `user_id`,
 1 AS `work_id`,
 1 AS `contest_work_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_contests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contests` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `country_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: countries.id',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_local` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_local` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'dev: in LangList[]',
  `organization_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: organizations.id',
  `is_circuit` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N, N when not Y',
  `circuit_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'null or a valid contest.id',
  `federation_list` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'under patronage of federation code[]',
  `contest_mark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The contest or organization passport photo - mark',
  `contact_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'contest headquarter, email and so on',
  `award_ceremony_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Site and date, or link to broadcast platform',
  `fee_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'only text description of fee for participation',
  `vote_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'num:1..10' COMMENT 'related to limited set',
  `url_1_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'how read english rules and subscribe link',
  `url_2_concurrent_list` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_3_admit_n_award_list` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'only the result list, not a catalogue',
  `url_4_catalogue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'catalogue download page',
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A MUST HAVE used for time math, must be a php valid timezone',
  `day_1_opening` datetime NOT NULL COMMENT 'Reveal the contest, opening for subscription',
  `day_2_closing` datetime NOT NULL COMMENT 'End of receive works',
  `day_3_jury_opening` datetime NOT NULL COMMENT 'Start of juror works',
  `day_4_jury_closing` datetime NOT NULL COMMENT 'End of juror works',
  `day_5_revelations` datetime NOT NULL COMMENT 'Publicly result communications',
  `day_6_awards` datetime NOT NULL COMMENT 'Award Ceremony',
  `day_7_catalogues` datetime NOT NULL COMMENT 'Publicly Catalogue publications',
  `day_8_closing` datetime NOT NULL COMMENT 'Closing date for award postal send',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'backup reserved',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'backup reserved',
  `deleted_at` datetime DEFAULT NULL COMMENT 'softdelete reserved',
  PRIMARY KEY (`id`),
  KEY `general_idx` (`country_id`,`day_2_closing`,`name_en`,`created_at`),
  KEY `pcp_contests_country_id_index` (`country_id`),
  KEY `pcp_contests_name_en_index` (`name_en`),
  KEY `pcp_contests_name_local_index` (`name_local`),
  KEY `pcp_contests_organization_id_index` (`organization_id`),
  KEY `pcp_contests_circuit_id_index` (`circuit_id`),
  KEY `pcp_contests_day_6_awards_index` (`day_6_awards`),
  KEY `pcp_contests_vote_rule_foreign` (`vote_rule`),
  KEY `pcp_contests_timezone_foreign` (`timezone`),
  KEY `pcp_contests_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_contests_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `pcp_countries` (`id`),
  CONSTRAINT `pcp_contests_timezone_foreign` FOREIGN KEY (`timezone`) REFERENCES `pcp_timezones` (`id`),
  CONSTRAINT `pcp_contests_vote_rule_foreign` FOREIGN KEY (`vote_rule`) REFERENCES `pcp_contests_vote_rule_sets` (`vote_rule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_contests_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_contests_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_contests_view` AS SELECT 
 1 AS `contest_name`,
 1 AS `contest_local_name`,
 1 AS `day_2_closing`,
 1 AS `organization_name`,
 1 AS `first_name`,
 1 AS `last_name`,
 1 AS `role`,
 1 AS `contest_id`,
 1 AS `organization_id`,
 1 AS `user_id`,
 1 AS `user_role_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_contests_vote_rule_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_contests_vote_rule_sets` (
  `vote_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `synopsis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`vote_rule`),
  KEY `pcp_contests_vote_rule_sets_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_countries` (
  `id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'iso-3166 alpha-3 UPPERCASE',
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'en',
  `flag_code` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unicode chars for country flag emoji',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcp_countries_country_index` (`country`),
  KEY `pcp_countries_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pcp_failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_federation_mores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_federation_mores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `federation_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk federations',
  `field_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'lowercase',
  `field_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'label for the field',
  `field_validation_rules` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string|max:255' COMMENT 'string or function(), validation rules for the field, nullable if none',
  `field_default_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'empty string as default default value',
  `field_suggest` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'message to explain what insert',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alt_primary_idx` (`federation_id`,`field_name`),
  KEY `backup_idx` (`updated_at`),
  KEY `soft_delete_idx` (`deleted_at`),
  CONSTRAINT `pcp_federation_mores_federation_id_foreign` FOREIGN KEY (`federation_id`) REFERENCES `pcp_federations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_federation_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_federation_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `federation_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'official name in english',
  `local_lang` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'follow iso-3166 2 ascii lowercase',
  `name_local` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'in local name',
  `rule_definition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'synopsis from federal regulation docs',
  `file_formats` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jpg,tif,raw,raf,nef,cr2' COMMENT 'list of ext, comma separated',
  `min_works` int unsigned NOT NULL DEFAULT '0' COMMENT 'greater zero == portfolio',
  `max_works` int unsigned NOT NULL DEFAULT '4',
  `min_short_side` int unsigned NOT NULL DEFAULT '1080' COMMENT 'px',
  `max_long_side` int unsigned NOT NULL DEFAULT '2500' COMMENT 'px',
  `max_weight` int NOT NULL DEFAULT '6000000' COMMENT 'Bytes',
  `monochromatic_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 == false, 1 == true',
  `raw_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 == false, 1 == true',
  `only_one` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = only one prize per section per person not required',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pcp_federation_sections_federation_id_code_deleted_at_unique` (`federation_id`,`code`,`deleted_at`),
  KEY `pcp_federation_sections_name_en_index` (`name_en`),
  KEY `pcp_federation_sections_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_federation_sections_federation_id_foreign` FOREIGN KEY (`federation_id`) REFERENCES `pcp_federations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_federations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_federations` (
  `id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'when code are equals add :country_id to both',
  `country_id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'follow iso-3166 3 ascii uppercase',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'official name in english',
  `local_lang` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'follow iso-3166 2 ascii lowercase',
  `name_local` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timezone_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'reserved',
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'official website or fb info page',
  `contact_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'HQ address, email, and other infos',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_idx` (`country_id`,`id`),
  KEY `name_idx` (`country_id`,`name_en`),
  KEY `pcp_federations_name_en_index` (`name_en`),
  KEY `pcp_federations_timezone_id_foreign` (`timezone_id`),
  KEY `pcp_federations_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_federations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `pcp_countries` (`id`),
  CONSTRAINT `pcp_federations_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `pcp_timezones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pcp_jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_organizations` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid assigned',
  `country_id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Should became verified',
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'postal address',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pcp_organizations_email_deleted_at_unique` (`email`,`deleted_at`),
  KEY `pcp_organizations_country_id_name_deleted_at_index` (`country_id`,`name`,`deleted_at`),
  KEY `pcp_organizations_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_organizations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `pcp_countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_organizations_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_organizations_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_organizations_view` AS SELECT 
 1 AS `name`,
 1 AS `last_name`,
 1 AS `first_name`,
 1 AS `role`,
 1 AS `email`,
 1 AS `organization_id`,
 1 AS `user_role_id`,
 1 AS `user_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_regions` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'aux ',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcp_regions_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'uuid',
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pcp_sessions_user_id_index` (`user_id`),
  KEY `pcp_sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_timezones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_timezones` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'valid for php_timezones',
  `region_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk regions.id',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcp_timezones_region_id_index` (`region_id`),
  KEY `pcp_timezones_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_timezones_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `pcp_regions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_user_contact_mores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_user_contact_mores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_contact_user_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk for user_contact id',
  `federation_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk federations',
  `field_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk federation_mores',
  `field_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'following rules when updated',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alt_primary_idx` (`user_contact_user_id`,`federation_id`,`field_name`),
  KEY `backup_idx` (`updated_at`),
  KEY `soft_delete_idx` (`deleted_at`),
  KEY `pcp_user_contact_mores_federation_id_field_name_foreign` (`federation_id`,`field_name`),
  CONSTRAINT `pcp_user_contact_mores_federation_id_field_name_foreign` FOREIGN KEY (`federation_id`, `field_name`) REFERENCES `pcp_federation_mores` (`federation_id`, `field_name`),
  CONSTRAINT `pcp_user_contact_mores_federation_id_foreign` FOREIGN KEY (`federation_id`) REFERENCES `pcp_federations` (`id`),
  CONSTRAINT `pcp_user_contact_mores_user_contact_user_id_foreign` FOREIGN KEY (`user_contact_user_id`) REFERENCES `pcp_user_contacts` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_user_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_user_contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: users.id uuid',
  `country_id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: countries.id',
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'same as users.email',
  `cellular` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `passport_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anon.jpg',
  `lang_local` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'for future use - html lang',
  `timezone` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Europe/Rome' COMMENT 'for future use - php timezone for time math',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `address_line2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `region` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `postal_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal site',
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal page',
  `x_twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal page',
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal page',
  `whatsapp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'to chat into',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_idx` (`user_id`,`deleted_at`),
  KEY `pcp_user_contacts_first_name_index` (`first_name`),
  KEY `pcp_user_contacts_last_name_index` (`last_name`),
  KEY `pcp_user_contacts_timezone_foreign` (`timezone`),
  KEY `pcp_user_contacts_deleted_at_index` (`deleted_at`),
  KEY `country_name_idx` (`country_id`,`last_name`,`first_name`,`user_id`),
  CONSTRAINT `pcp_user_contacts_timezone_foreign` FOREIGN KEY (`timezone`) REFERENCES `pcp_timezones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`Sql1515403`@`localhost`*/ /*!50003 TRIGGER `update_user_email_on_contact_change` BEFORE UPDATE ON `pcp_user_contacts` FOR EACH ROW BEGIN
    IF OLD.email <> NEW.email THEN
        UPDATE `pcp_users`
        SET `email` = NEW.email
        WHERE `email` = OLD.email;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `pcp_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: users.id',
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `organization_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fk: organizations.id',
  `contest_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fk: contests.id',
  `federation_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fk to federations.id',
  `role_opening` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Start of role works - default today',
  `role_closing` datetime NOT NULL DEFAULT '9999-12-31 23:59:59' COMMENT 'End of role works default:future',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'backup reserved',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'backup reserved',
  `deleted_at` datetime DEFAULT NULL COMMENT 'softdelete reserved',
  PRIMARY KEY (`id`),
  KEY `general_idx` (`user_id`,`organization_id`,`contest_id`,`federation_id`,`role_opening`,`id`),
  KEY `pcp_user_roles_user_id_index` (`user_id`),
  KEY `pcp_user_roles_organization_id_index` (`organization_id`),
  KEY `pcp_user_roles_contest_id_index` (`contest_id`),
  KEY `pcp_user_roles_federation_id_index` (`federation_id`),
  KEY `pcp_user_roles_role_opening_index` (`role_opening`),
  KEY `pcp_user_roles_role_foreign` (`role`),
  KEY `pcp_user_roles_deleted_at_index` (`deleted_at`),
  CONSTRAINT `pcp_user_roles_role_foreign` FOREIGN KEY (`role`) REFERENCES `pcp_user_roles_role_sets` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_user_roles_role_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_user_roles_role_sets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pcp_user_roles_role_sets_status_deleted_at_unique` (`role`,`deleted_at`),
  KEY `pcp_user_roles_role_sets_status_index` (`role`),
  KEY `pcp_user_roles_role_sets_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_user_roles_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_user_roles_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_user_roles_view` AS SELECT 
 1 AS `id`,
 1 AS `uc_country_id`,
 1 AS `uc_last_name`,
 1 AS `uc_first_name`,
 1 AS `uc_email`,
 1 AS `uc_role`,
 1 AS `roled`,
 1 AS `uc_roled`,
 1 AS `uc_roled_id`,
 1 AS `ur_user_id`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `pcp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_users` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pcp_users_email_unique` (`email`),
  KEY `pcp_users_name_index` (`name`),
  KEY `pcp_users_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `user_contacts_ins_trigger` AFTER INSERT ON `pcp_users` FOR EACH ROW INSERT INTO `pcp_user_contacts` ( `user_id`, `first_name`, `last_name`, `email`    , `country_id` ) VALUES ( NEW.id,  NEW.name,   NEW.name,  NEW.email, '') */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `pcp_work_validations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_work_validations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `work_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: works.id ',
  `federation_section_id` bigint unsigned NOT NULL COMMENT 'fk: federation_sections.id ',
  `validator_user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: user_contacts.user_id ',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`work_id`,`federation_section_id`,`deleted_at`),
  KEY `pcp_work_validations_work_id_index` (`work_id`),
  KEY `pcp_work_validations_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pcp_works` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'uuid',
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'fk: users.id',
  `work_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'path n file',
  `extension` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'lowercase',
  `reference_year` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'default maybe YEAR(CURDATE())',
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english title',
  `title_local` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'lang title',
  `long_side` int unsigned NOT NULL COMMENT 'pixel / cm',
  `short_side` int unsigned NOT NULL COMMENT 'pixel / cm',
  `monochromatic` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'not bool but oldstyle uppercase | Y / N',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `general_idx` (`user_id`,`reference_year`,`title_en`),
  KEY `pcp_works_user_id_index` (`user_id`),
  KEY `pcp_works_deleted_at_index` (`deleted_at`),
  KEY `fifth_idx` (`user_id`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pcp_works_view`;
/*!50001 DROP VIEW IF EXISTS `pcp_works_view`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pcp_works_view` AS SELECT 
 1 AS `country_id`,
 1 AS `last_name`,
 1 AS `first_name`,
 1 AS `title_en`,
 1 AS `work_id`,
 1 AS `user_id`*/;
SET character_set_client = @saved_cs_client;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_juries_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_contest_juries_view` AS select `con`.`name_en` AS `contest_name_en`,`sec`.`name_en` AS `section_name_en`,`user`.`last_name` AS `juror_last_name`,`user`.`first_name` AS `juror_first_name`,`con`.`day_3_jury_opening` AS `day_jury_works_opening`,`con`.`day_4_jury_closing` AS `day_jury_works_closing`,`con`.`id` AS `contest_id`,`jur`.`section_id` AS `section_id`,`jur`.`id` AS `juror_id`,`jur`.`user_contact_id` AS `user_id` from (((`pcp_contest_juries` `jur` join `pcp_contest_sections` `sec`) join `pcp_contests` `con`) join `pcp_user_contacts` `user`) where ((`con`.`deleted_at` is null) and (`sec`.`deleted_at` is null) and (`jur`.`deleted_at` is null) and (`jur`.`section_id` = `sec`.`id`) and (`sec`.`contest_id` = `con`.`id`) and (`jur`.`user_contact_id` = `user`.`user_id`)) order by `con`.`day_3_jury_opening`,`con`.`name_en`,`sec`.`name_en`,`user`.`last_name`,`user`.`first_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_participants_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_contest_participants_view` AS select `con`.`name_en` AS `contest_name`,`usr`.`country_id` AS `country_id`,`usr`.`last_name` AS `last_name`,`usr`.`first_name` AS `first_name`,`par`.`fee_payment_completed` AS `fee_payment_completed`,`par`.`updated_at` AS `updated_at`,`par`.`user_id` AS `user_id`,`par`.`contest_id` AS `contest_id`,`par`.`id` AS `id` from ((`pcp_contest_participants` `par` join `pcp_contests` `con`) join `pcp_user_contacts` `usr`) where ((`par`.`contest_id` = `con`.`id`) and (`par`.`user_id` = `usr`.`user_id`) and (`par`.`deleted_at` is null) and (`con`.`deleted_at` is null) and (`usr`.`deleted_at` is null)) order by `con`.`name_en`,`usr`.`country_id`,`usr`.`last_name`,`usr`.`first_name`,`par`.`updated_at` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_vote_group1_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_contest_vote_group1_view` AS select count(0) AS `vote_count`,`c`.`name_en` AS `contest_name`,`cs`.`name_en` AS `section_name`,`cv`.`vote` AS `vote`,`cv`.`contest_id` AS `contest_id`,`cv`.`section_id` AS `section_id` from ((`pcp_contest_votes` `cv` join `pcp_contests` `c`) join `pcp_contest_sections` `cs`) where ((`c`.`id` = `cv`.`contest_id`) and (`cs`.`id` = `cv`.`section_id`)) group by `cv`.`contest_id`,`cv`.`section_id`,`cv`.`vote` order by `cv`.`contest_id`,`cv`.`section_id`,`cv`.`vote` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_vote_single_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_contest_vote_single_view` AS select `c`.`name_en` AS `contest_name`,`cs`.`code` AS `code`,`cs`.`name_en` AS `section_name`,`cv`.`vote` AS `vote`,`w`.`title_en` AS `title_en`,`w`.`work_file` AS `work_file`,`uc`.`country_id` AS `country_id`,`uc`.`last_name` AS `last_name`,`uc`.`first_name` AS `first_name`,`cv`.`contest_id` AS `contest_id`,`cv`.`section_id` AS `section_id`,`cv`.`work_id` AS `work_id`,`cv`.`juror_user_id` AS `juror_user_id`,`uc`.`user_id` AS `user_id` from ((((`pcp_contest_votes` `cv` join `pcp_contests` `c`) join `pcp_contest_sections` `cs`) join `pcp_works` `w`) join `pcp_user_contacts` `uc`) where ((`cv`.`contest_id` = `c`.`id`) and (`cv`.`section_id` = `cs`.`id`) and (`cv`.`work_id` = `w`.`id`) and (`w`.`user_id` = `uc`.`user_id`)) order by `c`.`name_en`,`cs`.`name_en`,`cv`.`vote` desc,`uc`.`country_id`,`uc`.`last_name`,`uc`.`first_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_contest_works_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_contest_works_view` AS select `c`.`name_en` AS `contest_name`,`s`.`name_en` AS `section_name`,`u`.`country_id` AS `country_id`,`u`.`last_name` AS `last_name`,`u`.`first_name` AS `first_name`,`cw`.`portfolio_sequence` AS `seq`,`w`.`title_en` AS `title_en`,`w`.`reference_year` AS `reference_year`,`w`.`work_file` AS `work_file`,`cw`.`contest_id` AS `contest_id`,`cw`.`section_id` AS `section_id`,`cw`.`user_id` AS `user_id`,`cw`.`work_id` AS `work_id`,`cw`.`id` AS `contest_work_id` from ((((`pcp_contest_works` `cw` join `pcp_contests` `c`) join `pcp_contest_sections` `s`) join `pcp_user_contacts` `u`) join `pcp_works` `w`) where ((`cw`.`contest_id` = `c`.`id`) and (`cw`.`section_id` = `s`.`id`) and (`cw`.`user_id` = `u`.`user_id`) and (`cw`.`work_id` = `w`.`id`) and (`cw`.`deleted_at` is null)) order by `c`.`name_en`,`s`.`name_en`,`u`.`country_id`,`u`.`last_name`,`u`.`first_name`,`cw`.`portfolio_sequence`,`w`.`title_en` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_contests_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_contests_view` AS select `con`.`name_en` AS `contest_name`,`con`.`name_local` AS `contest_local_name`,`con`.`day_2_closing` AS `day_2_closing`,`org`.`name` AS `organization_name`,`uco`.`first_name` AS `first_name`,`uco`.`last_name` AS `last_name`,`uro`.`role` AS `role`,`con`.`id` AS `contest_id`,`org`.`id` AS `organization_id`,`uco`.`user_id` AS `user_id`,`uro`.`id` AS `user_role_id` from (((`pcp_contests` `con` join `pcp_organizations` `org`) join `pcp_user_roles` `uro`) join `pcp_user_contacts` `uco`) where ((`con`.`deleted_at` is null) and (`con`.`organization_id` = `org`.`id`) and (`con`.`organization_id` = `uro`.`organization_id`) and (`uro`.`user_id` = `uco`.`user_id`)) order by `con`.`day_2_closing`,`uro`.`role`,`uco`.`last_name`,`uco`.`first_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_organizations_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_organizations_view` AS select `org`.`name` AS `name`,`usr`.`last_name` AS `last_name`,`usr`.`first_name` AS `first_name`,`rol`.`role` AS `role`,`usr`.`email` AS `email`,`org`.`id` AS `organization_id`,`rol`.`id` AS `user_role_id`,`usr`.`user_id` AS `user_id` from ((`pcp_organizations` `org` join `pcp_user_roles` `rol`) join `pcp_user_contacts` `usr`) where ((`org`.`deleted_at` is null) and (`usr`.`deleted_at` is null) and (`org`.`deleted_at` is null) and (`org`.`id` = `rol`.`organization_id`) and (`rol`.`user_id` = `usr`.`user_id`)) order by `org`.`name`,`usr`.`last_name`,`usr`.`first_name`,`rol`.`role` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_user_roles_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_user_roles_view` AS select `ur`.`id` AS `id`,`uc`.`country_id` AS `uc_country_id`,`uc`.`last_name` AS `uc_last_name`,`uc`.`first_name` AS `uc_first_name`,`uc`.`email` AS `uc_email`,`ur`.`role` AS `uc_role`,'org' AS `roled`,`org`.`name` AS `uc_roled`,`ur`.`organization_id` AS `uc_roled_id`,`ur`.`user_id` AS `ur_user_id` from ((`pcp_user_roles` `ur` join `pcp_user_contacts` `uc`) join `pcp_organizations` `org`) where ((`ur`.`user_id` = `uc`.`user_id`) and (`ur`.`organization_id` = `org`.`id`) and (`ur`.`deleted_at` is null) and (`ur`.`organization_id` is not null)) union select `ur`.`id` AS `id`,`uc`.`country_id` AS `uc_country_id`,`uc`.`last_name` AS `uc_last_name`,`uc`.`first_name` AS `uc_first_name`,`uc`.`email` AS `uc_email`,`ur`.`role` AS `uc_role`,'fed' AS `roled`,`fed`.`name_en` AS `uc_roled`,`ur`.`federation_id` AS `uc_roled_id`,`ur`.`user_id` AS `ur_user_id` from ((`pcp_user_roles` `ur` join `pcp_user_contacts` `uc`) join `pcp_federations` `fed`) where ((`ur`.`user_id` = `uc`.`user_id`) and (`ur`.`federation_id` = `fed`.`id`) and (`ur`.`deleted_at` is null) and (`ur`.`federation_id` is not null)) union select `ur`.`id` AS `id`,`uc`.`country_id` AS `uc_country_id`,`uc`.`last_name` AS `uc_last_name`,`uc`.`first_name` AS `uc_first_name`,`uc`.`email` AS `uc_email`,`ur`.`role` AS `uc_role`,'cnt' AS `roled`,`cnt`.`name_en` AS `uc_roled`,`ur`.`contest_id` AS `uc_roled_id`,`ur`.`user_id` AS `ur_user_id` from ((`pcp_user_roles` `ur` join `pcp_user_contacts` `uc`) join `pcp_contests` `cnt`) where ((`ur`.`user_id` = `uc`.`user_id`) and (`ur`.`contest_id` = `cnt`.`id`) and (`ur`.`deleted_at` is null) and (`ur`.`contest_id` is not null)) order by `uc_last_name`,`uc_first_name`,`uc_role`,`roled` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `pcp_works_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Sql1515403`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pcp_works_view` AS select `u`.`country_id` AS `country_id`,`u`.`last_name` AS `last_name`,`u`.`first_name` AS `first_name`,`w`.`title_en` AS `title_en`,`w`.`id` AS `work_id`,`w`.`user_id` AS `user_id` from (`pcp_works` `w` join `pcp_user_contacts` `u`) where (`u`.`user_id` = `w`.`user_id`) order by `u`.`country_id`,`u`.`last_name`,`u`.`first_name`,`w`.`title_en` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_08_23_110724_create_federations_table',2);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_08_25_175307_create_organizations_table',2);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (18,'2025_08_27_151410_add_contact_to_federations_table',3);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (19,'2025_08_27_153529_add_contact_to_organizations_table',3);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (20,'2025_08_27_154346_add_country_id_to_federations_table',3);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (21,'2025_08_27_171717_create_federation_sections_table',4);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (24,'2025_08_27_195232_create_federation_sections_table',5);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (25,'2025_08_28_074541_enlarge_code_in_federation_sections_table',6);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (26,'2025_08_28_094259_add_definition_in_federation_sections_table',7);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (27,'2025_08_28_115233_rename_definition_in_federation_sections_table',8);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (34,'2025_08_29_221755_create_countries_table',9);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_08_30_182334_rename_country_code_in_organizations_table',11);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (39,'0001_01_01_000000_create_users_table',12);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (42,'2025_08_30_074358_create_user_contacts_table',13);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_09_02_211727_create_works_table',14);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_09_03_151557_add_flag_to_countries_table',15);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (50,'2025_09_06_142809_add_lang_timezone_to_user_contacts_table',16);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (53,'2025_09_06_155712_create_contests_table',17);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (55,'2025_09_07_102811_add_local_lang_to_contests_table',19);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (57,'2025_09_10_151027_rename_lang_local_to_user_contacts_table',21);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (61,'2025_09_14_150105_create_contest_sections_table',22);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (62,'2025_09_17_120217_add_fee_column_to_contests_table',23);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (63,'2025_09_19_170924_create_user_roles_table',24);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (64,'2025_09_20_094129_enlarge_code_in_federations_table',25);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (67,'2025_09_23_185702_create_contest_juries_table',26);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (68,'2025_09_24_163557_modify_defaults_in_user_contacts_table',27);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (69,'2025_09_25_101235_create_contest_awards_table',28);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (72,'2025_10_01_213611_add_cols_to_federation_sections_table',29);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (73,'2025_10_01_215728_add_cols_to_contest_sections_table',30);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (75,'2025_10_02_081740_change_winner_name_col_in_contest_awards_table',32);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (77,'2025_10_09_114651_create_contest_works_table',34);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (80,'2025_10_09_192554_create_contest_participants_table',35);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (81,'2025_10_10_112237_create_user_roles_role_set',36);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (82,'2025_10_10_134025_add_relation_to_user_roles_table',37);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (83,'2025_10_10_144525_rename_user_roles_role_set_table',38);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (85,'2025_10_12_133101_create_user_roles_views_table',39);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (88,'2025_10_14_152811_create_contest_participants_views_table',40);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (89,'2025_10_14_171110_create_user_works_views_table',41);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (90,'2025_10_14_181032_create_works_in_contest_views_table',42);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (101,'2025_10_15_152428_change_default_in_user_contacts_table',43);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (102,'2025_10_16_102443_create_federations_table',43);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (104,'2025_10_16_153034_change_federation_id_col_in_user_roles_table',44);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (105,'2025_10_16_155134_recreate_user_roles_views_table',45);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (107,'2025_10_17_113859_recreate_federation_sections_table',46);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (108,'2025_10_17_183644_create_trigger_for_users_table',47);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (109,'2025_10_17_184535_change_idx_in_user_contacts_table',48);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (111,'2025_10_17_190655_change_idx_in_users_table',49);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (112,'2025_10_18_120254_change_idx_in_organizations_table',49);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (113,'2025_10_18_133918_create_user_role_role_sets_table',50);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (114,'2025_10_18_140350_create_user_role_role_sets_table',51);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (115,'2025_10_18_144043_add_relation_to_user_roles_table',52);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (118,'2025_10_18_184303_create_contests_views_table',53);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (122,'2025_10_18_190732_create_organizations_views_table',54);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (123,'2025_10_18_192819_create_contest_participants_views_table',55);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (124,'2025_10_20_152559_create_contest_juries_views_table',56);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (127,'2025_10_21_155424_add_col_to_contest_works_table',57);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (128,'2025_10_21_163757_add_idx_in_contest_works_table',58);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (129,'2025_10_22_094245_create_contests_vote_rule_sets',59);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (130,'2025_10_22_101746_add_relation_to_contests_table',60);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (131,'2025_10_24_064847_create_contest_waitings_table',61);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (134,'2025_10_25_185236_create_work_validations_table',62);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (135,'2025_10_26_101606_add_col_to_contest_sections_table',63);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (137,'2025_10_26_114704_add_relation_to_contest_works_table',64);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (138,'2025_10_26_150245_add_idx_to_work_validations_table',65);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (140,'2025_10_26_205548_add_col_to_contest_waitings_table',66);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (141,'2025_10_28_092907_recreate_contest_juries_views_table',67);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (142,'2025_10_29_143023_add_col_to_contest_works_table',68);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (145,'2025_10_29_153514_create_contest_votes_table',69);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (146,'2025_11_05_210020_add_idx_to_contest_waitings_table',70);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (147,'2025_11_07_150026_add_idx_on_contest_works_table',71);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (148,'2025_11_13_191452_create_contest_vote_views_table',72);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (152,'2025_11_17_182949_create_contest_vote_single_views',73);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (153,'2025_11_21_162254_add_relation_on_contests_table',74);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (154,'2025_11_21_163103_add_relation_on_organizations_table',75);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (156,'2025_11_24_141934_create_regions_table',76);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (158,'2025_11_24_143000_create_timezones_table',77);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (159,'2025_11_24_173031_add_relation_to_contests_table',78);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (160,'2025_11_24_173548_add_relation_to_user_contacts_table',79);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (161,'2025_11_24_174116_add_relation_to_federations_table',80);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (164,'2025_11_25_112809_add_col_to_contest_votes_table',81);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (165,'2025_11_28_141610_mod_cols_in_contest_works_table',82);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (166,'2025_11_29_001230_add_col_to_federation_sections_table',83);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (167,'2025_11_29_002922_add_col_to_contest_sections_table',84);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (168,'2025_12_04_105524_add_idx_to_contest_sections_table',85);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (169,'2025_12_04_105850_mod_cols_in_contest_sections_table',86);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (170,'2025_12_04_163758_add_relation_to_contest_sections_table',87);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (171,'2025_12_04_164339_add_relation_to_contest_awards_table',88);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (172,'2025_12_04_164458_add_relation_to_contest_juries_table',89);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (173,'2025_12_04_164655_add_relation_to_contest_participants_table',90);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (174,'2025_12_04_165642_add_relation_to_contest_votes_table',91);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (176,'2025_12_08_104346_add_idx_to_contest_awards_table',92);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (177,'2025_12_08_110447_add_idx_to_users_table',92);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (178,'2025_12_08_110829_add_idx_to_user_contacts_table',93);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (179,'2025_12_08_111514_add_idx_to_user_roles_table',94);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (180,'2025_12_08_111644_add_idx_to_user_roles_role_sets_table',95);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (181,'2025_12_08_111754_add_idx_to_work_validations_table',96);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (182,'2025_12_08_111901_add_idx_to_works_table',97);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (183,'2025_12_08_111956_add_idx_to_contest_juries_table',98);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (184,'2025_12_08_112121_add_idx_to_contest_participants_table',99);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (185,'2025_12_08_112246_add_idx_to_contest_sections_table',100);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (186,'2025_12_08_112513_add_idx_to_contest_votes_table',101);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (187,'2025_12_08_112617_add_idx_to_contest_waitings_table',102);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (188,'2025_12_08_112715_add_idx_to_contest_works_table',103);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (189,'2025_12_08_112807_add_idx_to_contests_table',104);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (190,'2025_12_08_112944_add_idx_to_contests_vote_rule_sets_table',105);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (191,'2025_12_08_113104_add_idx_to_countries_table',106);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (192,'2025_12_08_113249_add_idx_to_federation_sections_table',107);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (193,'2025_12_08_113334_add_idx_to_federations_table',108);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (194,'2025_12_08_113433_add_idx_to_organizations_table',109);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (195,'2025_12_08_113533_add_idx_to_regions_table',110);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (196,'2025_12_08_113617_add_idx_to_timezones_table',111);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (198,'2025_12_12_160530_add_idx_fifth_to_works_table',112);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (202,'2025_12_26_174057_create_federation_additional_field_names_table',113);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (203,'2025_12_26_185529_create_federation_additionals_table',114);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (204,'2025_12_26_193012_add_idx_to_federation_additional_field_names_table',115);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (205,'2025_12_28_134139_add_trigger_to_user_contacts_table',116);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (206,'2025_12_29_140820_add_col_to_federation_additional_field_names_table',117);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (207,'2026_01_01_165513_remove_federation_additionals_table',118);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (208,'2026_01_01_165532_remove_federation_additionals_field_names_table',118);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (214,'2026_01_01_171622_create_federation_mores_table',119);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (215,'2026_01_01_174854_create_user_contact_mores_table',119);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (217,'2026_01_12_211855_add_idx_to_contest_awards_table',120);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (219,'2026_01_17_193728_add_idx_to_user_contacts_table',121);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (220,'2026_01_20_185836_mod_idx_in_users_table',122);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (222,'2026_01_22_095610_add_idx_to_contest_awards_table',123);
INSERT INTO `pcp_migrations` (`id`, `migration`, `batch`) VALUES (223,'2026_01_22_131802_add_idx_to_contest_waitings_table',124);
