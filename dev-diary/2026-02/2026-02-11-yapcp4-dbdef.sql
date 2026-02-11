-- MySQL dump 10.13  Distrib 8.0.40, for macos14 (arm64)
--
-- Host: localhost    Database: Sql1515403_3
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_awards`
--

DROP TABLE IF EXISTS `contest_awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_awards` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'real pk si contest_id + award_code',
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contests.id contest_sections.contest_id',
  `section_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL COMMENT 'fk: contest_sections.id',
  `section_code` varchar(10) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL COMMENT 'from: section.id->code | null for contest/circuit',
  `award_code` varchar(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'mut be unique in contest',
  `award_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'free',
  `is_award` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'true - award/award prize, false - HM or other',
  `winner_work_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `winner_user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `winner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'winner not in previous cols',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`contest_id`,`award_code`),
  KEY `secondary_idx` (`contest_id`,`section_code`,`award_code`),
  KEY `sixth_idx` (`winner_work_id`,`section_id`,`contest_id`),
  KEY `view_idx` (`contest_id`,`section_id`,`award_code`,`winner_work_id`,`winner_user_id`,`winner_name`),
  KEY `contest_awards_contest_id_index` (`contest_id`),
  KEY `contest_awards_section_id_index` (`section_id`),
  KEY `contest_awards_section_code_index` (`section_code`),
  KEY `contest_awards_award_code_index` (`award_code`),
  KEY `winner_work_id_idx` (`winner_work_id`),
  KEY `winner_user_id_idx` (`winner_user_id`),
  KEY `contest_awards_updated_at_index` (`updated_at`),
  KEY `contest_awards_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_awards_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_awards_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `contest_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contest:award list for every section and for contest/circuit';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_juries`
--

DROP TABLE IF EXISTS `contest_juries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_juries` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'reak pk section_id + juror user_id',
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contests.id',
  `section_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contest_sections.id',
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_contacts.id - juror',
  `is_president` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'used to put first in juror list',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`section_id`,`user_id`),
  KEY `contest_juries_contest_id_index` (`contest_id`),
  KEY `contest_juries_section_id_index` (`section_id`),
  KEY `contest_juries_user_id_index` (`user_id`),
  KEY `contest_juries_updated_at_index` (`updated_at`),
  KEY `contest_juries_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_juries_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_juries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_section_fk` FOREIGN KEY (`section_id`) REFERENCES `contest_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='juror contest section list';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_participants`
--

DROP TABLE IF EXISTS `contest_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `fee_payment_completed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'reserved for contest organization members',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contest_idx` (`contest_id`,`user_id`),
  KEY `user_idx` (`user_id`,`contest_id`),
  KEY `contest_participants_contest_id_index` (`contest_id`),
  KEY `contest_participants_user_id_index` (`user_id`),
  KEY `contest_participants_fee_payment_completed_index` (`fee_payment_completed`),
  KEY `contest_participants_updated_at_index` (`updated_at`),
  KEY `contest_participants_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_participants_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_contacts` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Participant list w/fee semaphore';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_sections`
--

DROP TABLE IF EXISTS `contest_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_sections` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'real pk contest_id n code',
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contests.id',
  `code` varchar(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: federationSections.code but also not',
  `under_patronage` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'section-theme valid for federation',
  `federation_section_id` bigint unsigned DEFAULT NULL COMMENT 'fk: federation_sections.id',
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'international',
  `name_local` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'in local lang - see contests.lang_local',
  `rule_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jpg' COMMENT 'list of permitted extension',
  `rule_min` int unsigned NOT NULL DEFAULT '0' COMMENT 'minimum works-per-section',
  `rule_max` int unsigned NOT NULL DEFAULT '4' COMMENT 'maximum works-per-section',
  `rule_min_size` int unsigned NOT NULL DEFAULT '1024' COMMENT 'minimum short_side px',
  `rule_max_size` int unsigned NOT NULL DEFAULT '2500' COMMENT 'maximum long_side px',
  `rule_max_weight` int unsigned NOT NULL DEFAULT '6000' COMMENT 'file weight in KB',
  `rule_monochromatic` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'BW / M only',
  `rule_raw_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'RAW required',
  `rule_only_one` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'unique award per person per section-theme',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`contest_id`,`code`),
  KEY `name_idx` (`contest_id`,`name_en`,`deleted_at`),
  KEY `contest_sections_federation_section_id_foreign` (`federation_section_id`),
  KEY `contest_sections_contest_id_index` (`contest_id`),
  KEY `contest_sections_code_index` (`code`),
  KEY `contest_sections_updated_at_index` (`updated_at`),
  KEY `contest_sections_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_sections_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_sections_federation_section_id_foreign` FOREIGN KEY (`federation_section_id`) REFERENCES `federation_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_votes`
