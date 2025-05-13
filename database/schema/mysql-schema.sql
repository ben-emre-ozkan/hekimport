/*M!999999\- enable the sandbox mode */ 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `appointment_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vitrin_id` bigint(20) unsigned NOT NULL,
  `patient_name` varchar(191) NOT NULL,
  `patient_phone` varchar(191) NOT NULL,
  `requested_slot` varchar(191) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_requests_vitrin_id_foreign` (`vitrin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_service_id_foreign` (`service_id`),
  KEY `appointments_date_index` (`date`),
  KEY `appointments_status_index` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `doctor_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `bio` text DEFAULT NULL,
  `education` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`education`)),
  `experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`experience`)),
  `certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certifications`)),
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`languages`)),
  `working_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`working_hours`)),
  `address` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `website` varchar(191) DEFAULT NULL,
  `social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_media`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_profiles_doctor_id_foreign` (`doctor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `specialty` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `profile_image` varchar(191) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `feedback_suggestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback_suggestions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'feature_request',
  `priority` varchar(191) NOT NULL DEFAULT 'medium',
  `module` varchar(191) NOT NULL DEFAULT 'klinigim',
  `status` varchar(191) NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_suggestions_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `forum_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forum_categories_slug_unique` (`slug`),
  KEY `forum_categories_slug_index` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `forum_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_messages_topic_id_index` (`topic_id`),
  KEY `forum_messages_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `forum_topic_user_reads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_topic_user_reads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `topic_id` bigint(20) unsigned NOT NULL,
  `last_read_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forum_topic_user_reads_user_id_topic_id_unique` (`user_id`,`topic_id`),
  KEY `forum_topic_user_reads_user_id_index` (`user_id`),
  KEY `forum_topic_user_reads_topic_id_index` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `forum_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_topics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forum_topics_slug_unique` (`slug`),
  KEY `forum_topics_category_id_index` (`category_id`),
  KEY `forum_topics_user_id_index` (`user_id`),
  KEY `forum_topics_slug_index` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) DEFAULT NULL,
  `disk` varchar(191) NOT NULL,
  `conversions_disk` varchar(191) DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `module` varchar(191) NOT NULL DEFAULT 'klinigim',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`),
  KEY `newsletter_subscribers_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`notes`)),
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patients_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `profile_visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `profile_visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vitrin_id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `referrer` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_visits_vitrin_id_foreign` (`vitrin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `seo_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `seo_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `vitrin_id` bigint(20) unsigned DEFAULT NULL,
  `url` varchar(191) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `issues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`issues`)),
  `recommendations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`recommendations`)),
  `last_scanned_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','in_progress','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seo_reports_user_id_foreign` (`user_id`),
  KEY `seo_reports_vitrin_id_foreign` (`vitrin_id`),
  KEY `seo_reports_url_index` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vitrin_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_vitrin_id_foreign` (`vitrin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sms_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vitrin_id` bigint(20) unsigned NOT NULL,
  `phone` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sms_logs_vitrin_id_sent_at_index` (`vitrin_id`,`sent_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `university` varchar(191) NOT NULL,
  `graduation_year` year(4) NOT NULL,
  `bio` text DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `cv_path` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `team_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `email` varchar(191) NOT NULL,
  `role` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `team_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `is_banned_from_forum` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_doctor_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_assigned_doctor_id_foreign` (`assigned_doctor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vitrin_analytics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vitrin_analytics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vitrin_id` bigint(20) unsigned NOT NULL,
  `metric` varchar(191) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `event_type` varchar(191) NOT NULL,
  `source` varchar(191) DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` varchar(191) DEFAULT NULL,
  `page` varchar(191) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vitrin_analytics_vitrin_id_event_type_index` (`vitrin_id`,`event_type`),
  KEY `vitrin_analytics_created_at_index` (`created_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vitrins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vitrins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `student_id` bigint(20) unsigned DEFAULT NULL,
  `subdomain` varchar(191) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `working_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`working_hours`)),
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services`)),
  `social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_media`)),
  `contact_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contact_info`)),
  `custom_slug` varchar(191) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vitrins_subdomain_unique` (`subdomain`),
  UNIQUE KEY `vitrins_custom_slug_unique` (`custom_slug`),
  KEY `vitrins_user_id_foreign` (`user_id`),
  KEY `vitrins_student_id_foreign` (`student_id`),
  CONSTRAINT `check_owner` CHECK (`user_id` is not null and `student_id` is null or `user_id` is null and `student_id` is not null)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*M!999999\- enable the sandbox mode */ 
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2023_05_30_create_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2023_10_25_create_profile_visits_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2024_03_20_000001_create_doctors_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2024_03_20_000002_create_doctor_profiles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2024_03_21_000003_create_sms_logs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2024_07_01_000000_create_patients_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_04_26_102025_add_two_factor_columns_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_04_26_102031_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_04_26_102031_create_teams_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_04_26_102032_create_team_user_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_04_26_102033_create_team_invitations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_04_26_103943_create_students_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_04_26_103943_create_vitrins_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_04_26_104516_add_assigned_doctor_id_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2025_04_26_104624_create_permission_tables',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (83,'2025_04_26_115232_create_media_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2025_04_27_081649_update_vitrins_add_missing_fields',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (85,'2025_04_28_135524_create_vitrin_analytics_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2025_04_28_140208_create_seo_reports_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2025_05_02_114118_create_services_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2025_05_02_115824_create_appointments_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2025_05_08_133755_add_vacation_periods_to_vitrins_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (90,'2025_05_09_052031_create_feedback_suggestions_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (91,'2025_05_09_052035_create_newsletter_subscribers_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2025_05_09_131735_add_metric_to_vitrin_analytics_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (93,'2025_05_09_183722_create_appointment_requests_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2025_05_09_224654_create_forum_categories_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2025_05_09_224658_create_forum_topics_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (96,'2025_05_09_224705_create_forum_messages_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2025_05_09_231048_add_forum_fields_to_users_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2025_05_09_231150_create_forum_topic_user_reads_table',3);