--

DROP TABLE IF EXISTS `contest_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'real pk: section_id + work_id + juror_id',
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contests.id contest_sections.contest_id',
  `section_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contest_sections.id',
  `work_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contest_works.work_id user_works.id',
  `juror_user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_contacts.id juror',
  `vote` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'based on contests.vote_rule',
  `review_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'false - not required',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date of vote',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`contest_id`,`section_id`,`work_id`,`juror_user_id`),
  KEY `review_idx` (`section_id`,`juror_user_id`,`review_required`,`work_id`),
  KEY `vote_idx` (`contest_id`,`section_id`,`vote`,`work_id`,`juror_user_id`),
  KEY `contest_votes_contest_id_index` (`contest_id`),
  KEY `contest_votes_section_id_index` (`section_id`),
  KEY `contest_votes_work_id_index` (`work_id`),
  KEY `contest_votes_juror_user_id_index` (`juror_user_id`),
  KEY `contest_votes_vote_index` (`vote`),
  KEY `contest_votes_updated_at_index` (`updated_at`),
  KEY `contest_votes_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_votes_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_votes_juror_user_id_foreign` FOREIGN KEY (`juror_user_id`) REFERENCES `user_contacts` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_votes_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `contest_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_votes_work_id_foreign` FOREIGN KEY (`work_id`) REFERENCES `contest_works` (`work_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The juror vote board';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_waitings`
--

DROP TABLE IF EXISTS `contest_waitings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_waitings` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'real pk: contest_work_id',
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contests.id',
  `section_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contest_sections.id',
  `user_work_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_works.id',
  `portfolio_sequence` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'to ripristinate original record',
  `participant_user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_contacts.id author',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for notification',
  `organization_user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_works.id organization member',
  `because` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'why that work is out',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `general_idx` (`contest_id`,`section_id`,`user_work_id`,`portfolio_sequence`,`deleted_at`),
  KEY `contest_waitings_contest_id_index` (`contest_id`),
  KEY `contest_waitings_section_id_index` (`section_id`),
  KEY `contest_waitings_user_work_id_index` (`user_work_id`),
  KEY `contest_waitings_participant_user_id_index` (`participant_user_id`),
  KEY `organization_idx` (`organization_user_id`),
  KEY `contest_waitings_updated_at_index` (`updated_at`),
  KEY `contest_waitings_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_waitings_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_waitings_organization_user_id_foreign` FOREIGN KEY (`organization_user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_waitings_participant_user_id_foreign` FOREIGN KEY (`participant_user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_waitings_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `contest_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_waitings_user_work_id_foreign` FOREIGN KEY (`user_work_id`) REFERENCES `user_works` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Parking table for user_works with any problem';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contest_works`
--

DROP TABLE IF EXISTS `contest_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contest_works` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contests.id',
  `section_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: contest_sections.id',
  `country_id` char(3) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: countries.id ',
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk:user_contacts.id author',
  `work_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_works.id',
  `extension` varchar(6) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'jpg' COMMENT 'used to build file name',
  `portfolio_sequence` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'sequence also for portfolio',
  `is_admit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not admit, admit otherwise',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sequence_idx` (`user_id`,`contest_id`,`section_id`,`portfolio_sequence`,`work_id`,`deleted_at`),
  KEY `admit_idx` (`section_id`,`is_admit`,`work_id`),
  KEY `catalogue_idx` (`contest_id`,`country_id`,`user_id`,`section_id`,`work_id`,`id`),
  KEY `contest_idx` (`contest_id`,`section_id`,`country_id`,`user_id`,`work_id`,`id`),
  KEY `contest_works_idx` (`work_id`,`section_id`,`contest_id`),
  KEY `user_contests_idx` (`user_id`,`section_id`,`contest_id`,`portfolio_sequence`),
  KEY `contest_works_contest_id_index` (`contest_id`),
  KEY `contest_works_section_id_index` (`section_id`),
  KEY `contest_works_country_id_index` (`country_id`),
  KEY `contest_works_user_id_index` (`user_id`),
  KEY `contest_works_work_id_index` (`work_id`),
  KEY `contest_works_updated_at_index` (`updated_at`),
  KEY `contest_works_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contest_works_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_works_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_works_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `contest_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contest_works_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contests`
--

DROP TABLE IF EXISTS `contests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contests` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `country_id` char(3) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: countries.id',
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_local` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_local` varchar(5) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'en' COMMENT 'dev: in LangList[]',
  `organization_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: organizations.id',
  `is_circuit` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N, N when not Y',
  `circuit_id` varchar(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL COMMENT 'null or a valid contest.id',
  `federation_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'under patronage of federation code[]',
  `contest_mark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The contest or organization passport photo - mark',
  `contact_info` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'contest headquarter, email and so on',
  `award_ceremony_info` text COLLATE utf8mb4_unicode_ci COMMENT 'Site and date, or link to broadcast platform',
  `fee_info` text COLLATE utf8mb4_unicode_ci COMMENT 'only text description of fee for participation',
  `vote_rule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'num:1..10' COMMENT 'fk: contests_vote_rule_sets.vote_rule',
  `url_1_rule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'how read english rules and subscribe link',
  `url_2_concurrent_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_3_admit_n_award_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'only the result list, not a catalogue',
  `url_4_catalogue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'catalogue download page',
  `timezone_id` varchar(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: timezones.id',
  `day_1_opening` datetime NOT NULL COMMENT 'T1 Reveal the contest, opening for subscription',
  `day_2_closing` datetime NOT NULL COMMENT 'T2 >= T1 End of receive works',
  `day_3_jury_opening` datetime NOT NULL COMMENT 'T3 > T2 Start of juror works',
  `day_4_jury_closing` datetime NOT NULL COMMENT 'T4 >= T3 End of juror works',
  `day_5_revelations` datetime NOT NULL COMMENT 'T5 > T4 Publicly result communications',
  `day_6_awards` datetime NOT NULL COMMENT 'T6 > T5 Award Ceremony',
  `day_7_catalogues` datetime NOT NULL COMMENT 'T7 > T6 Publicly Catalogue publications',
  `day_8_closing` datetime NOT NULL COMMENT 'T8 > T7 Closing date for award postal send',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `general_idx` (`country_id`,`day_2_closing`,`name_en`,`created_at`),
  KEY `contests_country_id_index` (`country_id`),
  KEY `contests_name_en_index` (`name_en`),
  KEY `contests_name_local_index` (`name_local`),
  KEY `contests_organization_id_index` (`organization_id`),
  KEY `contests_circuit_id_index` (`circuit_id`),
  KEY `vote_rule_idx` (`vote_rule`),
  KEY `timezone_idx` (`timezone_id`),
  KEY `contests_day_6_awards_index` (`day_6_awards`),
  KEY `contests_updated_at_index` (`updated_at`),
  KEY `contests_deleted_at_index` (`deleted_at`),
  CONSTRAINT `contests_circuit_id_foreign` FOREIGN KEY (`circuit_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contests_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contests_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contests_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contests_vote_rule_foreign` FOREIGN KEY (`vote_rule`) REFERENCES `contests_vote_rule_sets` (`vote_rule`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contests_vote_rule_sets`
--

DROP TABLE IF EXISTS `contests_vote_rule_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contests_vote_rule_sets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vote_rule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `synopsis` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contests_vote_rule_sets_vote_rule_unique` (`vote_rule`),
  KEY `contests_vote_rule_sets_updated_at_index` (`updated_at`),
  KEY `contests_vote_rule_sets_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` char(3) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'iso-3166 alpha-3 uppercase',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english official',
  `flag_code` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unicode chars for country flag emoji',
  `lang_code` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'when used in lang=xx_YY',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countries_country_index` (`country`),
  KEY `countries_lang_code_index` (`lang_code`),
  KEY `countries_updated_at_index` (`updated_at`),
  KEY `countries_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='based on iso-3166, but hand filled';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `federation_mores`
--

DROP TABLE IF EXISTS `federation_mores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `federation_mores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'the real pk is federation_id + field_name',
  `federation_id` varchar(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk federations.id',
  `field_name` varchar(20) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'lowercase',
  `field_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'label for the field',
  `field_validation_rules` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string|max:255' COMMENT 'string or function(), validation rules for the field, nullable if none',
  `field_default_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'empty string as default default value',
  `field_suggest` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'message to explain what insert',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alt_primary_idx` (`federation_id`,`field_name`),
  KEY `federation_mores_updated_at_index` (`updated_at`),
  KEY `federation_mores_deleted_at_index` (`deleted_at`),
  CONSTRAINT `federation_mores_federation_id_foreign` FOREIGN KEY (`federation_id`) REFERENCES `federations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `federation_sections`
--

DROP TABLE IF EXISTS `federation_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `federation_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'real pk is federation_id + code',
  `federation_id` char(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `code` char(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'official name in english',
  `local_lang` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'follow iso-3166 2 ascii lowercase',
  `name_local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'in local name',
  `rule_definition` text COLLATE utf8mb4_unicode_ci COMMENT 'synopsis from federal regulation docs',
  `file_formats` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jpg,tif,raw,raf,nef,cr2' COMMENT 'list of ext, comma separated',
  `min_works` int unsigned NOT NULL DEFAULT '0' COMMENT 'greater zero == portfolio',
  `max_works` int unsigned NOT NULL DEFAULT '4',
  `min_short_side` int unsigned NOT NULL DEFAULT '1080' COMMENT 'px',
  `max_long_side` int unsigned NOT NULL DEFAULT '2500' COMMENT 'px',
  `max_weight` int NOT NULL DEFAULT '6000000' COMMENT 'Bytes',
  `monochromatic_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 == false, 1 == true',
  `raw_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'section require raw original works (not only)',
  `only_one` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'required only one prize / author n section',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`federation_id`,`code`),
  KEY `federation_sections_federation_id_index` (`federation_id`),
  KEY `federation_sections_code_index` (`code`),
  KEY `federation_sections_name_en_index` (`name_en`),
  KEY `federation_sections_updated_at_index` (`updated_at`),
  KEY `federation_sections_deleted_at_index` (`deleted_at`),
  CONSTRAINT `federation_sections_federation_id_foreign` FOREIGN KEY (`federation_id`) REFERENCES `federations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `federations`
--

DROP TABLE IF EXISTS `federations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `federations` (
  `id` char(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'UPPER, when code are equals add :country_id to both',
  `country_id` char(3) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk countries.id',
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'official name in english',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'official website or fb info page',
  `local_lang` char(5) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'en' COMMENT 'follow iso-3166 2 ascii lowercase',
  `name_local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'when differ from official english',
  `timezone_id` varchar(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT '' COMMENT 'HQ address',
  `contact_info` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'HQ address, email, and other infos',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_idx` (`country_id`,`id`),
  KEY `name_idx` (`country_id`,`name_en`),
  KEY `federations_name_en_index` (`name_en`),
  KEY `pcp_federations_timezone_id_foreign` (`timezone_id`),
  KEY `federations_updated_at_index` (`updated_at`),
  KEY `federations_deleted_at_index` (`deleted_at`),
  CONSTRAINT `federations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `federations_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Who build the contest rules for patronages';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizations` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `country_id` char(3) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: countries.id - hq country',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english official',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'official organization website',
  `contact` text COLLATE utf8mb4_unicode_ci COMMENT 'hq postal address',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizations_email_unique` (`email`),
  KEY `country_name_idx` (`country_id`,`name`),
  KEY `organizations_country_id_index` (`country_id`),
  KEY `organizations_name_index` (`name`),
  KEY `organizations_updated_at_index` (`updated_at`),
  KEY `organizations_deleted_at_index` (`deleted_at`),
  CONSTRAINT `organizations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='who organize contests';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='user reserved';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regions` (
  `id` char(12) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regions_updated_at_index` (`updated_at`),
  KEY `regions_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='timezones lookup table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `timezones`
--

DROP TABLE IF EXISTS `timezones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timezones` (
  `id` varchar(40) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'valid for php_timezones',
  `region_id` char(12) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk regions.id',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timezones_region_id_index` (`region_id`),
  KEY `timezones_updated_at_index` (`updated_at`),
  KEY `timezones_deleted_at_index` (`deleted_at`),
  CONSTRAINT `timezones_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='deadline time management must have';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_contact_mores`
--

DROP TABLE IF EXISTS `user_contact_mores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_contact_mores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'real pk is user_contact_id n federation_id n field_name',
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk for user_contact id',
  `federation_id` varchar(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk federation_mores',
  `field_name` varchar(20) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk federation_mores',
  `field_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'following rules when updated',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alt_primary_idx` (`user_id`,`federation_id`,`field_name`),
  KEY `federation_idx` (`federation_id`,`field_name`),
  KEY `user_contact_mores_updated_at_index` (`updated_at`),
  KEY `user_contact_mores_deleted_at_index` (`deleted_at`),
  CONSTRAINT `user_contact_mores_federation_id_field_name_foreign` FOREIGN KEY (`federation_id`, `field_name`) REFERENCES `federation_mores` (`federation_id`, `field_name`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_contact_mores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='additional values for user_contacts based on federation_mores';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_contacts`
--

DROP TABLE IF EXISTS `user_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_contacts` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'aligned to users.id',
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk users.id',
  `country_id` char(3) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: countries.id',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'alias, aka',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'aligned to users.email',
  `cellular` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'country code prefixed',
  `passport_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anon.jpg' COMMENT 'as rounded avatars',
  `lang_local` char(5) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'en' COMMENT 'xx_YY - for future use in html lang',
  `timezone_id` varchar(40) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'Europe/Rome' COMMENT 'fk: timezones.id',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'in latin char',
  `address_line2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'not timezone region',
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal site',
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal page',
  `x_twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal page',
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url of personal page',
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url to chat into',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_contacts_email_unique` (`email`),
  KEY `country_name_idx` (`country_id`,`last_name`,`first_name`,`user_id`),
  KEY `user_contacts_user_id_foreign` (`user_id`),
  KEY `user_contacts_first_name_index` (`first_name`),
  KEY `user_contacts_last_name_index` (`last_name`),
  KEY `user_contacts_nick_name_index` (`nick_name`),
  KEY `user_contacts_timezone_id_index` (`timezone_id`),
  KEY `user_contacts_updated_at_index` (`updated_at`),
  KEY `user_contacts_deleted_at_index` (`deleted_at`),
  CONSTRAINT `user_contacts_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_contacts_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `user_contacts_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='the real users info table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_contacts.id',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member' COMMENT 'fk: user_roles_role_sets.role',
  `organization_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL COMMENT 'fk: organizations.id',
  `contest_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL COMMENT 'fk: contests.id',
  `federation_id` char(10) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL COMMENT 'fk: federations.id',
  `role_opening` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Start of role works - default: today',
  `role_closing` datetime NOT NULL DEFAULT '9999-12-31 23:59:59' COMMENT 'End of role works default:future',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `general_idx` (`user_id`,`organization_id`,`contest_id`,`federation_id`,`role_opening`,`id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `role_idx` (`role`),
  KEY `user_roles_organization_id_index` (`organization_id`),
  KEY `user_roles_contest_id_index` (`contest_id`),
  KEY `user_roles_federation_id_index` (`federation_id`),
  KEY `user_roles_role_opening_index` (`role_opening`),
  KEY `user_roles_updated_at_index` (`updated_at`),
  KEY `user_roles_deleted_at_index` (`deleted_at`),
  CONSTRAINT `user_roles_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_roles_federation_id_foreign` FOREIGN KEY (`federation_id`) REFERENCES `federations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_roles_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_roles_role_foreign` FOREIGN KEY (`role`) REFERENCES `user_roles_role_sets` (`role`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_roles_context_sets`
--

DROP TABLE IF EXISTS `user_roles_context_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles_context_sets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `context_type` char(10) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'the real pk',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `context_type_idx` (`context_type`),
  KEY `user_roles_context_sets_updated_at_index` (`updated_at`),
  KEY `user_roles_context_sets_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='lookup table for: user_roles.context_type';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_roles_role_sets`
--

DROP TABLE IF EXISTS `user_roles_role_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles_role_sets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'the real pk',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_idx` (`role`),
  KEY `user_roles_role_sets_updated_at_index` (`updated_at`),
  KEY `user_roles_role_sets_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='lookup table for: user_roles.role';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_work_validations`
--

DROP TABLE IF EXISTS `user_work_validations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_work_validations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'real pk is: work_id + federation_section_id',
  `work_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'fk: user_works.id',
  `federation_section_id` bigint unsigned NOT NULL COMMENT 'fk: federation_sections.id ',
  `validator_user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'contest organization members that validate the work for specific section',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_idx` (`work_id`,`federation_section_id`,`deleted_at`),
  KEY `user_work_validations_work_id_index` (`work_id`),
  KEY `user_work_validations_federation_section_id_index` (`federation_section_id`),
  KEY `user_work_validations_validator_user_id_index` (`validator_user_id`),
  KEY `user_work_validations_updated_at_index` (`updated_at`),
  KEY `user_work_validations_deleted_at_index` (`deleted_at`),
  CONSTRAINT `user_work_validations_federation_section_id_foreign` FOREIGN KEY (`federation_section_id`) REFERENCES `federation_sections` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_work_validations_validator_user_id_foreign` FOREIGN KEY (`validator_user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_work_validations_work_id_foreign` FOREIGN KEY (`work_id`) REFERENCES `user_works` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='human check for user_works on federation_sections';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_works`
--

DROP TABLE IF EXISTS `user_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_works` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `user_id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `work_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'path n filename internal',
  `extension` char(6) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT '',
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english title',
  `title_local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'lang title',
  `long_side` int unsigned NOT NULL COMMENT 'pixel',
  `short_side` int unsigned NOT NULL COMMENT 'pixel',
  `monochromatic` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'declared BW monochromatic',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_works_work_file_unique` (`work_file`),
  KEY `user_works_user_id_index` (`user_id`),
  KEY `user_works_extension_index` (`extension`),
  KEY `user_works_updated_at_index` (`updated_at`),
  KEY `user_works_deleted_at_index` (`deleted_at`),
  CONSTRAINT `user_works_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'lowercase uuid',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'surname, name - not used for access',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_name_index` (`name`),
  KEY `users_updated_at_index` (`updated_at`),
  KEY `users_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='for platform access only - other user info un user_contacts';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-11 11:37:46
