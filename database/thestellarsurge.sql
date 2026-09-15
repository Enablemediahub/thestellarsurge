-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2026 at 11:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thestellarsurge`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `content` longtext NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `cover_image`, `is_published`, `is_featured`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Beyond the Stage: How AI & Hyper-Personalization Are Transforming Event Experiences', 'beyond-the-stage-how-ai-hyper-personalization-are-transforming-event-experiences', 'Passive, cookie-cutter events are officially out. Modern attendees demand interactive, personalized, and value-driven experiences. Discover how AI-powered matchmaking, adaptive venue styling, and multi-sensory designs are redefining event strategy—and how StellarSurge turns these trends into seamless reality.', '<h3>The Evolution of Event Production</h3><p>Remember when hosting a successful corporate event simply meant booking a hotel ballroom, setting up a projection screen, and serving standard coffee? Those days are over. Today’s audiences want immersion, purpose, and active engagement over passive listening.</p><p>At <strong>StellarSurge</strong>, we’ve watched event dynamics shift from basic coordination to strategic experience design. Brands aren\'t just holding gatherings anymore—they are building living, breathing environments that tell a story.</p><p>If you want your next summit, launch, or gala to leave a lasting impact, here are the key shifts driving successful event strategies right now:</p><h3>1. AI-Driven Hyper-Personalization</h3><p>Artificial intelligence is changing how attendees navigate events. Rather than forcing every guest down the same rigid agenda, smart event tech now builds dynamic, individualized schedules based on attendee preferences.</p><ul><li><strong>Smart Networking:</strong> AI algorithms analyze guest profiles to suggest high-value, one-on-one introductions.</li><li><strong>Tailored Content Journeys:</strong> Attendees receive real-time recommendations for sessions, breakout workshops, and interactive exhibits that align directly with their goals.</li></ul><h3>2. Multi-Sensory &amp; Experience-Led Styling</h3><p>Decor isn\'t just background decoration anymore—it drives guest behavior and brand recall. Modern styling combines spatial design, specialized lighting, and interactive installations to guide attendee flow naturally. From dedicated VIP immersive zones to interactive brand walkthroughs, every corner of the venue serves a distinct purpose.</p><h3>3. Purpose-First &amp; Sustainable Planning</h3><p>Green initiatives have evolved from simple paperless ticketing into core event logistics. Audiences favor brands that prioritize real-world impact:</p><ul><li>Sourcing local catering to cut transport emissions and avoid food waste.</li><li>Designing modular, reusable scenic branding assets over single-use signage.</li><li>Prioritizing accessible, step-free venues with clear digital wayfinding for all guests.</li></ul><h3>How StellarSurge Elevates Your Vision</h3><p>Navigating these moving parts takes more than a checklist—it requires expert consultation, creative design, and precise logistics management.</p><p>Whether you are hosting an intimate executive retreat or a large-scale international conference, <strong>StellarSurge</strong> brings the expertise, industry tech, and hands-on coordination needed to turn your vision into an unforgettable experience.</p><p><strong>Ready to transform your next event into an extraordinary experience?</strong></p><p>Contact the consultation team at <strong>StellarSurge</strong> today to get started!</p><p><br></p>', 'blog/01M2J9ABGBKY2G6KHQASRWQMRX.jpeg', 1, 1, '2026-09-15 09:12:18', '2026-09-15 09:20:35', '2026-09-15 09:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1789467662),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1789467662;', 1789467662),
('laravel-cache-livewire-rate-limiter:a5953fb5e1c86b5792734a0b4775a77519f2794f', 'i:1;', 1789481887),
('laravel-cache-livewire-rate-limiter:a5953fb5e1c86b5792734a0b4775a77519f2794f:timer', 'i:1789481887;', 1789481887);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultation_requests`
--

CREATE TABLE `consultation_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `consultation_preference` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `guest_count` int(10) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `location_url` text DEFAULT NULL,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ticket_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ticket_options`)),
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `banner_image` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `slug`, `summary`, `description`, `start_at`, `end_at`, `location`, `venue`, `location_url`, `price`, `ticket_options`, `currency`, `banner_image`, `is_published`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'A Night of Creative Motion', 'a-night-of-creative-motion', 'A premium experience blending culture, sound, storytelling and community.', 'An evening of performances, creative networking and energy-led experiences for culture lovers.', '2026-10-12 18:00:00', '2026-10-12 22:00:00', 'Accra, Ghana', 'The Dome, Accra', NULL, 120, '[]', 'GHS', NULL, 1, 0, '2026-09-13 09:14:08', '2026-09-13 10:42:22'),
(2, 'Her Next Chapter', 'her-next-chapter', 'A powerful gathering for women building ideas, businesses and bold futures.', 'A story-led event for women in business, leadership, and creative enterprise.', '2026-11-02 18:30:00', '2026-11-02 21:30:00', 'Lagos, Nigeria', 'Lagos Innovation Hub', NULL, 150, '[]', 'GHS', 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80', 1, 0, '2026-09-13 09:14:08', '2026-09-14 20:47:53'),
(3, 'Stellar Foundations', 'stellar-foundations', 'A transformation-focused event for emerging creators and entrepreneurs.', 'A practical, community-driven event centered on business foundations, confidence, and momentum.', '2026-12-14 10:00:00', '2026-12-14 16:00:00', 'Kumasi, Ghana', 'Kumasi Creative Spaces', NULL, 200, '[]', 'GHS', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80', 1, 0, '2026-09-13 09:14:08', '2026-09-14 20:48:51'),
(4, 'Conversations With Men: The Things Men Don\'t Say', 'conversations-with-men-the-things-men-dont-say', 'An engaging discussion hosted by Stellar Surge exploring honest, unspoken topics and perspectives surrounding men.', 'Join Stellar Surge for \"Conversations With Men: The Things Men Don\'t Say.\" This event provides an open, insightful platform for deep discussions and honest dialogue. Follow @thestellarsurge on Instagram for updates.', '2026-10-13 10:00:00', '2026-10-13 16:00:00', 'Accra, Ghana', 'Lancaster', 'https://maps.app.goo.gl/Xv2kefKqJCXyDBiH6', 150, '[{\"name\":\"VIP\",\"price\":\"300\"},{\"name\":\"REGULAR\",\"price\":\"150\"}]', 'GHS', 'events/flyers/01M2D8PM09XXND7YRF7VKRYKEJ.jpeg', 1, 1, '2026-09-13 10:33:36', '2026-09-13 11:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `event_gallery_comments`
--

CREATE TABLE `event_gallery_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_gallery_item_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_gallery_items`
--

CREATE TABLE `event_gallery_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Highlights',
  `image_path` text DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `likes_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_planning_requests`
--

CREATE TABLE `event_planning_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `consultation_preference` varchar(255) NOT NULL,
  `event_date` date DEFAULT NULL,
  `guest_count` int(10) UNSIGNED DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_12_000001_create_events_table', 1),
(5, '2026_09_12_000002_create_tickets_table', 1),
(6, '2026_09_12_000003_create_payments_table', 1),
(7, '2026_09_13_000001_create_site_settings_table', 1),
(8, '2026_09_13_000002_change_event_currency_to_ghs', 2),
(9, '2026_09_13_000003_create_testimonials_table', 3),
(10, '2026_09_13_000004_create_subscribers_table', 4),
(11, '2026_09_13_000005_add_ticket_options_and_location_url_to_events_table', 5),
(12, '2026_09_13_000003_add_whatsapp_confirmation_to_tickets_table', 6),
(13, '2026_09_13_000004_add_portal_hero_images_to_site_settings_table', 7),
(14, '2026_09_13_000005_add_verification_to_tickets_table', 8),
(15, '2026_09_13_000006_add_ticket_scanner_enabled_to_site_settings_table', 9),
(16, '2026_09_13_000007_create_event_gallery_tables', 10),
(17, '2026_09_13_000008_add_youtube_url_to_event_gallery_items', 11),
(18, '2026_09_13_000009_add_login_wallpaper_to_site_settings_table', 12),
(19, '2026_09_15_000008_create_blog_posts_table', 13),
(20, '2026_09_15_000009_create_consultation_requests_table', 13),
(21, '2026_09_15_000010_add_featured_to_blog_posts_table', 14),
(22, '2026_09_15_000011_add_consultation_preference_to_consultation_requests_table', 15),
(23, '2026_09_15_000012_create_event_planning_requests_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `gateway` varchar(255) NOT NULL DEFAULT 'paystack',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `event_id`, `ticket_id`, `user_id`, `reference`, `amount`, `currency`, `status`, `gateway`, `metadata`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, 'SS-IGD2DFOUHC1U', 300, 'GHS', 'success', 'demo', '{\"event_slug\":\"conversations-with-men-the-things-men-dont-say\",\"ticket_references\":[\"TCK-CTNMNU0UQUWE\"],\"customer_email\":\"crepindale@gmail.com\",\"quantity\":1,\"ticket_type\":\"vip\",\"ticket_type_name\":\"VIP\"}', '2026-09-13 13:34:51', '2026-09-13 12:34:51', '2026-09-13 12:34:51'),
(2, 4, 2, NULL, 'SS-DNTIYWX29K8L', 150, 'GHS', 'success', 'paystack', '{\"event_slug\":\"conversations-with-men-the-things-men-dont-say\",\"ticket_references\":[\"TCK-MJKSB7UDAPC6\"],\"customer_email\":\"abimawuse@gmail.com\",\"quantity\":1,\"ticket_type\":\"regular\",\"ticket_type_name\":\"REGULAR\"}', '2026-09-14 21:02:58', '2026-09-14 20:01:36', '2026-09-14 20:02:58'),
(3, 4, 3, NULL, 'SS-UQYFBUSSYGIU', 300, 'GHS', 'success', 'paystack', '{\"event_slug\":\"conversations-with-men-the-things-men-dont-say\",\"ticket_references\":[\"TCK-PQPE6JS4OIIB\"],\"customer_email\":\"qheremef@gmail.com\",\"quantity\":1,\"ticket_type\":\"vip\",\"ticket_type_name\":\"VIP\"}', '2026-09-14 21:20:07', '2026-09-14 20:19:02', '2026-09-14 20:20:07'),
(4, 4, 4, NULL, 'SS-0N9MUOWHFGF7', 300, 'GHS', 'success', 'paystack', '{\"event_slug\":\"conversations-with-men-the-things-men-dont-say\",\"ticket_references\":[\"TCK-BAI3OAI3QJ87\"],\"customer_email\":\"crepindale@gmail.com\",\"quantity\":1,\"ticket_type\":\"vip\",\"ticket_type_name\":\"VIP\"}', '2026-09-14 21:20:51', '2026-09-14 20:19:59', '2026-09-14 20:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2hNv8QWcitrO1dahSZlVAqWU5gjzuBMW5SIwHm7m', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDZyQ29LSU9aMG1UTlNucE9KZDhkM0JXYkdiUlFUTnJUTGRwSFp6TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlc3RlbGxhcnN1cmdlL3B1YmxpYy9ldmVudF9wbGFubmluZyI7czo1OiJyb3V0ZSI7czoyNjoiZXZlbnRfcGxhbm5pbmcuaW5kZXgubG9jYWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789481526),
('4Nq8IGccFnY8lsahjTbjFynHFXCHpnQkoSEsoGtf', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGZ3TU42ZjdxYmdzYjY0b0dueUhoOHlsR2JkMUt6SXNpeHBPZExuQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481495),
('aYAEC0wrSgtsSVxzbAiICKX75rBItZOm0yrTBCYy', NULL, '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzdpOWpWcll0SnlVWDRyN2pZMkZaazJvYnpQWWsyVzcxcUtXRFZGOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789484371),
('G1vVGGIjS4paHOKsVywmE7jkcWsUCQsvNMre72Hu', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekpuN1VRRjVnOGE5czY5VjRKWlRxa3JKWW1oZDVOVEdEMVJjalcyMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481487),
('gmHEatP0FsO8ueel9UIsWheDQCodZJJh0P4KuHdt', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEhJYk1VZ0Z6cXhoMUwyRExWVHB2dnRRaUMydGFjVnlFb3A5ZEs2eCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481567),
('iESSsqPs1hrCjf8NePDPURdRncgoO5ugHRZcLnXz', NULL, '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHlhUHpnZ2F6ZFVKaEVmYkxoUTM0S3pEcGZqb0o5SUNjN29aYXZBeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789483215),
('juphcogSFQBgekb2jRycjqCWY6LjCXXIQGEASBA6', NULL, '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjZlT1ZTT1E4SzhoeXZiMWRvRzZ0bGR4bUtYVjYxdGkyQ1FOZFBDayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789482457),
('Q2vyLYilkTKIrs6VjaqQwT9inGGSbbAxxponnQFK', NULL, '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidm9OaDdUM1l2dFhwNHVRNGFPMXQyakZVOTJaaU4wVEVTUXQ4ZFVvQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789481196),
('qwvHvxIdyFRGiZAvjeKi13WxDg8fypjsqkPWpSS2', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMngwUWpxZVNORUx6V0x3VkF1Nkl6enNHajBvbXhHMFpwNFpXR1Q5MCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481406),
('S4ftHwiO1LeVuZ1GnocePGZ0pfkPggZXZc9nVvcl', NULL, '::1', 'curl/8.21.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTWJRRkRQaElYN2ZEN0dRamNSNXNob3dIMGtEZEJuWXpudHl1RTNCciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481398),
('sHYwYXX6v83gszFhlif1We5qfgY6a18YEurn4MNV', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXZJWjNlMlJVczJDS1hIT3NJSHl6b0daTDdYWmR1VEJydXhQbzBwUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481411),
('sOTmLFfFz2Ti3bo7TNInkWve7HSGWnXQNNPWqeSM', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXczTVR2dWs3d1dWS0hjeE1FT0VlMFNqelZpSWZsbHFtZ3pZTnpmQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481417),
('vcO04qShlLAkDAKmhRFYNJCOFHQ57Mr1kvano4Yy', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemp4R2o3TkNncDdacUMycHdSOW5TVUFza25Xd2c0TTBnUnpBVU5hWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481756),
('WwIgLW8n09DQj1B6D2mKm4mrpTjLkjTVqa4gvOCh', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTWc5T0c0TVY3TFZVVUM2d3R2eEpxWGFZcTlicVloN0M5TFpkVzV2WCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2NzoiaHR0cDovL2xvY2FsaG9zdC90aGVzdGVsbGFyc3VyZ2UvcHVibGljL2FkbWluL2NvbnN1bHRhdGlvbi1yZXF1ZXN0cyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUxOiJodHRwOi8vbG9jYWxob3N0L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MjU6ImZpbGFtZW50LmFkbWluLmF1dGgubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789508902),
('yRFdBZ77Bto0mY32TrhT0UIoIKLREziUtiYvpE6k', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaU5iUFpVMUVHTzN2SEc1ZnMzUmJqUTZXWnNJbWJhSkpSNWkwZ1ZDbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481762),
('ZetoTBl2i1rFcp7O5EdmFtOEn9XtYANPulYmx957', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoic3hvd3FqUWo2UnBCQWZMaGZidXZEOTBxNHR1R0xXZklRRmlzbEZVTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlc3RlbGxhcnN1cmdlL3B1YmxpYy9hZG1pbi9jb25zdWx0YXRpb24tcmVxdWVzdHMiO3M6NToicm91dGUiO3M6NTI6ImZpbGFtZW50LmFkbWluLnJlc291cmNlcy5jb25zdWx0YXRpb24tcmVxdWVzdHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMjMwZTkwMDI0OGNmOTI3YjUzYjU5OTU2YmExODljNGE5NzUzNzY3NmJkMmJhYzQ3ZjUyYjBiNjJjMmI0OWZjYSI7fQ==', 1789482077),
('Zq8twOb2KJ8z7a0UvMEvUvfweqq3024EfEfApoYD', NULL, '::1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieEpZSVdaRGhMOTY3VGZ0Y3FNUFBOMFd2a25EVkVISXJyV2JTblhvUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9pZ25vcmUtZHJlc3MtdmFncmFudGx5Lm5ncm9rLWZyZWUuZGV2L3RoZXN0ZWxsYXJzdXJnZS9wdWJsaWMvZXZlbnRfcGxhbm5pbmciO3M6NToicm91dGUiO3M6MjY6ImV2ZW50X3BsYW5uaW5nLmluZGV4LmxvY2FsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789481583);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL DEFAULT 'Stellar Surge',
  `logo_path` varchar(255) DEFAULT NULL,
  `favicon_path` varchar(255) DEFAULT NULL,
  `login_wallpaper` varchar(255) DEFAULT NULL,
  `hero_slides` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hero_slides`)),
  `events_logo_path` varchar(255) DEFAULT NULL,
  `events_hero_image` varchar(255) DEFAULT NULL,
  `growth_logo_path` varchar(255) DEFAULT NULL,
  `growth_hero_image` varchar(255) DEFAULT NULL,
  `training_logo_path` varchar(255) DEFAULT NULL,
  `training_hero_image` varchar(255) DEFAULT NULL,
  `events_color` varchar(255) NOT NULL DEFAULT '#E17B7C',
  `growth_color` varchar(255) NOT NULL DEFAULT '#F9AD2D',
  `training_color` varchar(255) NOT NULL DEFAULT '#159D99',
  `plum_color` varchar(255) NOT NULL DEFAULT '#32152F',
  `gold_color` varchar(255) NOT NULL DEFAULT '#C8A46A',
  `ivory_color` varchar(255) NOT NULL DEFAULT '#F7F2E9',
  `contact_email` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `footer_credit` text DEFAULT NULL,
  `ticket_scanner_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `logo_path`, `favicon_path`, `login_wallpaper`, `hero_slides`, `events_logo_path`, `events_hero_image`, `growth_logo_path`, `growth_hero_image`, `training_logo_path`, `training_hero_image`, `events_color`, `growth_color`, `training_color`, `plum_color`, `gold_color`, `ivory_color`, `contact_email`, `whatsapp_number`, `social_links`, `footer_credit`, `ticket_scanner_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Stellar Surge', NULL, NULL, 'branding/admin/01M2GYC4EBZYB1XR5011QMQ2JF.jpg', '[]', NULL, 'branding/portals/heroes/01M2H14AJDSWWX9K1HM1CSRK1C.jpg', 'branding/portals/01M2H1VA9M2Q5M35S2Y8NGQAG4.png', 'branding/portals/heroes/01M2H1RDRZ5SXNSFNS2FJ0NVE4.jpg', NULL, 'branding/portals/heroes/01M2H1GFCBZ1MBNBS7XFN0VKQV.jpg', '#E17B7C', '#F9AD2D', '#159D99', '#32152F', '#C8A46A', '#F7F2E9', 'info@thestellarsurge.com', '233241786330', '[{\"label\":\"Instagram\",\"url\":\"https:\\/\\/www.instagram.com\\/thestellarsurge\\/\",\"logo_path\":null,\"platform\":\"instagram\"},{\"label\":\"Facebook\",\"url\":\"https:\\/\\/web.facebook.com\\/stellar.surge\\/\",\"logo_path\":null,\"platform\":\"facebook\"},{\"label\":\"X \\/ Twitter\",\"url\":\"https:\\/\\/x.com\\/TheStellarSurge\",\"logo_path\":null,\"platform\":\"x\"}]', 'Developed and Designed by DALE QUIST [Enable Technologies]', 1, '2026-09-13 09:14:08', '2026-09-14 21:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `is_subscribed` tinyint(1) NOT NULL DEFAULT 1,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `name`, `email`, `is_subscribed`, `subscribed_at`, `created_at`, `updated_at`) VALUES
(1, 'Dale Quist', 'crepindale@gmail.com', 1, '2026-09-13 13:41:06', '2026-09-13 13:41:06', '2026-09-13 13:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `quote`, `author`, `role`, `is_approved`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'I love their services. It\'s a top notch organization with excellent customer relations.', 'Dale Quist', 'Mindsurgeon', 1, 1, '2026-09-13 13:40:43', '2026-09-14 21:01:03'),
(2, 'This is a premium place to be and a good organization to contact for your events', 'Emefa Quist', 'Qatar Airways', 1, 0, '2026-09-13 19:28:16', '2026-09-14 20:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `ticket_type` varchar(255) NOT NULL DEFAULT 'standard',
  `amount` int(10) UNSIGNED NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` datetime DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `event_id`, `user_id`, `reference`, `email`, `name`, `phone`, `whatsapp_confirmed`, `ticket_type`, `amount`, `currency`, `status`, `verified`, `verified_at`, `qr_code`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 'TCK-CTNMNU0UQUWE', 'crepindale@gmail.com', 'CREPINDALE ELORM QUIST', '233241786330', 1, 'vip', 300, 'GHS', 'paid', 0, NULL, 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjI2MCIgaGVpZ2h0PSIyNjAiIHZpZXdCb3g9IjAgMCAyNjAgMjYwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMjYwIiBoZWlnaHQ9IjI2MCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoNi4zNDEpIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLDApIj48cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik05IDBMOSAxTDggMUw4IDNMOSAzTDkgNEw4IDRMOCA4TDYgOEw2IDlMNyA5TDcgMTBMNSAxMEw1IDlMNCA5TDQgOEwzIDhMMyA5TDIgOUwyIDhMMCA4TDAgOUwyIDlMMiAxMEwzIDEwTDMgMTFMNCAxMUw0IDEyTDIgMTJMMiAxMUwxIDExTDEgMTBMMCAxMEwwIDExTDEgMTFMMSAxM0wwIDEzTDAgMTZMMiAxNkwyIDE4TDEgMThMMSAxN0wwIDE3TDAgMTlMMSAxOUwxIDIxTDAgMjFMMCAyMkwzIDIyTDMgMjNMMSAyM0wxIDI1TDAgMjVMMCAyNkwxIDI2TDEgMjVMMiAyNUwyIDI3TDEgMjdMMSAyOEwwIDI4TDAgMjlMMiAyOUwyIDMxTDMgMzFMMyAzMkwyIDMyTDIgMzNMMyAzM0wzIDMyTDQgMzJMNCAzM0w3IDMzTDcgMzJMOSAzMkw5IDMxTDEyIDMxTDEyIDMyTDEzIDMyTDEzIDMxTDE0IDMxTDE0IDI5TDE1IDI5TDE1IDMwTDE3IDMwTDE3IDI4TDE4IDI4TDE4IDI3TDE1IDI3TDE1IDI2TDE2IDI2TDE2IDI1TDE3IDI1TDE3IDI0TDE2IDI0TDE2IDIzTDEzIDIzTDEzIDI0TDE1IDI0TDE1IDI1TDEzIDI1TDEzIDI2TDExIDI2TDExIDIyTDEyIDIyTDEyIDE5TDE1IDE5TDE1IDE4TDE2IDE4TDE2IDE5TDE3IDE5TDE3IDIwTDEzIDIwTDEzIDIyTDE0IDIyTDE0IDIxTDE2IDIxTDE2IDIyTDE4IDIyTDE4IDI0TDE5IDI0TDE5IDI2TDIwIDI2TDIwIDI3TDE5IDI3TDE5IDI4TDIwIDI4TDIwIDI5TDIxIDI5TDIxIDMwTDIwIDMwTDIwIDMxTDE5IDMxTDE5IDMyTDIyIDMyTDIyIDMxTDIzIDMxTDIzIDM0TDIxIDM0TDIxIDMzTDE4IDMzTDE4IDMxTDE2IDMxTDE2IDMyTDE0IDMyTDE0IDMzTDExIDMzTDExIDMyTDEwIDMyTDEwIDMzTDExIDMzTDExIDM0TDEwIDM0TDEwIDM1TDkgMzVMOSAzM0w4IDMzTDggMzVMOSAzNUw5IDM3TDggMzdMOCAzOEw5IDM4TDkgMzlMOCAzOUw4IDQxTDEwIDQxTDEwIDQwTDExIDQwTDExIDQxTDEyIDQxTDEyIDQwTDEzIDQwTDEzIDQxTDE0IDQxTDE0IDM5TDE1IDM5TDE1IDM4TDEzIDM4TDEzIDM5TDEyIDM5TDEyIDM3TDEzIDM3TDEzIDM2TDE2IDM2TDE2IDM3TDE3IDM3TDE3IDM4TDE2IDM4TDE2IDM5TDE3IDM5TDE3IDQwTDE4IDQwTDE4IDM5TDE3IDM5TDE3IDM4TDE4IDM4TDE4IDM3TDE3IDM3TDE3IDM1TDE4IDM1TDE4IDM2TDE5IDM2TDE5IDM1TDIxIDM1TDIxIDM3TDIwIDM3TDIwIDQwTDIxIDQwTDIxIDQxTDIyIDQxTDIyIDQwTDI0IDQwTDI0IDQxTDI1IDQxTDI1IDQwTDI2IDQwTDI2IDM2TDI3IDM2TDI3IDM3TDI4IDM3TDI4IDM1TDI5IDM1TDI5IDMzTDMwIDMzTDMwIDM2TDMxIDM2TDMxIDM1TDMyIDM1TDMyIDM3TDI5IDM3TDI5IDM4TDI4IDM4TDI4IDM5TDI5IDM5TDI5IDQxTDMwIDQxTDMwIDQwTDMyIDQwTDMyIDQxTDMzIDQxTDMzIDQwTDM0IDQwTDM0IDQxTDM2IDQxTDM2IDQwTDM3IDQwTDM3IDM5TDM4IDM5TDM4IDM4TDQxIDM4TDQxIDM2TDM5IDM2TDM5IDM1TDQwIDM1TDQwIDM0TDQxIDM0TDQxIDMyTDQwIDMyTDQwIDMzTDM5IDMzTDM5IDMyTDM4IDMyTDM4IDMxTDQxIDMxTDQxIDI4TDQwIDI4TDQwIDI5TDM4IDI5TDM4IDI4TDM3IDI4TDM3IDI3TDM4IDI3TDM4IDI2TDM5IDI2TDM5IDI3TDQxIDI3TDQxIDI0TDM5IDI0TDM5IDIzTDQwIDIzTDQwIDIyTDQxIDIyTDQxIDIxTDQwIDIxTDQwIDIwTDQxIDIwTDQxIDE4TDQwIDE4TDQwIDE3TDQxIDE3TDQxIDE2TDQwIDE2TDQwIDE3TDM4IDE3TDM4IDE2TDM2IDE2TDM2IDE3TDM0IDE3TDM0IDE4TDM2IDE4TDM2IDIwTDM1IDIwTDM1IDE5TDM0IDE5TDM0IDIwTDMyIDIwTDMyIDE5TDMzIDE5TDMzIDE4TDMyIDE4TDMyIDE2TDM1IDE2TDM1IDE1TDM3IDE1TDM3IDE0TDM1IDE0TDM1IDE1TDMyIDE1TDMyIDE2TDMxIDE2TDMxIDE4TDMyIDE4TDMyIDE5TDMxIDE5TDMxIDIwTDMyIDIwTDMyIDIxTDM0IDIxTDM0IDIyTDM1IDIyTDM1IDI0TDM0IDI0TDM0IDIzTDMyIDIzTDMyIDIyTDMwIDIyTDMwIDIxTDI5IDIxTDI5IDIwTDMwIDIwTDMwIDE1TDI3IDE1TDI3IDE0TDI4IDE0TDI4IDEzTDI5IDEzTDI5IDE0TDMwIDE0TDMwIDEzTDMyIDEzTDMyIDE0TDMzIDE0TDMzIDEyTDM0IDEyTDM0IDEzTDM1IDEzTDM1IDExTDM2IDExTDM2IDEwTDM1IDEwTDM1IDExTDM0IDExTDM0IDlMMzcgOUwzNyAxMkwzNiAxMkwzNiAxM0wzOCAxM0wzOCAxNUw0MSAxNUw0MSAxMUw0MCAxMUw0MCA4TDM4IDhMMzggOUwzNyA5TDM3IDhMMzQgOEwzNCA5TDMzIDlMMzMgNUwzMiA1TDMyIDRMMzEgNEwzMSA2TDMwIDZMMzAgNUwyOSA1TDI5IDNMMzEgM0wzMSAyTDMwIDJMMzAgMEwyOSAwTDI5IDJMMjggMkwyOCAxTDI3IDFMMjcgMEwyNiAwTDI2IDFMMjcgMUwyNyAzTDIxIDNMMjEgMkwyMiAyTDIyIDFMMjEgMUwyMSAyTDIwIDJMMjAgM0wxOCAzTDE4IDJMMTkgMkwxOSAxTDE0IDFMMTQgMkwxNyAyTDE3IDNMMTYgM0wxNiA0TDE1IDRMMTUgNkwxNCA2TDE0IDRMMTIgNEwxMiAzTDEzIDNMMTMgMEwxMiAwTDEyIDFMMTAgMUwxMCAwWk0yMyAwTDIzIDJMMjUgMkwyNSAwWk05IDFMOSAzTDEyIDNMMTIgMkwxMCAyTDEwIDFaTTkgNEw5IDdMMTAgN0wxMCA5TDExIDlMMTEgMTBMMTAgMTBMMTAgMTFMMTEgMTFMMTEgMTJMMTAgMTJMMTAgMTNMMTEgMTNMMTEgMTJMMTMgMTJMMTMgMTRMMTQgMTRMMTQgMTNMMTYgMTNMMTYgMTRMMTUgMTRMMTUgMTVMMTcgMTVMMTcgMTRMMTggMTRMMTggMTNMMTkgMTNMMTkgMTdMMjAgMTdMMjAgMThMMTkgMThMMTkgMjBMMTcgMjBMMTcgMjFMMTggMjFMMTggMjJMMTkgMjJMMTkgMjBMMjAgMjBMMjAgMjFMMjEgMjFMMjEgMjJMMjIgMjJMMjIgMjRMMjEgMjRMMjEgMjVMMjIgMjVMMjIgMjZMMjEgMjZMMjEgMjdMMjAgMjdMMjAgMjhMMjEgMjhMMjEgMjdMMjMgMjdMMjMgMjlMMjIgMjlMMjIgMzBMMjMgMzBMMjMgMzFMMjUgMzFMMjUgMzJMMjQgMzJMMjQgMzNMMjYgMzNMMjYgMzJMMjcgMzJMMjcgMzNMMjggMzNMMjggMzJMMjkgMzJMMjkgMzFMMjggMzFMMjggMzBMMzAgMzBMMzAgMzFMMzIgMzFMMzIgMzJMMzAgMzJMMzAgMzNMMzIgMzNMMzIgMzJMMzQgMzJMMzQgMzBMMzUgMzBMMzUgMzJMMzcgMzJMMzcgMzNMMzggMzNMMzggMzJMMzcgMzJMMzcgMzFMMzggMzFMMzggMjlMMzcgMjlMMzcgMjhMMzYgMjhMMzYgMzBMMzUgMzBMMzUgMjdMMzQgMjdMMzQgMjZMMzggMjZMMzggMjVMMzkgMjVMMzkgMjRMMzggMjRMMzggMjNMMzYgMjNMMzYgMjRMMzUgMjRMMzUgMjVMMzQgMjVMMzQgMjZMMzEgMjZMMzEgMjlMMzIgMjlMMzIgMzBMMzAgMzBMMzAgMjlMMjcgMjlMMjcgMjhMMjggMjhMMjggMjdMMjkgMjdMMjkgMjZMMzAgMjZMMzAgMjVMMzEgMjVMMzEgMjRMMzAgMjRMMzAgMjJMMjggMjJMMjggMjFMMjcgMjFMMjcgMjBMMjggMjBMMjggMThMMjYgMThMMjYgMTdMMjcgMTdMMjcgMTVMMjYgMTVMMjYgMTdMMjUgMTdMMjUgMTRMMjQgMTRMMjQgMTVMMjIgMTVMMjIgMTZMMjEgMTZMMjEgMTVMMjAgMTVMMjAgMTNMMjEgMTNMMjEgMTRMMjMgMTRMMjMgMTFMMjQgMTFMMjQgMTJMMjUgMTJMMjUgMTNMMjYgMTNMMjYgMTRMMjcgMTRMMjcgMTNMMjggMTNMMjggMTJMMjUgMTJMMjUgMTFMMjggMTFMMjggOUwzMCA5TDMwIDEwTDI5IDEwTDI5IDEyTDMyIDEyTDMyIDExTDMwIDExTDMwIDEwTDMxIDEwTDMxIDdMMzIgN0wzMiA2TDMxIDZMMzEgN0wzMCA3TDMwIDZMMjkgNkwyOSA3TDMwIDdMMzAgOEwyNyA4TDI3IDlMMjYgOUwyNiAxMEwyNSAxMEwyNSAxMUwyNCAxMUwyNCAxMEwyMyAxMEwyMyA3TDI0IDdMMjQgOUwyNSA5TDI1IDhMMjYgOEwyNiA2TDI1IDZMMjUgN0wyNCA3TDI0IDVMMjMgNUwyMyA0TDIxIDRMMjEgNUwyMyA1TDIzIDdMMjIgN0wyMiA2TDIxIDZMMjEgN0wyMiA3TDIyIDEwTDIxIDEwTDIxIDExTDIyIDExTDIyIDEyTDIwIDEyTDIwIDExTDE5IDExTDE5IDEwTDE2IDEwTDE2IDlMMTUgOUwxNSAxMUwxNyAxMUwxNyAxM0wxNiAxM0wxNiAxMkwxMyAxMkwxMyAxMEwxNCAxMEwxNCA5TDEzIDlMMTMgOEwxNCA4TDE0IDZMMTMgNkwxMyA1TDEyIDVMMTIgNFpNMTcgNEwxNyA1TDE2IDVMMTYgNkwxNSA2TDE1IDhMMTcgOEwxNyA5TDIxIDlMMjEgOEwyMCA4TDIwIDZMMTkgNkwxOSA1TDIwIDVMMjAgNEwxOSA0TDE5IDVMMTggNUwxOCA0Wk0yNSA0TDI1IDVMMjggNUwyOCA0Wk0xMSA1TDExIDZMMTAgNkwxMCA3TDExIDdMMTEgNkwxMiA2TDEyIDdMMTMgN0wxMyA2TDEyIDZMMTIgNVpNMTcgNUwxNyA2TDE2IDZMMTYgN0wxNyA3TDE3IDhMMTkgOEwxOSA2TDE4IDZMMTggNVpNMTcgNkwxNyA3TDE4IDdMMTggNlpNMjcgNkwyNyA3TDI4IDdMMjggNlpNOCA4TDggOUw5IDlMOSA4Wk0xMSA4TDExIDlMMTIgOUwxMiA4Wk0yMiAxMEwyMiAxMUwyMyAxMUwyMyAxMFpNMzggMTBMMzggMTFMMzkgMTFMMzkgMTJMMzggMTJMMzggMTNMNDAgMTNMNDAgMTFMMzkgMTFMMzkgMTBaTTYgMTFMNiAxMkw3IDEyTDcgMTNMNSAxM0w1IDE2TDggMTZMOCAxOEw3IDE4TDcgMTdMNiAxN0w2IDE4TDcgMThMNyAxOUw2IDE5TDYgMjBMNyAyMEw3IDE5TDggMTlMOCAyMUw5IDIxTDkgMjJMMTAgMjJMMTAgMjFMMTEgMjFMMTEgMjBMMTAgMjBMMTAgMjFMOSAyMUw5IDE5TDEwIDE5TDEwIDE4TDkgMThMOSAxNkw4IDE2TDggMTVMOSAxNUw5IDE0TDggMTRMOCAxMVpNMiAxNEwyIDE1TDMgMTVMMyAxOEwyIDE4TDIgMjBMMyAyMEwzIDIxTDQgMjFMNCAyMkw1IDIyTDUgMjRMMyAyNEwzIDI2TDQgMjZMNCAyOUwzIDI5TDMgMjdMMiAyN0wyIDI5TDMgMjlMMyAzMEw0IDMwTDQgMzJMNyAzMkw3IDMxTDggMzFMOCAyOEwxMCAyOEwxMCAzMEwxMiAzMEwxMiAyN0wxMSAyN0wxMSAyNkw5IDI2TDkgMjVMMTAgMjVMMTAgMjNMOCAyM0w4IDIyTDcgMjJMNyAyMUw0IDIxTDQgMjBMNSAyMEw1IDE5TDMgMTlMMyAxOEw0IDE4TDQgMTRaTTYgMTRMNiAxNUw3IDE1TDcgMTRaTTEwIDE0TDEwIDE1TDExIDE1TDExIDE2TDEyIDE2TDEyIDE3TDExIDE3TDExIDE5TDEyIDE5TDEyIDE3TDEzIDE3TDEzIDE4TDE1IDE4TDE1IDE3TDE2IDE3TDE2IDE2TDE0IDE2TDE0IDE3TDEzIDE3TDEzIDE2TDEyIDE2TDEyIDE0Wk0yMiAxNkwyMiAxN0wyMSAxN0wyMSAxOEwyMCAxOEwyMCAyMEwyMSAyMEwyMSAyMUwyMiAyMUwyMiAyMkwyMyAyMkwyMyAyMUwyMiAyMUwyMiAyMEwyNCAyMEwyNCAxOUwyMyAxOUwyMyAxNlpNMjggMTZMMjggMTdMMjkgMTdMMjkgMTZaTTI0IDE3TDI0IDE4TDI1IDE4TDI1IDE3Wk0zNiAxN0wzNiAxOEwzNyAxOEwzNyAxOUwzOCAxOUwzOCAyMEwzNiAyMEwzNiAyMUwzNSAyMUwzNSAyMkwzOCAyMkwzOCAyMUwzOSAyMUwzOSAyMkw0MCAyMkw0MCAyMUwzOSAyMUwzOSAxOEwzNyAxOEwzNyAxN1pNMTcgMThMMTcgMTlMMTggMTlMMTggMThaTTIxIDE4TDIxIDE5TDIyIDE5TDIyIDE4Wk0yNSAyMEwyNSAyMUwyNCAyMUwyNCAyMkwyNSAyMkwyNSAyMUwyNiAyMUwyNiAyM0wyMyAyM0wyMyAyNEwyNSAyNEwyNSAyNUwyNCAyNUwyNCAyNkwyMyAyNkwyMyAyN0wyNCAyN0wyNCAyOEwyNiAyOEwyNiAyNkwyNSAyNkwyNSAyNUwyNiAyNUwyNiAyNEwyOCAyNEwyOCAyNUwyOSAyNUwyOSAyM0wyNyAyM0wyNyAyMUwyNiAyMUwyNiAyMFpNNiAyMkw2IDIzTDcgMjNMNyAyMlpNNSAyNEw1IDI1TDkgMjVMOSAyNFpNMzIgMjRMMzIgMjVMMzMgMjVMMzMgMjRaTTM2IDI0TDM2IDI1TDM3IDI1TDM3IDI0Wk01IDI2TDUgMjlMNCAyOUw0IDMwTDUgMzBMNSAzMUw3IDMxTDcgMzBMNiAzMEw2IDI5TDcgMjlMNyAyOEw2IDI4TDYgMjdMNyAyN0w3IDI2Wk04IDI2TDggMjdMOSAyN0w5IDI2Wk0xMCAyN0wxMCAyOEwxMSAyOEwxMSAyN1pNMTQgMjdMMTQgMjhMMTMgMjhMMTMgMjlMMTQgMjlMMTQgMjhMMTUgMjhMMTUgMjlMMTYgMjlMMTYgMjhMMTUgMjhMMTUgMjdaTTMyIDI3TDMyIDI5TDM0IDI5TDM0IDI3Wk0yMyAyOUwyMyAzMEwyNCAzMEwyNCAyOVpNMjYgMjlMMjYgMzBMMjcgMzBMMjcgMjlaTTAgMzBMMCAzMUwxIDMxTDEgMzBaTTAgMzJMMCAzM0wxIDMzTDEgMzJaTTE2IDMyTDE2IDMzTDE0IDMzTDE0IDM0TDEzIDM0TDEzIDM1TDE0IDM1TDE0IDM0TDE1IDM0TDE1IDM1TDE2IDM1TDE2IDM0TDE4IDM0TDE4IDM1TDE5IDM1TDE5IDM0TDE4IDM0TDE4IDMzTDE3IDMzTDE3IDMyWk0zMyAzM0wzMyAzNkwzNiAzNkwzNiAzM1pNMTEgMzRMMTEgMzVMMTAgMzVMMTAgMzdMOSAzN0w5IDM4TDEwIDM4TDEwIDM5TDExIDM5TDExIDM4TDEwIDM4TDEwIDM3TDEyIDM3TDEyIDM2TDExIDM2TDExIDM1TDEyIDM1TDEyIDM0Wk0yMyAzNEwyMyAzNkwyMiAzNkwyMiAzN0wyMSAzN0wyMSAzOUwyMiAzOUwyMiAzN0wyMyAzN0wyMyAzOEwyNCAzOEwyNCAzOUwyNSAzOUwyNSAzNkwyNCAzNkwyNCAzNUwyNiAzNUwyNiAzNFpNMjcgMzRMMjcgMzVMMjggMzVMMjggMzRaTTM0IDM0TDM0IDM1TDM1IDM1TDM1IDM0Wk0zOCAzNEwzOCAzNUwzNyAzNUwzNyAzN0wzOSAzN0wzOSAzNkwzOCAzNkwzOCAzNUwzOSAzNUwzOSAzNFpNMjMgMzZMMjMgMzdMMjQgMzdMMjQgMzZaTTMzIDM3TDMzIDM4TDMyIDM4TDMyIDQwTDMzIDQwTDMzIDM4TDM0IDM4TDM0IDM3Wk0zNSAzN0wzNSA0MEwzNiA0MEwzNiAzN1pNMzkgMzlMMzkgNDBMMzggNDBMMzggNDFMNDAgNDFMNDAgMzlaTTAgMEwwIDdMNyA3TDcgMFpNMSAxTDEgNkw2IDZMNiAxWk0yIDJMMiA1TDUgNUw1IDJaTTM0IDBMMzQgN0w0MSA3TDQxIDBaTTM1IDFMMzUgNkw0MCA2TDQwIDFaTTM2IDJMMzYgNUwzOSA1TDM5IDJaTTAgMzRMMCA0MUw3IDQxTDcgMzRaTTEgMzVMMSA0MEw2IDQwTDYgMzVaTTIgMzZMMiAzOUw1IDM5TDUgMzZaIiBmaWxsPSIjMDAwMDAwIi8+PC9nPjwvZz48L3N2Zz4K', '2026-09-13 12:34:51', '2026-09-13 12:34:51'),
(2, 4, NULL, 'TCK-MJKSB7UDAPC6', 'abimawuse@gmail.com', 'Abigail Quist', '0554310034', 1, 'regular', 150, 'GHS', 'paid', 0, NULL, 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjI2MCIgaGVpZ2h0PSIyNjAiIHZpZXdCb3g9IjAgMCAyNjAgMjYwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMjYwIiBoZWlnaHQ9IjI2MCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoNC45MDYpIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLDApIj48cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMSAwTDExIDFMOSAxTDkgMkwxMCAyTDEwIDNMOCAzTDggNUw5IDVMOSA0TDEwIDRMMTAgNUwxMSA1TDExIDNMMTIgM0wxMiAwWk0xMyAwTDEzIDFMMTUgMUwxNSAwWk0xNyAwTDE3IDFMMTYgMUwxNiAzTDE1IDNMMTUgMkwxNCAyTDE0IDNMMTMgM0wxMyA0TDEyIDRMMTIgNUwxMyA1TDEzIDRMMTQgNEwxNCA1TDE1IDVMMTUgNEwxOSA0TDE5IDVMMTcgNUwxNyA2TDE2IDZMMTYgOEwxNyA4TDE3IDlMMTYgOUwxNiAxMEwxNyAxMEwxNyAxMkwxNiAxMkwxNiAxM0wxNSAxM0wxNSAxMUwxNCAxMUwxNCAxMEwxNSAxMEwxNSA5TDEzIDlMMTMgOEwxNCA4TDE0IDdMMTUgN0wxNSA2TDE0IDZMMTQgN0wxMyA3TDEzIDZMMTIgNkwxMiA3TDExIDdMMTEgNkwxMCA2TDEwIDdMOSA3TDkgNkw4IDZMOCA3TDkgN0w5IDlMOCA5TDggOEw1IDhMNSA5TDIgOUwyIDhMMCA4TDAgMTBMMSAxMEwxIDExTDAgMTFMMCAxMkwyIDEyTDIgMTBMMyAxMEwzIDExTDQgMTFMNCAxMEw1IDEwTDUgOUw4IDlMOCAxMUw3IDExTDcgMTBMNiAxMEw2IDExTDUgMTFMNSAxMkw0IDEyTDQgMTNMNSAxM0w1IDE0TDYgMTRMNiAxNUw5IDE1TDkgMTZMMTAgMTZMMTAgMTVMMTEgMTVMMTEgMTZMMTIgMTZMMTIgMTdMOSAxN0w5IDE4TDEwIDE4TDEwIDE5TDExIDE5TDExIDE4TDEyIDE4TDEyIDE3TDE1IDE3TDE1IDE4TDEzIDE4TDEzIDIwTDEyIDIwTDEyIDIxTDEzIDIxTDEzIDIyTDkgMjJMOSAyM0w4IDIzTDggMjRMNCAyNEw0IDIyTDUgMjJMNSAyM0w3IDIzTDcgMjJMOCAyMkw4IDE5TDcgMTlMNyAxOEw2IDE4TDYgMTlMNCAxOUw0IDIwTDYgMjBMNiAyMUw3IDIxTDcgMjJMNSAyMkw1IDIxTDMgMjFMMyAyNEwyIDI0TDIgMjVMMCAyNUwwIDI4TDEgMjhMMSAyN0wyIDI3TDIgMjlMMyAyOUwzIDI3TDIgMjdMMiAyNUwzIDI1TDMgMjZMNCAyNkw0IDI5TDUgMjlMNSAzMkw0IDMyTDQgMzBMMyAzMEwzIDMxTDAgMzFMMCAzMkwxIDMyTDEgMzNMNSAzM0w1IDMyTDYgMzJMNiAzM0w3IDMzTDcgMzRMNiAzNEw2IDM1TDcgMzVMNyAzNEw4IDM0TDggMzVMOSAzNUw5IDM2TDEwIDM2TDEwIDM0TDExIDM0TDExIDM3TDEyIDM3TDEyIDM5TDEzIDM5TDEzIDQwTDEyIDQwTDEyIDQxTDExIDQxTDExIDM5TDEwIDM5TDEwIDM4TDkgMzhMOSAzN0w4IDM3TDggMzZMNSAzNkw1IDM0TDMgMzRMMyAzNUwyIDM1TDIgMzZMNCAzNkw0IDM3TDUgMzdMNSAzOUw4IDM5TDggMzhMOSAzOEw5IDQwTDEwIDQwTDEwIDQyTDkgNDJMOSA0MUw4IDQxTDggNDRMOSA0NEw5IDQzTDEwIDQzTDEwIDQyTDEyIDQyTDEyIDQzTDE0IDQzTDE0IDQ1TDEzIDQ1TDEzIDQ3TDEyIDQ3TDEyIDQ2TDExIDQ2TDExIDQ1TDEyIDQ1TDEyIDQ0TDEwIDQ0TDEwIDQ3TDkgNDdMOSA0NUw4IDQ1TDggNDhMMTAgNDhMMTAgNDdMMTIgNDdMMTIgNDhMMTMgNDhMMTMgNDlMMTIgNDlMMTIgNTBMMTEgNTBMMTEgNDlMOSA0OUw5IDUwTDEwIDUwTDEwIDUyTDExIDUyTDExIDUxTDEyIDUxTDEyIDUzTDEzIDUzTDEzIDUyTDE1IDUyTDE1IDUzTDIyIDUzTDIyIDUyTDE5IDUyTDE5IDUxTDIwIDUxTDIwIDQ5TDIxIDQ5TDIxIDUwTDIyIDUwTDIyIDUxTDIzIDUxTDIzIDUzTDI4IDUzTDI4IDUwTDI5IDUwTDI5IDUxTDMwIDUxTDMwIDUwTDMxIDUwTDMxIDUyTDMwIDUyTDMwIDUzTDMyIDUzTDMyIDUyTDMzIDUyTDMzIDUzTDM0IDUzTDM0IDUyTDM1IDUyTDM1IDUzTDM4IDUzTDM4IDUyTDM1IDUyTDM1IDUxTDM3IDUxTDM3IDUwTDM4IDUwTDM4IDUxTDM5IDUxTDM5IDUyTDQwIDUyTDQwIDUwTDQxIDUwTDQxIDUxTDQyIDUxTDQyIDUwTDQ1IDUwTDQ1IDUxTDQzIDUxTDQzIDUyTDQ0IDUyTDQ0IDUzTDQ3IDUzTDQ3IDUyTDQ4IDUyTDQ4IDUzTDUwIDUzTDUwIDUyTDUxIDUyTDUxIDUxTDUwIDUxTDUwIDUwTDUyIDUwTDUyIDUyTDUzIDUyTDUzIDUwTDUyIDUwTDUyIDQ3TDUxIDQ3TDUxIDQ2TDUwIDQ2TDUwIDQ1TDUxIDQ1TDUxIDQ0TDUwIDQ0TDUwIDQyTDUxIDQyTDUxIDQwTDUyIDQwTDUyIDQ2TDUzIDQ2TDUzIDQwTDUyIDQwTDUyIDM5TDQ5IDM5TDQ5IDM4TDUxIDM4TDUxIDM3TDUyIDM3TDUyIDM4TDUzIDM4TDUzIDM3TDUyIDM3TDUyIDM2TDUwIDM2TDUwIDM1TDQ5IDM1TDQ5IDM0TDUwIDM0TDUwIDMzTDUxIDMzTDUxIDM0TDUyIDM0TDUyIDMzTDUzIDMzTDUzIDMwTDUyIDMwTDUyIDMyTDUwIDMyTDUwIDMxTDQ5IDMxTDQ5IDMwTDUxIDMwTDUxIDI2TDUzIDI2TDUzIDI1TDUyIDI1TDUyIDIzTDUxIDIzTDUxIDIyTDUyIDIyTDUyIDIxTDUxIDIxTDUxIDIyTDUwIDIyTDUwIDIxTDQ5IDIxTDQ5IDIwTDUwIDIwTDUwIDE4TDUyIDE4TDUyIDE5TDUzIDE5TDUzIDE3TDUyIDE3TDUyIDE1TDUxIDE1TDUxIDEzTDUzIDEzTDUzIDEyTDUxIDEyTDUxIDEzTDUwIDEzTDUwIDEwTDQ5IDEwTDQ5IDEyTDQ4IDEyTDQ4IDlMNTAgOUw1MCA4TDQ4IDhMNDggOUw0NSA5TDQ1IDhMNDQgOEw0NCA3TDQ1IDdMNDUgNkw0NCA2TDQ0IDdMNDMgN0w0MyAzTDQ0IDNMNDQgNEw0NSA0TDQ1IDNMNDQgM0w0NCAxTDQzIDFMNDMgMEw0MSAwTDQxIDFMNDIgMUw0MiAyTDQzIDJMNDMgM0wzOSAzTDM5IDZMMzggNkwzOCA3TDM3IDdMMzcgNUwzOCA1TDM4IDRMMzcgNEwzNyAzTDM1IDNMMzUgMEwzNCAwTDM0IDFMMzMgMUwzMyAyTDMwIDJMMzAgNUwzMSA1TDMxIDNMMzIgM0wzMiA0TDM2IDRMMzYgNUwzNSA1TDM1IDZMMzQgNkwzNCA1TDMyIDVMMzIgOEwzMSA4TDMxIDlMMzAgOUwzMCA3TDMxIDdMMzEgNkwzMCA2TDMwIDdMMjkgN0wyOSAyTDI4IDJMMjggMEwyNiAwTDI2IDFMMjUgMUwyNSAwTDI0IDBMMjQgMUwyMiAxTDIyIDBMMjAgMEwyMCAxTDE5IDFMMTkgMFpNMjkgMEwyOSAxTDMxIDFMMzEgMFpNMzYgMEwzNiAyTDM3IDJMMzcgMFpNMzggMEwzOCAyTDM5IDJMMzkgMUw0MCAxTDQwIDBaTTE3IDFMMTcgM0wxOSAzTDE5IDRMMjAgNEwyMCA2TDE5IDZMMTkgOEwyMCA4TDIwIDlMMjEgOUwyMSAxMUwyMCAxMUwyMCAxMEwxOCAxMEwxOCA5TDE3IDlMMTcgMTBMMTggMTBMMTggMTJMMTcgMTJMMTcgMTNMMTYgMTNMMTYgMTRMMTcgMTRMMTcgMTVMMTIgMTVMMTIgMTZMMTYgMTZMMTYgMTdMMTcgMTdMMTcgMTZMMTkgMTZMMTkgMTdMMTggMTdMMTggMTlMMTcgMTlMMTcgMThMMTYgMThMMTYgMTlMMTcgMTlMMTcgMjBMMTUgMjBMMTUgMTlMMTQgMTlMMTQgMjFMMTcgMjFMMTcgMjNMMTUgMjNMMTUgMjJMMTMgMjJMMTMgMjNMMTQgMjNMMTQgMjRMMTcgMjRMMTcgMjNMMTggMjNMMTggMjRMMTkgMjRMMTkgMjVMMTggMjVMMTggMjdMMTcgMjdMMTcgMjVMMTQgMjVMMTQgMzBMMTMgMzBMMTMgMjhMMTAgMjhMMTAgMjdMOSAyN0w5IDMwTDggMzBMOCAyOUw2IDI5TDYgMzBMOCAzMEw4IDMyTDkgMzJMOSAzNEwxMCAzNEwxMCAzM0wxMSAzM0wxMSAzNEwxMiAzNEwxMiAzNUwxNCAzNUwxNCAzNkwxMiAzNkwxMiAzN0wxMyAzN0wxMyAzOUwxNiAzOUwxNiAzOEwxNyAzOEwxNyAzOUwxOCAzOUwxOCAzNkwxOSAzNkwxOSAzN0wyMCAzN0wyMCAzOUwyMSAzOUwyMSA0MUwyMCA0MUwyMCA0MEwxOSA0MEwxOSA0MUwxOCA0MUwxOCA0MEwxNyA0MEwxNyA0MUwxNiA0MUwxNiA0M0wxNSA0M0wxNSA0MEwxMyA0MEwxMyA0MUwxNCA0MUwxNCA0M0wxNSA0M0wxNSA0NUwxOCA0NUwxOCA0N0wxOSA0N0wxOSA0NUwyMCA0NUwyMCA0NEwyMSA0NEwyMSA0NkwyMCA0NkwyMCA0N0wyMSA0N0wyMSA0OEwyMyA0OEwyMyA0N0wyMiA0N0wyMiA0NkwyNCA0NkwyNCA0NEwyOSA0NEwyOSA0NUwzMCA0NUwzMCA0NEwyOSA0NEwyOSA0M0wzMSA0M0wzMSA0NEwzMiA0NEwzMiA0NUwzMSA0NUwzMSA0NkwyOSA0NkwyOSA0N0wzMiA0N0wzMiA0NkwzMyA0NkwzMyA0N0wzNCA0N0wzNCA0OEwzMyA0OEwzMyA1MEwzNSA1MEwzNSA0OUwzNiA0OUwzNiA0OEwzOCA0OEwzOCA0N0wzOSA0N0wzOSA0OUwzOCA0OUwzOCA1MEw0MCA1MEw0MCA0N0w0MyA0N0w0MyA0OUw0NCA0OUw0NCA0NEw0MiA0NEw0MiA0M0w0MyA0M0w0MyA0Mkw0MSA0Mkw0MSA0M0w0MCA0M0w0MCA0MkwzOSA0MkwzOSA0MUw0MSA0MUw0MSA0MEw0MiA0MEw0MiA0MUw0NSA0MUw0NSAzOUw0NiAzOUw0NiA0MUw0NyA0MUw0NyA0MEw0OCA0MEw0OCA0MUw0OSA0MUw0OSA0Mkw0OCA0Mkw0OCA0M0w0OSA0M0w0OSA0Mkw1MCA0Mkw1MCA0MEw0OCA0MEw0OCAzOUw0NyAzOUw0NyAzOEw0NCAzOEw0NCAzN0w0NyAzN0w0NyAzNkw0OCAzNkw0OCAzN0w1MCAzN0w1MCAzNkw0OSAzNkw0OSAzNUw0NyAzNUw0NyAzM0w0NSAzM0w0NSAzNUw0NiAzNUw0NiAzNkw0NCAzNkw0NCAzN0w0MyAzN0w0MyAzNEw0NCAzNEw0NCAzMkw0MiAzMkw0MiAzMUw0MSAzMUw0MSAzMkw0MCAzMkw0MCAzMUwzOSAzMUwzOSAzMkw0MCAzMkw0MCAzM0w0MyAzM0w0MyAzNEw0MiAzNEw0MiAzN0w0MyAzN0w0MyA0MEw0MiA0MEw0MiAzOUw0MSAzOUw0MSAzN0w0MCAzN0w0MCAzNkw0MSAzNkw0MSAzNEwzOSAzNEwzOSAzNUwzNyAzNUwzNyAzN0wzOCAzN0wzOCAzOEwzOSAzOEwzOSA0MEwzNyA0MEwzNyAzOEwzNiAzOEwzNiAzNUwzNCAzNUwzNCAzN0wzMyAzN0wzMyAzOEwzMCAzOEwzMCA0MEwyOCA0MEwyOCA0MUwyNyA0MUwyNyAzN0wzMiAzN0wzMiAzNkwzMyAzNkwzMyAzNEwzMiAzNEwzMiAzNUwzMSAzNUwzMSAzNEwyOSAzNEwyOSAzNUwyOCAzNUwyOCAzNEwyNyAzNEwyNyAzM0wyOCAzM0wyOCAzMkwyOSAzMkwyOSAzMUwzMSAzMUwzMSAzMkwzMiAzMkwzMiAzM0wzMyAzM0wzMyAzMkwzNyAzMkwzNyAzMUwzOCAzMUwzOCAzMEwzOSAzMEwzOSAyOUw0MCAyOUw0MCAzMEw0MSAzMEw0MSAyOEw0MiAyOEw0MiAyN0w0MyAyN0w0MyAyOEw0NCAyOEw0NCAyN0w0MyAyN0w0MyAyNkw0MiAyNkw0MiAyN0w0MCAyN0w0MCAyNkwzOSAyNkwzOSAyNUw0MCAyNUw0MCAyNEwzOSAyNEwzOSAyMkw0MiAyMkw0MiAyM0w0MSAyM0w0MSAyNUw0MiAyNUw0MiAyM0w0NiAyM0w0NiAyNEw1MCAyNEw1MCAyNUw0OSAyNUw0OSAyN0w1MCAyN0w1MCAyNUw1MSAyNUw1MSAyM0w0OSAyM0w0OSAyMUw0NyAyMUw0NyAyMkw0MiAyMkw0MiAyMUw0MSAyMUw0MSAyMEw0MyAyMEw0MyAxOEw0MiAxOEw0MiAxOUw0MSAxOUw0MSAyMEw0MCAyMEw0MCAxOUwzOSAxOUwzOSAxOEw0MSAxOEw0MSAxN0w0MiAxN0w0MiAxNkw0MyAxNkw0MyAxN0w0NCAxN0w0NCAxOEw0NSAxOEw0NSAxOUw0NCAxOUw0NCAyMUw0NSAyMUw0NSAyMEw0NiAyMEw0NiAxOUw0NyAxOUw0NyAxOEw0OCAxOEw0OCAxOUw0OSAxOUw0OSAxOEw0OCAxOEw0OCAxN0w0NiAxN0w0NiAxNUw0NSAxNUw0NSAxN0w0NCAxN0w0NCAxNEw0NSAxNEw0NSAxM0w0NiAxM0w0NiAxNEw0NyAxNEw0NyAxM0w0NiAxM0w0NiAxMkw0NyAxMkw0NyAxMUw0NiAxMUw0NiAxMEw0NCAxMEw0NCAxMkw0NSAxMkw0NSAxM0w0NCAxM0w0NCAxNEw0MiAxNEw0MiAxNkw0MSAxNkw0MSAxM0w0MyAxM0w0MyAxMkw0MiAxMkw0MiAxMUw0MyAxMUw0MyAxMEwzOSAxMEwzOSAxMUwzOCAxMUwzOCAxMEwzNiAxMEwzNiA5TDM1IDlMMzUgMTBMMzYgMTBMMzYgMTFMMzQgMTFMMzQgMTBMMzMgMTBMMzMgMTFMMzIgMTFMMzIgMTBMMjkgMTBMMjkgOUwyOCA5TDI4IDEwTDI3IDEwTDI3IDlMMjUgOUwyNSAxMEwyNCAxMEwyNCAxMUwyMyAxMUwyMyAxM0wyNCAxM0wyNCAxNEwyMiAxNEwyMiAxNUwyMSAxNUwyMSAxN0wyMCAxN0wyMCAxNEwyMSAxNEwyMSAxM0wyMiAxM0wyMiAxMkwyMSAxMkwyMSAxMUwyMiAxMUwyMiA5TDIzIDlMMjMgOEwyNCA4TDI0IDVMMjMgNUwyMyA3TDIyIDdMMjIgNkwyMSA2TDIxIDVMMjIgNUwyMiAzTDIzIDNMMjMgMkwyMiAyTDIyIDFMMjAgMUwyMCAzTDE5IDNMMTkgMVpNMjYgMUwyNiA0TDI4IDRMMjggMkwyNyAyTDI3IDFaTTMzIDJMMzMgM0wzNCAzTDM0IDJaTTI0IDNMMjQgNEwyNSA0TDI1IDNaTTQxIDRMNDEgNUw0MCA1TDQwIDZMMzkgNkwzOSA4TDM3IDhMMzcgN0wzNiA3TDM2IDZMMzUgNkwzNSA3TDM0IDdMMzQgNkwzMyA2TDMzIDhMMzIgOEwzMiA5TDMzIDlMMzMgOEwzNyA4TDM3IDlMNDIgOUw0MiA4TDQzIDhMNDMgOUw0NCA5TDQ0IDhMNDMgOEw0MyA3TDQyIDdMNDIgNkw0MSA2TDQxIDVMNDIgNUw0MiA0Wk0yNSA1TDI1IDhMMjggOEwyOCA1Wk0xNyA2TDE3IDdMMTggN0wxOCA2Wk0yMCA2TDIwIDhMMjEgOEwyMSA2Wk0yNiA2TDI2IDdMMjcgN0wyNyA2Wk00MCA2TDQwIDhMNDIgOEw0MiA3TDQxIDdMNDEgNlpNMTAgN0wxMCA5TDkgOUw5IDEwTDEwIDEwTDEwIDEyTDExIDEyTDExIDEwTDEyIDEwTDEyIDEyTDEzIDEyTDEzIDEzTDEyIDEzTDEyIDE0TDE0IDE0TDE0IDExTDEzIDExTDEzIDEwTDEyIDEwTDEyIDhMMTMgOEwxMyA3TDEyIDdMMTIgOEwxMSA4TDExIDdaTTEgOUwxIDEwTDIgMTBMMiA5Wk01MSA5TDUxIDExTDUyIDExTDUyIDlaTTI1IDEwTDI1IDExTDI0IDExTDI0IDEzTDI2IDEzTDI2IDExTDI3IDExTDI3IDEzTDI4IDEzTDI4IDE0TDI5IDE0TDI5IDE1TDI2IDE1TDI2IDE0TDI1IDE0TDI1IDE1TDIzIDE1TDIzIDE3TDI1IDE3TDI1IDE4TDI2IDE4TDI2IDE5TDI0IDE5TDI0IDE4TDIyIDE4TDIyIDE3TDIxIDE3TDIxIDE4TDIyIDE4TDIyIDE5TDI0IDE5TDI0IDIwTDIzIDIwTDIzIDIyTDI1IDIyTDI1IDIzTDIyIDIzTDIyIDIyTDIxIDIyTDIxIDIwTDIwIDIwTDIwIDE5TDE4IDE5TDE4IDIwTDE3IDIwTDE3IDIxTDE4IDIxTDE4IDIzTDE5IDIzTDE5IDIxTDIwIDIxTDIwIDI0TDIxIDI0TDIxIDIzTDIyIDIzTDIyIDI3TDIxIDI3TDIxIDI2TDIwIDI2TDIwIDI1TDE5IDI1TDE5IDI3TDE4IDI3TDE4IDI4TDE3IDI4TDE3IDI3TDE2IDI3TDE2IDI5TDE1IDI5TDE1IDMxTDE0IDMxTDE0IDMyTDExIDMyTDExIDMzTDE0IDMzTDE0IDM0TDE2IDM0TDE2IDM1TDE3IDM1TDE3IDM2TDE0IDM2TDE0IDM4TDE2IDM4TDE2IDM3TDE3IDM3TDE3IDM2TDE4IDM2TDE4IDM1TDE5IDM1TDE5IDM0TDIxIDM0TDIxIDM1TDIwIDM1TDIwIDM2TDIyIDM2TDIyIDM4TDIzIDM4TDIzIDM3TDI1IDM3TDI1IDM4TDI0IDM4TDI0IDM5TDIzIDM5TDIzIDQxTDIyIDQxTDIyIDQzTDIxIDQzTDIxIDQyTDIwIDQyTDIwIDQxTDE5IDQxTDE5IDQyTDIwIDQyTDIwIDQzTDIxIDQzTDIxIDQ0TDIyIDQ0TDIyIDQzTDIzIDQzTDIzIDQ0TDI0IDQ0TDI0IDQzTDI2IDQzTDI2IDQyTDI3IDQyTDI3IDQzTDI4IDQzTDI4IDQyTDMxIDQyTDMxIDQzTDM0IDQzTDM0IDQ0TDM1IDQ0TDM1IDQ1TDMzIDQ1TDMzIDQ2TDM0IDQ2TDM0IDQ3TDM1IDQ3TDM1IDQ4TDM0IDQ4TDM0IDQ5TDM1IDQ5TDM1IDQ4TDM2IDQ4TDM2IDQ3TDM1IDQ3TDM1IDQ2TDM3IDQ2TDM3IDQ3TDM4IDQ3TDM4IDQ2TDM5IDQ2TDM5IDQ0TDQwIDQ0TDQwIDQzTDM4IDQzTDM4IDQxTDM3IDQxTDM3IDQwTDM2IDQwTDM2IDM4TDM0IDM4TDM0IDM5TDMzIDM5TDMzIDQwTDM0IDQwTDM0IDQxTDMzIDQxTDMzIDQyTDMxIDQyTDMxIDQxTDMyIDQxTDMyIDM5TDMxIDM5TDMxIDQxTDI4IDQxTDI4IDQyTDI3IDQyTDI3IDQxTDI2IDQxTDI2IDQyTDI0IDQyTDI0IDQxTDI1IDQxTDI1IDQwTDI2IDQwTDI2IDM5TDI1IDM5TDI1IDM4TDI2IDM4TDI2IDM3TDI3IDM3TDI3IDM2TDI4IDM2TDI4IDM1TDI3IDM1TDI3IDM0TDI2IDM0TDI2IDMyTDI1IDMyTDI1IDMxTDI0IDMxTDI0IDMwTDI1IDMwTDI1IDI5TDI3IDI5TDI3IDMwTDI2IDMwTDI2IDMxTDI3IDMxTDI3IDMyTDI4IDMyTDI4IDMxTDI5IDMxTDI5IDMwTDI4IDMwTDI4IDI5TDMwIDI5TDMwIDMwTDMxIDMwTDMxIDMxTDMyIDMxTDMyIDMyTDMzIDMyTDMzIDMxTDM3IDMxTDM3IDMwTDM4IDMwTDM4IDI4TDM5IDI4TDM5IDI2TDM4IDI2TDM4IDI4TDM3IDI4TDM3IDI0TDM2IDI0TDM2IDI1TDM1IDI1TDM1IDI0TDM0IDI0TDM0IDIzTDM1IDIzTDM1IDIxTDM3IDIxTDM3IDIzTDM4IDIzTDM4IDIyTDM5IDIyTDM5IDIwTDM4IDIwTDM4IDE2TDM1IDE2TDM1IDE1TDM2IDE1TDM2IDE0TDM4IDE0TDM4IDEzTDM5IDEzTDM5IDEyTDQwIDEyTDQwIDEzTDQxIDEzTDQxIDEyTDQwIDEyTDQwIDExTDM5IDExTDM5IDEyTDM4IDEyTDM4IDExTDM3IDExTDM3IDEyTDM2IDEyTDM2IDE0TDM0IDE0TDM0IDExTDMzIDExTDMzIDEyTDMyIDEyTDMyIDE0TDMxIDE0TDMxIDEzTDMwIDEzTDMwIDExTDI3IDExTDI3IDEwWk02IDExTDYgMTJMNSAxMkw1IDEzTDYgMTNMNiAxNEw5IDE0TDkgMTNMNiAxM0w2IDEyTDcgMTJMNyAxMVpNOCAxMUw4IDEyTDkgMTJMOSAxMVpNNDUgMTFMNDUgMTJMNDYgMTJMNDYgMTFaTTE4IDEyTDE4IDEzTDE3IDEzTDE3IDE0TDE4IDE0TDE4IDE1TDE5IDE1TDE5IDE0TDIwIDE0TDIwIDEzTDIxIDEzTDIxIDEyWk0yOCAxMkwyOCAxM0wyOSAxM0wyOSAxNEwzMCAxNEwzMCAxNUwzMSAxNUwzMSAxNkwzMiAxNkwzMiAxN0wzMSAxN0wzMSAxOEwyOSAxOEwyOSAxN0wyNyAxN0wyNyAxNkwyNSAxNkwyNSAxN0wyNiAxN0wyNiAxOEwyNyAxOEwyNyAxOUwyNiAxOUwyNiAyMEwyNyAyMEwyNyAyMUwyNSAyMUwyNSAyMkwyNiAyMkwyNiAyNEwyOSAyNEwyOSAyMUwyOCAyMUwyOCAxOEwyOSAxOEwyOSAyMEwzMCAyMEwzMCAyMUwzMSAyMUwzMSAyMkwzMCAyMkwzMCAyM0wzMSAyM0wzMSAyNEwzMCAyNEwzMCAyNUwzMSAyNUwzMSAyNkwyOSAyNkwyOSAyOEwzMSAyOEwzMSAyOUwzMiAyOUwzMiAzMUwzMyAzMUwzMyAyN0wzNCAyN0wzNCAyNkwzNSAyNkwzNSAyNUwzNCAyNUwzNCAyNEwzMyAyNEwzMyAyNUwzNCAyNUwzNCAyNkwzMiAyNkwzMiAyM0wzMyAyM0wzMyAyMUwzNSAyMUwzNSAyMEwzNyAyMEwzNyAyMUwzOCAyMUwzOCAyMEwzNyAyMEwzNyAxOEwzNiAxOEwzNiAxN0wzNCAxN0wzNCAxNEwzMyAxNEwzMyAxNUwzMSAxNUwzMSAxNEwzMCAxNEwzMCAxM0wyOSAxM0wyOSAxMlpNMzcgMTJMMzcgMTNMMzggMTNMMzggMTJaTTIgMTNMMiAxNEwxIDE0TDEgMTZMMCAxNkwwIDE4TDEgMThMMSAxOUwyIDE5TDIgMjBMMCAyMEwwIDIxTDEgMjFMMSAyMkwwIDIyTDAgMjNMMiAyM0wyIDIwTDMgMjBMMyAxOEw1IDE4TDUgMTVMNCAxNUw0IDE0TDMgMTRMMyAxM1pNMTAgMTNMMTAgMTRMMTEgMTRMMTEgMTNaTTE4IDEzTDE4IDE0TDE5IDE0TDE5IDEzWk00OCAxM0w0OCAxNEw0OSAxNEw0OSAxNUw0NyAxNUw0NyAxNkw0OSAxNkw0OSAxN0w1MCAxN0w1MCAxM1pNMiAxNEwyIDE3TDEgMTdMMSAxOEwzIDE4TDMgMTdMNCAxN0w0IDE1TDMgMTVMMyAxNFpNMzkgMTVMMzkgMTZMNDAgMTZMNDAgMTVaTTYgMTZMNiAxN0w4IDE3TDggMTZaTTE5IDE3TDE5IDE4TDIwIDE4TDIwIDE3Wk0zMyAxN0wzMyAxOEwzNCAxOEwzNCAxN1pNNDUgMTdMNDUgMThMNDYgMThMNDYgMTdaTTYgMTlMNiAyMEw3IDIwTDcgMTlaTTMwIDE5TDMwIDIwTDMxIDIwTDMxIDIxTDMyIDIxTDMyIDIwTDMxIDIwTDMxIDE5Wk0zMyAxOUwzMyAyMEwzNCAyMEwzNCAxOVpNOSAyMEw5IDIxTDExIDIxTDExIDIwWk0zMSAyMkwzMSAyM0wzMiAyM0wzMiAyMlpNMTAgMjNMMTAgMjRMOSAyNEw5IDI2TDEwIDI2TDEwIDI0TDExIDI0TDExIDIzWk0zIDI0TDMgMjVMNCAyNUw0IDI0Wk0xMiAyNEwxMiAyNkwxMSAyNkwxMSAyN0wxMiAyN0wxMiAyNkwxMyAyNkwxMyAyNFpNNDMgMjRMNDMgMjVMNDQgMjVMNDQgMjRaTTUgMjVMNSAyOEw4IDI4TDggMjVaTTI1IDI1TDI1IDI4TDI4IDI4TDI4IDI1Wk00NSAyNUw0NSAyOEw0OCAyOEw0OCAyNVpNNiAyNkw2IDI3TDcgMjdMNyAyNlpNMjMgMjZMMjMgMjdMMjIgMjdMMjIgMjhMMTkgMjhMMTkgMjlMMjAgMjlMMjAgMzBMMTkgMzBMMTkgMzJMMjAgMzJMMjAgMzBMMjIgMzBMMjIgMjlMMjMgMjlMMjMgMjhMMjQgMjhMMjQgMjZaTTI2IDI2TDI2IDI3TDI3IDI3TDI3IDI2Wk00NiAyNkw0NiAyN0w0NyAyN0w0NyAyNlpNMzEgMjdMMzEgMjhMMzIgMjhMMzIgMjdaTTM1IDI3TDM1IDI4TDM0IDI4TDM0IDMwTDM1IDMwTDM1IDI4TDM2IDI4TDM2IDI3Wk01MiAyN0w1MiAyOEw1MyAyOEw1MyAyN1pNNDkgMjhMNDkgMjlMNTAgMjlMNTAgMjhaTTAgMjlMMCAzMEwxIDMwTDEgMjlaTTEwIDI5TDEwIDMwTDkgMzBMOSAzMkwxMCAzMkwxMCAzMEwxMiAzMEwxMiAyOVpNMTYgMjlMMTYgMzFMMTcgMzFMMTcgMzJMMTUgMzJMMTUgMzNMMTggMzNMMTggMzRMMTcgMzRMMTcgMzVMMTggMzVMMTggMzRMMTkgMzRMMTkgMzNMMTggMzNMMTggMjlaTTM2IDI5TDM2IDMwTDM3IDMwTDM3IDI5Wk00NCAyOUw0NCAzMEw0NyAzMEw0NyAyOVpNNiAzMUw2IDMyTDcgMzJMNyAzMVpNMjEgMzFMMjEgMzJMMjIgMzJMMjIgMzRMMjMgMzRMMjMgMzZMMjUgMzZMMjUgMzdMMjYgMzdMMjYgMzZMMjcgMzZMMjcgMzVMMjYgMzVMMjYgMzZMMjUgMzZMMjUgMzJMMjQgMzJMMjQgMzFMMjMgMzFMMjMgMzJMMjIgMzJMMjIgMzFaTTQ1IDMxTDQ1IDMyTDQ2IDMyTDQ2IDMxWk00OCAzMUw0OCAzMkw0OSAzMkw0OSAzM0w1MCAzM0w1MCAzMkw0OSAzMkw0OSAzMVpNMjMgMzJMMjMgMzRMMjQgMzRMMjQgMzJaTTM1IDMzTDM1IDM0TDM2IDM0TDM2IDMzWk0wIDM0TDAgMzVMMSAzNUwxIDM0Wk0yOSAzNUwyOSAzNkwzMSAzNkwzMSAzNVpNMzkgMzVMMzkgMzZMMzggMzZMMzggMzdMMzkgMzdMMzkgMzZMNDAgMzZMNDAgMzVaTTYgMzdMNiAzOEw3IDM4TDcgMzdaTTAgMzhMMCAzOUwxIDM5TDEgMzhaTTIgMzhMMiA0MEwxIDQwTDEgNDFMMCA0MUwwIDQzTDEgNDNMMSA0NEwzIDQ0TDMgNDVMNCA0NUw0IDQ0TDMgNDRMMyA0M0w3IDQzTDcgNDJMNiA0Mkw2IDQxTDcgNDFMNyA0MEw0IDQwTDQgNDFMMyA0MUwzIDM5TDQgMzlMNCAzOFpNMjggMzhMMjggMzlMMjkgMzlMMjkgMzhaTTEgNDFMMSA0MkwyIDQyTDIgNDNMMyA0M0wzIDQxWk00IDQxTDQgNDJMNSA0Mkw1IDQxWk0zNCA0MUwzNCA0M0wzNSA0M0wzNSA0NEwzNiA0NEwzNiA0M0wzNSA0M0wzNSA0MVpNMzYgNDFMMzYgNDJMMzcgNDJMMzcgNDFaTTE3IDQyTDE3IDQzTDE4IDQzTDE4IDQyWk00NSA0Mkw0NSA0NEw0NyA0NEw0NyA0M0w0NiA0M0w0NiA0MlpNMzcgNDNMMzcgNDVMMzggNDVMMzggNDNaTTYgNDRMNiA0NUw3IDQ1TDcgNDRaTTE4IDQ0TDE4IDQ1TDE5IDQ1TDE5IDQ0Wk00MSA0NEw0MSA0NUw0MCA0NUw0MCA0Nkw0MyA0Nkw0MyA0NUw0MiA0NUw0MiA0NFpNNDkgNDRMNDkgNDVMNTAgNDVMNTAgNDRaTTI1IDQ1TDI1IDQ4TDI4IDQ4TDI4IDQ1Wk00NSA0NUw0NSA0OEw0OCA0OEw0OCA0NVpNMTQgNDZMMTQgNDhMMTYgNDhMMTYgNTFMMTUgNTFMMTUgNTBMMTQgNTBMMTQgNDlMMTMgNDlMMTMgNTBMMTIgNTBMMTIgNTFMMTUgNTFMMTUgNTJMMTggNTJMMTggNTBMMTkgNTBMMTkgNDlMMjAgNDlMMjAgNDhMMTkgNDhMMTkgNDlMMTggNDlMMTggNDhMMTcgNDhMMTcgNDZaTTI2IDQ2TDI2IDQ3TDI3IDQ3TDI3IDQ2Wk00NiA0Nkw0NiA0N0w0NyA0N0w0NyA0NlpNNTAgNDdMNTAgNDlMNTEgNDlMNTEgNDdaTTMxIDQ4TDMxIDQ5TDMyIDQ5TDMyIDQ4Wk00MSA0OEw0MSA0OUw0MiA0OUw0MiA0OFpNMjMgNDlMMjMgNTFMMjQgNTFMMjQgNTJMMjUgNTJMMjUgNTFMMjYgNTFMMjYgNTJMMjcgNTJMMjcgNTFMMjYgNTFMMjYgNTBMMjcgNTBMMjcgNDlMMjYgNDlMMjYgNTBMMjUgNTBMMjUgNDlaTTQ2IDQ5TDQ2IDUxTDQ3IDUxTDQ3IDUwTDQ5IDUwTDQ5IDQ5Wk0yNCA1MEwyNCA1MUwyNSA1MUwyNSA1MFpNOCA1MUw4IDUzTDkgNTNMOSA1MVpNMzMgNTFMMzMgNTJMMzQgNTJMMzQgNTFaTTQ4IDUxTDQ4IDUyTDQ5IDUyTDQ5IDUxWk00MSA1Mkw0MSA1M0w0MiA1M0w0MiA1MlpNMCAwTDAgN0w3IDdMNyAwWk0xIDFMMSA2TDYgNkw2IDFaTTIgMkwyIDVMNSA1TDUgMlpNNDYgMEw0NiA3TDUzIDdMNTMgMFpNNDcgMUw0NyA2TDUyIDZMNTIgMVpNNDggMkw0OCA1TDUxIDVMNTEgMlpNMCA0NkwwIDUzTDcgNTNMNyA0NlpNMSA0N0wxIDUyTDYgNTJMNiA0N1pNMiA0OEwyIDUxTDUgNTFMNSA0OFoiIGZpbGw9IiMwMDAwMDAiLz48L2c+PC9nPjwvc3ZnPgo=', '2026-09-14 20:01:36', '2026-09-14 20:02:59'),
(3, 4, NULL, 'TCK-PQPE6JS4OIIB', 'qheremef@gmail.com', 'Henrietta', '+233241877552', 1, 'vip', 300, 'GHS', 'paid', 0, NULL, 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjI2MCIgaGVpZ2h0PSIyNjAiIHZpZXdCb3g9IjAgMCAyNjAgMjYwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMjYwIiBoZWlnaHQ9IjI2MCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoNC45MDYpIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLDApIj48cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik05IDBMOSAxTDExIDFMMTEgMkwxMiAyTDEyIDRMMTMgNEwxMyA1TDE0IDVMMTQgNEwxNSA0TDE1IDNMMTYgM0wxNiAyTDE1IDJMMTUgM0wxNCAzTDE0IDJMMTMgMkwxMyAxTDE0IDFMMTQgMEwxMyAwTDEzIDFMMTEgMUwxMSAwWk0xNiAwTDE2IDFMMTcgMUwxNyA0TDIwIDRMMjAgM0wxOSAzTDE5IDJMMTggMkwxOCAwWk0yMCAwTDIwIDJMMjIgMkwyMiAzTDIxIDNMMjEgNEwyMiA0TDIyIDdMMjMgN0wyMyA5TDI0IDlMMjQgMTBMMjMgMTBMMjMgMTFMMjIgMTFMMjIgMTZMMjQgMTZMMjQgMTdMMjIgMTdMMjIgMTlMMjAgMTlMMjAgMTdMMjEgMTdMMjEgMTVMMjAgMTVMMjAgMTJMMTkgMTJMMTkgMTFMMjAgMTFMMjAgMTBMMjEgMTBMMjEgOUwxOSA5TDE5IDhMMjEgOEwyMSA1TDIwIDVMMjAgN0wxOSA3TDE5IDVMMTggNUwxOCA3TDE3IDdMMTcgNkwxNiA2TDE2IDdMMTcgN0wxNyA4TDE2IDhMMTYgOUwxNSA5TDE1IDExTDE0IDExTDE0IDEwTDEzIDEwTDEzIDlMMTQgOUwxNCA3TDE1IDdMMTUgNkwxNCA2TDE0IDdMMTMgN0wxMyA2TDEyIDZMMTIgN0wxMSA3TDExIDZMMTAgNkwxMCA4TDEyIDhMMTIgN0wxMyA3TDEzIDlMMTIgOUwxMiAxMEwxMSAxMEwxMSA5TDEwIDlMMTAgMTBMOSAxMEw5IDlMOCA5TDggOEw1IDhMNSA5TDIgOUwyIDhMMCA4TDAgOUwyIDlMMiAxMEwxIDEwTDEgMTFMMiAxMUwyIDEyTDAgMTJMMCAxM0wxIDEzTDEgMTRMMCAxNEwwIDE1TDIgMTVMMiAxMkwzIDEyTDMgMTVMNCAxNUw0IDE2TDIgMTZMMiAxN0w0IDE3TDQgMTZMNSAxNkw1IDE5TDcgMTlMNyAyMEw2IDIwTDYgMjFMNyAyMUw3IDIyTDUgMjJMNSAyMEwzIDIwTDMgMjFMMSAyMUwxIDIwTDIgMjBMMiAxOUwxIDE5TDEgMjBMMCAyMEwwIDIxTDEgMjFMMSAyMkwwIDIyTDAgMjNMMSAyM0wxIDI2TDAgMjZMMCAyOUwxIDI5TDEgMzBMMCAzMEwwIDMzTDEgMzNMMSAzMEwyIDMwTDIgMjlMMyAyOUwzIDMxTDIgMzFMMiAzMkwzIDMyTDMgMzNMNyAzM0w3IDM0TDYgMzRMNiAzNUw3IDM1TDcgMzZMNSAzNkw1IDM4TDIgMzhMMiAzNkwzIDM2TDMgMzRMMSAzNEwxIDM1TDAgMzVMMCAzN0wxIDM3TDEgMzhMMCAzOEwwIDQxTDIgNDFMMiAzOUw1IDM5TDUgNDJMNCA0Mkw0IDQxTDMgNDFMMyA0M0wyIDQzTDIgNDJMMCA0MkwwIDQzTDEgNDNMMSA0NEwzIDQ0TDMgNDVMNCA0NUw0IDQ0TDMgNDRMMyA0M0w3IDQzTDcgNDJMNiA0Mkw2IDQxTDggNDFMOCA0MkwxMCA0MkwxMCA0MEwxNSA0MEwxNSA0NEwxMyA0NEwxMyA0NkwxMiA0NkwxMiA0N0wxNCA0N0wxNCA0NUwxNSA0NUwxNSA0NkwxNiA0NkwxNiA0N0wxNSA0N0wxNSA1MEwxNiA1MEwxNiA0OEwxOCA0OEwxOCA0OUwxNyA0OUwxNyA1MEwxOSA1MEwxOSA1MUwyMSA1MUwyMSA1MkwxNSA1MkwxNSA1MUwxNCA1MUwxNCA1MkwxNSA1MkwxNSA1M0wyMiA1M0wyMiA1MkwyMyA1MkwyMyA1M0wyNiA1M0wyNiA1MkwyMyA1MkwyMyA0OUwyNCA0OUwyNCA1MUwyNyA1MUwyNyA1MEwyOCA1MEwyOCA1MUwyOSA1MUwyOSA0N0wzMCA0N0wzMCA0OEwzMiA0OEwzMiA1MEwzNCA1MEwzNCA1MUwzMCA1MUwzMCA1M0wzMiA1M0wzMiA1MkwzNCA1MkwzNCA1MUwzNiA1MUwzNiA1MkwzNSA1MkwzNSA1M0wzNyA1M0wzNyA1MkwzOCA1MkwzOCA1M0wzOSA1M0wzOSA1Mkw0MiA1Mkw0MiA1M0w0MyA1M0w0MyA1MUw0NCA1MUw0NCA0OUw0NSA0OUw0NSA1MEw0NiA1MEw0NiA0OUw1MCA0OUw1MCA0Nkw0OSA0Nkw0OSA0NUw1MSA0NUw1MSA0Nkw1MyA0Nkw1MyA0NUw1MSA0NUw1MSA0NEw1MCA0NEw1MCA0M0w1MSA0M0w1MSA0MUw1MiA0MUw1MiA0M0w1MyA0M0w1MyA0MUw1MiA0MUw1MiA0MEw1MSA0MEw1MSAzN0w1MiAzN0w1MiAzOEw1MyAzOEw1MyAzN0w1MiAzN0w1MiAzNkw1MCAzNkw1MCAzNUw1MSAzNUw1MSAzNEw1MiAzNEw1MiAzM0w1MSAzM0w1MSAzMkw1MCAzMkw1MCAzM0w1MSAzM0w1MSAzNEw1MCAzNEw1MCAzNUw0OSAzNUw0OSAzN0w0OCAzN0w0OCAzNUw0NSAzNUw0NSAzN0w0NiAzN0w0NiAzOEw0OSAzOEw0OSA0MEw1MCA0MEw1MCA0MUw0NyA0MUw0NyA0MEw0OCA0MEw0OCAzOUw0NyAzOUw0NyA0MEw0NSA0MEw0NSAzOEw0NCAzOEw0NCAzNUw0MyAzNUw0MyAzNkw0MiAzNkw0MiAzNEw0MyAzNEw0MyAzM0w0MSAzM0w0MSAzNEw0MCAzNEw0MCAzNUwzOSAzNUwzOSAzM0wzOCAzM0wzOCAzMUwzNyAzMUwzNyAzMkwzNiAzMkwzNiAzM0wzNyAzM0wzNyAzNEwzNSAzNEwzNSAzM0wzNCAzM0wzNCAzMkwzNSAzMkwzNSAzMUwzNiAzMUwzNiAzMEwzNSAzMEwzNSAzMUwzNCAzMUwzNCAyOUwzNyAyOUwzNyAzMEwzOCAzMEwzOCAyOUwzOSAyOUwzOSAzMUw0MCAzMUw0MCAzMkw0MiAzMkw0MiAzMEw0MyAzMEw0MyAyOUw0NCAyOUw0NCAzMUw0MyAzMUw0MyAzMkw0NCAzMkw0NCAzM0w0NSAzM0w0NSAzMkw0OCAzMkw0OCAzM0w0NyAzM0w0NyAzNEw0OSAzNEw0OSAzMkw0OCAzMkw0OCAzMUw0NyAzMUw0NyAzMEw1MSAzMEw1MSAyNkw1MyAyNkw1MyAyNEw1MiAyNEw1MiAyM0w1MSAyM0w1MSAyMkw1MyAyMkw1MyAyMUw1MSAyMUw1MSAyMkw1MCAyMkw1MCAyM0w1MSAyM0w1MSAyNUw1MCAyNUw1MCAyNEw0OCAyNEw0OCAyM0w0NyAyM0w0NyAyNEw0NiAyNEw0NiAyM0w0NSAyM0w0NSAyMkw0NyAyMkw0NyAyMUw0OSAyMUw0OSAyMEw1MCAyMEw1MCAxOUw1MSAxOUw1MSAxOEw1MiAxOEw1MiAxOUw1MyAxOUw1MyAxN0w1MSAxN0w1MSAxNkw1MiAxNkw1MiAxNUw1MSAxNUw1MSAxNEw1MiAxNEw1MiAxM0w1MyAxM0w1MyAxMkw1MSAxMkw1MSAxNEw0OSAxNEw0OSAxM0w1MCAxM0w1MCAxMEw1MiAxMEw1MiA5TDUwIDlMNTAgOEw0OCA4TDQ4IDlMNDYgOUw0NiAxMEw0NSAxMEw0NSA4TDQ0IDhMNDQgOUw0MiA5TDQyIDhMNDMgOEw0MyAzTDQ0IDNMNDQgNEw0NSA0TDQ1IDNMNDQgM0w0NCAxTDQzIDFMNDMgMEw0MiAwTDQyIDFMNDAgMUw0MCAyTDM5IDJMMzkgMEwzNiAwTDM2IDFMMzUgMUwzNSAwTDM0IDBMMzQgMUwzMSAxTDMxIDBMMzAgMEwzMCAxTDI5IDFMMjkgMkwyOCAyTDI4IDFMMjcgMUwyNyAwTDI0IDBMMjQgM0wyNSAzTDI1IDRMMjQgNEwyNCA3TDIzIDdMMjMgMEwyMiAwTDIyIDFMMjEgMUwyMSAwWk0yNiAxTDI2IDRMMjcgNEwyNyAxWk0zMCAxTDMwIDJMMjkgMkwyOSAzTDI4IDNMMjggNEwzMSA0TDMxIDlMMzQgOUwzNCA4TDM3IDhMMzcgN0wzOCA3TDM4IDZMMzkgNkwzOSA4TDM4IDhMMzggOUw0MCA5TDQwIDEwTDM5IDEwTDM5IDExTDM4IDExTDM4IDEwTDM2IDEwTDM2IDlMMzUgOUwzNSAxM0wzNCAxM0wzNCAxNUwzNSAxNUwzNSAxNkwzNCAxNkwzNCAxOUwzMyAxOUwzMyAyMEwzMSAyMEwzMSAxOUwzMiAxOUwzMiAxOEwzMCAxOEwzMCAxOUwyNyAxOUwyNyAxN0wyOSAxN0wyOSAxNkwyNyAxNkwyNyAxN0wyNiAxN0wyNiAxNkwyNSAxNkwyNSAxOEwyNCAxOEwyNCAxOUwyNSAxOUwyNSAyMUwyNiAyMUwyNiAyMkwyNCAyMkwyNCAyMUwyMyAyMUwyMyAxOUwyMiAxOUwyMiAyMEwyMSAyMEwyMSAyMUwyMiAyMUwyMiAyMkwyMSAyMkwyMSAyM0wyMiAyM0wyMiAyMkwyNCAyMkwyNCAyM0wyNiAyM0wyNiAyNEwyOCAyNEwyOCAyM0wyOSAyM0wyOSAyNEwzMCAyNEwzMCAyNUwzMSAyNUwzMSAyNkwyOSAyNkwyOSAyN0wzMSAyN0wzMSAyOEwyOSAyOEwyOSAyOUwyOCAyOUwyOCAzMkwyNiAzMkwyNiAzNEwyNSAzNEwyNSAzM0wyNCAzM0wyNCAzNEwyMyAzNEwyMyAzMkwyMiAzMkwyMiAzMUwyMyAzMUwyMyAzMEwyMiAzMEwyMiAyOUwyMyAyOUwyMyAyOEwyNCAyOEwyNCAyN0wyMyAyN0wyMyAyNkwyNCAyNkwyNCAyNEwyMyAyNEwyMyAyNUwyMiAyNUwyMiAyNEwyMCAyNEwyMCAyM0wxOCAyM0wxOCAyMUwxNyAyMUwxNyAxN0wxOCAxN0wxOCAxOUwxOSAxOUwxOSAyMUwyMCAyMUwyMCAxOUwxOSAxOUwxOSAxN0wxOCAxN0wxOCAxNkwxNyAxNkwxNyAxNUwxOSAxNUwxOSAxM0wxOCAxM0wxOCAxMkwxNyAxMkwxNyAxMEwxNiAxMEwxNiAxMkwxNSAxMkwxNSAxM0wxNCAxM0wxNCAxMkwxMyAxMkwxMyAxNEwxMSAxNEwxMSAxM0wxMiAxM0wxMiAxMkwxMSAxMkwxMSAxMEwxMCAxMEwxMCAxMUw5IDExTDkgMTBMOCAxMEw4IDlMNiA5TDYgMTBMNSAxMEw1IDExTDQgMTFMNCAxM0w1IDEzTDUgMTJMNyAxMkw3IDEzTDYgMTNMNiAxNEw3IDE0TDcgMTNMOCAxM0w4IDE1TDUgMTVMNSAxNkw3IDE2TDcgMTdMNiAxN0w2IDE4TDggMThMOCAxN0w5IDE3TDkgMThMMTAgMThMMTAgMTlMOCAxOUw4IDIwTDkgMjBMOSAyMUw4IDIxTDggMjJMNyAyMkw3IDIzTDYgMjNMNiAyNEw3IDI0TDcgMjNMOCAyM0w4IDIyTDEwIDIyTDEwIDIzTDkgMjNMOSAyOUw4IDI5TDggMzFMMTAgMzFMMTAgMzBMMTEgMzBMMTEgMzFMMTMgMzFMMTMgMzJMMTQgMzJMMTQgMzFMMTUgMzFMMTUgMjVMMTMgMjVMMTMgMjRMMTIgMjRMMTIgMjVMMTEgMjVMMTEgMjRMMTAgMjRMMTAgMjNMMTIgMjNMMTIgMjJMMTMgMjJMMTMgMjNMMTQgMjNMMTQgMjRMMTcgMjRMMTcgMjVMMTYgMjVMMTYgMjZMMTcgMjZMMTcgMjhMMTYgMjhMMTYgMzBMMTcgMzBMMTcgMjlMMTggMjlMMTggMzFMMjEgMzFMMjEgMzNMMjIgMzNMMjIgMzRMMjMgMzRMMjMgMzVMMjIgMzVMMjIgMzZMMjEgMzZMMjEgMzVMMTggMzVMMTggMzRMMTcgMzRMMTcgMzVMMTYgMzVMMTYgMzZMMTcgMzZMMTcgMzdMMTYgMzdMMTYgMzlMMTUgMzlMMTUgMzdMMTQgMzdMMTQgMzNMMTIgMzNMMTIgMzRMMTEgMzRMMTEgMzJMOCAzMkw4IDM0TDcgMzRMNyAzNUw4IDM1TDggMzZMOSAzNkw5IDM4TDggMzhMOCAzN0w2IDM3TDYgMzhMNyAzOEw3IDM5TDYgMzlMNiA0MEw3IDQwTDcgMzlMOCAzOUw4IDQwTDEwIDQwTDEwIDM5TDExIDM5TDExIDM3TDE0IDM3TDE0IDM4TDEzIDM4TDEzIDM5TDE1IDM5TDE1IDQwTDE2IDQwTDE2IDQyTDE4IDQyTDE4IDQzTDE5IDQzTDE5IDQ0TDIwIDQ0TDIwIDQzTDE5IDQzTDE5IDQxTDIwIDQxTDIwIDQyTDIxIDQyTDIxIDQ1TDIyIDQ1TDIyIDQ4TDE5IDQ4TDE5IDQ1TDE3IDQ1TDE3IDQ3TDE4IDQ3TDE4IDQ4TDE5IDQ4TDE5IDQ5TDIwIDQ5TDIwIDUwTDIyIDUwTDIyIDQ4TDIzIDQ4TDIzIDQ3TDI0IDQ3TDI0IDQ2TDIzIDQ2TDIzIDQ1TDI0IDQ1TDI0IDQ0TDIyIDQ0TDIyIDQyTDIzIDQyTDIzIDQwTDI0IDQwTDI0IDM4TDI2IDM4TDI2IDM5TDI1IDM5TDI1IDQwTDI2IDQwTDI2IDQxTDI0IDQxTDI0IDQzTDI2IDQzTDI2IDQ0TDI3IDQ0TDI3IDQyTDI2IDQyTDI2IDQxTDI3IDQxTDI3IDQwTDI2IDQwTDI2IDM5TDI3IDM5TDI3IDM4TDI2IDM4TDI2IDM0TDI3IDM0TDI3IDM1TDI4IDM1TDI4IDM2TDI3IDM2TDI3IDM3TDI4IDM3TDI4IDM4TDI5IDM4TDI5IDQwTDMxIDQwTDMxIDM5TDMwIDM5TDMwIDM4TDI5IDM4TDI5IDM3TDI4IDM3TDI4IDM2TDI5IDM2TDI5IDM1TDMwIDM1TDMwIDM3TDMyIDM3TDMyIDQxTDMzIDQxTDMzIDM3TDMyIDM3TDMyIDM1TDMzIDM1TDMzIDM0TDMyIDM0TDMyIDM1TDMxIDM1TDMxIDM0TDI5IDM0TDI5IDM1TDI4IDM1TDI4IDM0TDI3IDM0TDI3IDMzTDMwIDMzTDMwIDMyTDMxIDMyTDMxIDMxTDMyIDMxTDMyIDMwTDMzIDMwTDMzIDI4TDM1IDI4TDM1IDI3TDMzIDI3TDMzIDI2TDMyIDI2TDMyIDIzTDMzIDIzTDMzIDIxTDM0IDIxTDM0IDIwTDM1IDIwTDM1IDE5TDM2IDE5TDM2IDE3TDM1IDE3TDM1IDE2TDM3IDE2TDM3IDE3TDM4IDE3TDM4IDE4TDM3IDE4TDM3IDE5TDM5IDE5TDM5IDE4TDQwIDE4TDQwIDE3TDQ0IDE3TDQ0IDIxTDQ3IDIxTDQ3IDIwTDQ5IDIwTDQ5IDE5TDUwIDE5TDUwIDE3TDQ3IDE3TDQ3IDE2TDUwIDE2TDUwIDE1TDQ5IDE1TDQ5IDE0TDQ4IDE0TDQ4IDEyTDQ2IDEyTDQ2IDExTDQ1IDExTDQ1IDEwTDQ0IDEwTDQ0IDExTDQzIDExTDQzIDEwTDQyIDEwTDQyIDExTDQwIDExTDQwIDEwTDQxIDEwTDQxIDhMNDAgOEw0MCA2TDQxIDZMNDEgN0w0MiA3TDQyIDRMNDEgNEw0MSA1TDQwIDVMNDAgNkwzOSA2TDM5IDJMMzggMkwzOCAxTDM3IDFMMzcgMkwzNSAyTDM1IDNMMzcgM0wzNyA0TDM4IDRMMzggNUwzNSA1TDM1IDRMMzEgNEwzMSAxWk05IDJMOSAzTDggM0w4IDVMOSA1TDkgNEwxMCA0TDEwIDVMMTEgNUwxMSA0TDEwIDRMMTAgMlpNMzIgMkwzMiAzTDMzIDNMMzMgMlpNNDAgMkw0MCAzTDQzIDNMNDMgMlpNMjUgNUwyNSA4TDI4IDhMMjggNVpNMjkgNUwyOSA5TDI4IDlMMjggMTFMMjkgMTFMMjkgMTNMMzIgMTNMMzIgMTRMMzEgMTRMMzEgMTZMMzIgMTZMMzIgMTdMMzMgMTdMMzMgMTVMMzIgMTVMMzIgMTRMMzMgMTRMMzMgMTNMMzIgMTNMMzIgMTJMMzAgMTJMMzAgMTFMMzEgMTFMMzEgMTBMMzAgMTBMMzAgMTFMMjkgMTFMMjkgOUwzMCA5TDMwIDVaTTggNkw4IDdMOSA3TDkgNlpNMjYgNkwyNiA3TDI3IDdMMjcgNlpNMzIgNkwzMiA4TDMzIDhMMzMgNlpNMzQgNkwzNCA3TDM1IDdMMzUgNlpNMzYgNkwzNiA3TDM3IDdMMzcgNlpNNDQgNkw0NCA3TDQ1IDdMNDUgNlpNNDkgOUw0OSAxMEw1MCAxMEw1MCA5Wk02IDEwTDYgMTFMNyAxMUw3IDEyTDggMTJMOCAxM0wxMSAxM0wxMSAxMkw4IDEyTDggMTBaTTEyIDEwTDEyIDExTDEzIDExTDEzIDEwWk0yNCAxMEwyNCAxMUwyMyAxMUwyMyAxMkwyNCAxMkwyNCAxMUwyNiAxMUwyNiAxMkwyNSAxMkwyNSAxM0wyMyAxM0wyMyAxNEwyNCAxNEwyNCAxNUwyNiAxNUwyNiAxNEwyNyAxNEwyNyAxNUwzMCAxNUwzMCAxNEwyOCAxNEwyOCAxM0wyNyAxM0wyNyAxMFpNMzIgMTBMMzIgMTFMMzQgMTFMMzQgMTBaTTM2IDExTDM2IDEzTDM1IDEzTDM1IDE1TDM3IDE1TDM3IDE2TDM4IDE2TDM4IDE3TDM5IDE3TDM5IDE1TDM3IDE1TDM3IDE0TDM4IDE0TDM4IDExWk0zOSAxMUwzOSAxMkw0MCAxMkw0MCAxM0wzOSAxM0wzOSAxNEw0MCAxNEw0MCAxM0w0MSAxM0w0MSAxMkw0MCAxMkw0MCAxMVpNNDIgMTJMNDIgMTRMNDEgMTRMNDEgMTVMNDIgMTVMNDIgMTZMNDMgMTZMNDMgMTVMNDIgMTVMNDIgMTRMNDQgMTRMNDQgMTVMNDUgMTVMNDUgMTZMNDQgMTZMNDQgMTdMNDUgMTdMNDUgMjBMNDcgMjBMNDcgMTlMNDkgMTlMNDkgMThMNDcgMThMNDcgMTlMNDYgMTlMNDYgMTdMNDUgMTdMNDUgMTZMNDYgMTZMNDYgMTVMNDggMTVMNDggMTRMNDYgMTRMNDYgMTJMNDQgMTJMNDQgMTNMNDMgMTNMNDMgMTJaTTE3IDEzTDE3IDE0TDE1IDE0TDE1IDE1TDEyIDE1TDEyIDE2TDExIDE2TDExIDE0TDEwIDE0TDEwIDE2TDkgMTZMOSAxN0wxMCAxN0wxMCAxOEwxMSAxOEwxMSAxN0wxNCAxN0wxNCAxNkwxNSAxNkwxNSAxOUwxNCAxOUwxNCAyMEwxMiAyMEwxMiAxOUwxMyAxOUwxMyAxOEwxMiAxOEwxMiAxOUwxMSAxOUwxMSAyMEwxMCAyMEwxMCAyMkwxMiAyMkwxMiAyMUwxMyAyMUwxMyAyMkwxNCAyMkwxNCAyMEwxNSAyMEwxNSAyMkwxNiAyMkwxNiAyM0wxNyAyM0wxNyAyNEwxOCAyNEwxOCAyNkwxOSAyNkwxOSAyOEwxOCAyOEwxOCAyOUwxOSAyOUwxOSAzMEwyMCAzMEwyMCAyOUwyMSAyOUwyMSAyN0wyMiAyN0wyMiAyNkwyMSAyNkwyMSAyN0wyMCAyN0wyMCAyNUwxOSAyNUwxOSAyNEwxOCAyNEwxOCAyM0wxNyAyM0wxNyAyMUwxNiAyMUwxNiAyMEwxNSAyMEwxNSAxOUwxNiAxOUwxNiAxNkwxNSAxNkwxNSAxNUwxNyAxNUwxNyAxNEwxOCAxNEwxOCAxM1pNMjUgMTNMMjUgMTRMMjYgMTRMMjYgMTNaTTQ0IDEzTDQ0IDE0TDQ1IDE0TDQ1IDEzWk0wIDE2TDAgMTdMMSAxN0wxIDE2Wk0zIDE4TDMgMTlMNCAxOUw0IDE4Wk00MiAxOEw0MiAxOUw0MyAxOUw0MyAxOFpNNDAgMTlMNDAgMjBMMzkgMjBMMzkgMjFMNDMgMjFMNDMgMjBMNDEgMjBMNDEgMTlaTTI2IDIwTDI2IDIxTDI3IDIxTDI3IDIwWk0yOCAyMEwyOCAyMUwzMCAyMUwzMCAyMkwyOSAyMkwyOSAyM0wzMCAyM0wzMCAyNEwzMSAyNEwzMSAyM0wzMiAyM0wzMiAyMkwzMSAyMkwzMSAyMFpNMzcgMjBMMzcgMjFMMzYgMjFMMzYgMjJMMzQgMjJMMzQgMjRMMzMgMjRMMzMgMjVMMzQgMjVMMzQgMjZMMzUgMjZMMzUgMjVMMzYgMjVMMzYgMjdMMzcgMjdMMzcgMjhMMzkgMjhMMzkgMjlMNDAgMjlMNDAgMzBMNDEgMzBMNDEgMjhMNDQgMjhMNDQgMjdMNDMgMjdMNDMgMjZMMzkgMjZMMzkgMjVMNDAgMjVMNDAgMjRMMzkgMjRMMzkgMjNMMzggMjNMMzggMjJMMzcgMjJMMzcgMjFMMzggMjFMMzggMjBaTTMgMjFMMyAyNEw0IDI0TDQgMjNMNSAyM0w1IDIyTDQgMjJMNCAyMVpNMSAyMkwxIDIzTDIgMjNMMiAyMlpNMzAgMjJMMzAgMjNMMzEgMjNMMzEgMjJaTTM2IDIyTDM2IDIzTDM1IDIzTDM1IDI0TDM0IDI0TDM0IDI1TDM1IDI1TDM1IDI0TDM2IDI0TDM2IDI1TDM3IDI1TDM3IDI2TDM4IDI2TDM4IDI3TDM5IDI3TDM5IDI4TDQxIDI4TDQxIDI3TDM5IDI3TDM5IDI2TDM4IDI2TDM4IDI0TDM2IDI0TDM2IDIzTDM3IDIzTDM3IDIyWk00MCAyMkw0MCAyM0w0MSAyM0w0MSAyNUw0MiAyNUw0MiAyMlpNNDMgMjJMNDMgMjVMNDQgMjVMNDQgMjJaTTMgMjVMMyAyNkwyIDI2TDIgMjhMMyAyOEwzIDI2TDQgMjZMNCAyNVpNNSAyNUw1IDI4TDggMjhMOCAyNVpNMTAgMjVMMTAgMjZMMTEgMjZMMTEgMjVaTTEyIDI1TDEyIDI5TDExIDI5TDExIDMwTDEyIDMwTDEyIDI5TDEzIDI5TDEzIDMwTDE0IDMwTDE0IDI4TDEzIDI4TDEzIDI1Wk0yNSAyNUwyNSAyOEwyOCAyOEwyOCAyNVpNNDUgMjVMNDUgMjhMNDggMjhMNDggMjVaTTYgMjZMNiAyN0w3IDI3TDcgMjZaTTI2IDI2TDI2IDI3TDI3IDI3TDI3IDI2Wk00NiAyNkw0NiAyN0w0NyAyN0w0NyAyNlpNMTAgMjdMMTAgMjhMMTEgMjhMMTEgMjdaTTMyIDI3TDMyIDI4TDMxIDI4TDMxIDI5TDI5IDI5TDI5IDMyTDMwIDMyTDMwIDMxTDMxIDMxTDMxIDI5TDMyIDI5TDMyIDI4TDMzIDI4TDMzIDI3Wk01MiAyN0w1MiAyOEw1MyAyOEw1MyAyN1pNMTkgMjhMMTkgMjlMMjAgMjlMMjAgMjhaTTQ5IDI4TDQ5IDI5TDUwIDI5TDUwIDI4Wk02IDI5TDYgMzBMNCAzMEw0IDMxTDYgMzFMNiAzMkw3IDMyTDcgMzFMNiAzMUw2IDMwTDcgMzBMNyAyOVpNOSAyOUw5IDMwTDEwIDMwTDEwIDI5Wk0yNCAyOUwyNCAzMkwyNSAzMkwyNSAzMUwyNyAzMUwyNyAzMEwyNiAzMEwyNiAyOVpNNDUgMjlMNDUgMzFMNDYgMzFMNDYgMzBMNDcgMzBMNDcgMjlaTTUyIDI5TDUyIDMyTDUzIDMyTDUzIDI5Wk0yMSAzMEwyMSAzMUwyMiAzMUwyMiAzMFpNMTUgMzJMMTUgMzNMMTYgMzNMMTYgMzJaTTMyIDMyTDMyIDMzTDMzIDMzTDMzIDMyWk04IDM0TDggMzVMOSAzNUw5IDM2TDExIDM2TDExIDM1TDEwIDM1TDEwIDM0Wk0zNyAzNEwzNyAzNkwzOSAzNkwzOSAzNUwzOCAzNUwzOCAzNFpNMSAzNUwxIDM2TDIgMzZMMiAzNVpNMjMgMzVMMjMgMzZMMjIgMzZMMjIgMzhMMjEgMzhMMjEgMzlMMTkgMzlMMTkgMzhMMjAgMzhMMjAgMzZMMTggMzZMMTggMzlMMTkgMzlMMTkgNDBMMTcgNDBMMTcgNDFMMTkgNDFMMTkgNDBMMjAgNDBMMjAgNDFMMjEgNDFMMjEgNDJMMjIgNDJMMjIgNDFMMjEgNDFMMjEgMzlMMjMgMzlMMjMgMzZMMjUgMzZMMjUgMzVaTTM1IDM1TDM1IDM3TDM0IDM3TDM0IDM4TDM1IDM4TDM1IDM5TDM0IDM5TDM0IDQ1TDM2IDQ1TDM2IDQ0TDM3IDQ0TDM3IDQ1TDQwIDQ1TDQwIDQ3TDM5IDQ3TDM5IDQ2TDM3IDQ2TDM3IDQ3TDMzIDQ3TDMzIDQ0TDMyIDQ0TDMyIDQ1TDMxIDQ1TDMxIDQ2TDMwIDQ2TDMwIDQ0TDMxIDQ0TDMxIDQyTDMwIDQyTDMwIDQzTDI5IDQzTDI5IDQyTDI4IDQyTDI4IDQ0TDI5IDQ0TDI5IDQ2TDMwIDQ2TDMwIDQ3TDMxIDQ3TDMxIDQ2TDMyIDQ2TDMyIDQ3TDMzIDQ3TDMzIDQ5TDM0IDQ5TDM0IDUwTDM2IDUwTDM2IDQ4TDM3IDQ4TDM3IDQ3TDM5IDQ3TDM5IDQ4TDM4IDQ4TDM4IDUwTDM3IDUwTDM3IDUxTDM4IDUxTDM4IDUyTDM5IDUyTDM5IDUxTDM4IDUxTDM4IDUwTDM5IDUwTDM5IDQ4TDQwIDQ4TDQwIDQ3TDQyIDQ3TDQyIDQ4TDQ0IDQ4TDQ0IDQ3TDQyIDQ3TDQyIDQ2TDQxIDQ2TDQxIDQ1TDQ0IDQ1TDQ0IDQ0TDQyIDQ0TDQyIDQzTDQzIDQzTDQzIDQyTDQyIDQyTDQyIDQzTDQxIDQzTDQxIDQyTDQwIDQyTDQwIDQxTDQyIDQxTDQyIDQwTDQxIDQwTDQxIDM5TDM5IDM5TDM5IDM3TDM4IDM3TDM4IDM5TDM5IDM5TDM5IDQwTDM4IDQwTDM4IDQxTDM3IDQxTDM3IDQyTDM4IDQyTDM4IDQ0TDM3IDQ0TDM3IDQzTDM2IDQzTDM2IDQyTDM1IDQyTDM1IDM5TDM2IDM5TDM2IDQwTDM3IDQwTDM3IDM4TDM1IDM4TDM1IDM3TDM2IDM3TDM2IDM1Wk00MCAzN0w0MCAzOEw0MSAzOEw0MSAzN1pNMSAzOEwxIDM5TDIgMzlMMiAzOFpNNDMgMzhMNDMgMzlMNDQgMzlMNDQgMzhaTTQzIDQwTDQzIDQxTDQ0IDQxTDQ0IDQwWk0xMSA0MUwxMSA0MkwxMiA0MkwxMiA0MVpNMTMgNDFMMTMgNDNMMTQgNDNMMTQgNDFaTTQ2IDQxTDQ2IDQyTDQ0IDQyTDQ0IDQzTDQ2IDQzTDQ2IDQ0TDQ5IDQ0TDQ5IDQzTDUwIDQzTDUwIDQyTDQ5IDQyTDQ5IDQzTDQ4IDQzTDQ4IDQyTDQ3IDQyTDQ3IDQxWk00NiA0Mkw0NiA0M0w0NyA0M0w0NyA0MlpNOSA0M0w5IDQ0TDExIDQ0TDExIDQ1TDEyIDQ1TDEyIDQzWk0zNSA0M0wzNSA0NEwzNiA0NEwzNiA0M1pNMzkgNDNMMzkgNDRMNDEgNDRMNDEgNDNaTTYgNDRMNiA0NUw3IDQ1TDcgNDRaTTE1IDQ0TDE1IDQ1TDE2IDQ1TDE2IDQ0Wk04IDQ1TDggNDhMMTAgNDhMMTAgNDlMOSA0OUw5IDUwTDEwIDUwTDEwIDUxTDExIDUxTDExIDUwTDEyIDUwTDEyIDUyTDkgNTJMOSA1MUw4IDUxTDggNTNMMTIgNTNMMTIgNTJMMTMgNTJMMTMgNTBMMTQgNTBMMTQgNDhMMTMgNDhMMTMgNTBMMTIgNTBMMTIgNDhMMTAgNDhMMTAgNDdMOSA0N0w5IDQ2TDEwIDQ2TDEwIDQ1Wk0yNSA0NUwyNSA0OEwyOCA0OEwyOCA0NVpNNDUgNDVMNDUgNDhMNDggNDhMNDggNDVaTTI2IDQ2TDI2IDQ3TDI3IDQ3TDI3IDQ2Wk00NiA0Nkw0NiA0N0w0NyA0N0w0NyA0NlpNMzQgNDhMMzQgNDlMMzUgNDlMMzUgNDhaTTUxIDQ4TDUxIDQ5TDUyIDQ5TDUyIDUyTDUzIDUyTDUzIDQ5TDUyIDQ5TDUyIDQ4Wk0xMCA0OUwxMCA1MEwxMSA1MEwxMSA0OVpNMjUgNDlMMjUgNTBMMjcgNTBMMjcgNDlaTTMwIDQ5TDMwIDUwTDMxIDUwTDMxIDQ5Wk00MCA0OUw0MCA1MEw0MSA1MEw0MSA0OVpNNDIgNTBMNDIgNTFMNDMgNTFMNDMgNTBaTTQ3IDUwTDQ3IDUxTDQ1IDUxTDQ1IDUyTDQ0IDUyTDQ0IDUzTDQ1IDUzTDQ1IDUyTDQ2IDUyTDQ2IDUzTDQ5IDUzTDQ5IDUyTDUxIDUyTDUxIDUwWk00OCA1MUw0OCA1Mkw0OSA1Mkw0OSA1MVpNMjcgNTJMMjcgNTNMMjggNTNMMjggNTJaTTAgMEwwIDdMNyA3TDcgMFpNMSAxTDEgNkw2IDZMNiAxWk0yIDJMMiA1TDUgNUw1IDJaTTQ2IDBMNDYgN0w1MyA3TDUzIDBaTTQ3IDFMNDcgNkw1MiA2TDUyIDFaTTQ4IDJMNDggNUw1MSA1TDUxIDJaTTAgNDZMMCA1M0w3IDUzTDcgNDZaTTEgNDdMMSA1Mkw2IDUyTDYgNDdaTTIgNDhMMiA1MUw1IDUxTDUgNDhaIiBmaWxsPSIjMDAwMDAwIi8+PC9nPjwvZz48L3N2Zz4K', '2026-09-14 20:19:02', '2026-09-14 20:20:07');
INSERT INTO `tickets` (`id`, `event_id`, `user_id`, `reference`, `email`, `name`, `phone`, `whatsapp_confirmed`, `ticket_type`, `amount`, `currency`, `status`, `verified`, `verified_at`, `qr_code`, `created_at`, `updated_at`) VALUES
(4, 4, NULL, 'TCK-BAI3OAI3QJ87', 'crepindale@gmail.com', 'Prince Opoku', '024 178 6330', 1, 'vip', 300, 'GHS', 'paid', 0, NULL, 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjI2MCIgaGVpZ2h0PSIyNjAiIHZpZXdCb3g9IjAgMCAyNjAgMjYwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMjYwIiBoZWlnaHQ9IjI2MCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoNC45MDYpIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLDApIj48cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik04IDBMOCAxTDkgMUw5IDJMOCAyTDggNUw5IDVMOSA2TDggNkw4IDdMOSA3TDkgOEw4IDhMOCA5TDkgOUw5IDEwTDEwIDEwTDEwIDlMOSA5TDkgOEwxMCA4TDEwIDdMMTEgN0wxMSA1TDEyIDVMMTIgOEwxMSA4TDExIDlMMTIgOUwxMiAxMEwxMSAxMEwxMSAxMUw5IDExTDkgMTRMOCAxNEw4IDEyTDYgMTJMNiAxM0w3IDEzTDcgMTRMNiAxNEw2IDE1TDggMTVMOCAxNkw0IDE2TDQgMTVMMiAxNUwyIDE2TDEgMTZMMSAxM0wzIDEzTDMgMTJMNSAxMkw1IDExTDcgMTFMNyAxMEw1IDEwTDUgMTFMMyAxMUwzIDEyTDEgMTJMMSAxM0wwIDEzTDAgMTdMMiAxN0wyIDE5TDUgMTlMNSAyMEwzIDIwTDMgMjFMMSAyMUwxIDIyTDIgMjJMMiAyM0wxIDIzTDEgMjRMMCAyNEwwIDI2TDEgMjZMMSAyNUwyIDI1TDIgMjZMNCAyNkw0IDI4TDMgMjhMMyAyN0wyIDI3TDIgMjhMMyAyOEwzIDI5TDQgMjlMNCAzMEwyIDMwTDIgMjlMMSAyOUwxIDI3TDAgMjdMMCAyOUwxIDI5TDEgMzBMMCAzMEwwIDMyTDIgMzJMMiAzMUwzIDMxTDMgMzVMMCAzNUwwIDM2TDEgMzZMMSAzN0wwIDM3TDAgMzhMMSAzOEwxIDM3TDIgMzdMMiAzOUwxIDM5TDEgNDBMMiA0MEwyIDM5TDMgMzlMMyA0MEw0IDQwTDQgNDFMNSA0MUw1IDQyTDMgNDJMMyA0M0wyIDQzTDIgNDFMMSA0MUwxIDQyTDAgNDJMMCA0M0wxIDQzTDEgNDRMMyA0NEwzIDQ1TDQgNDVMNCA0NEwzIDQ0TDMgNDNMNyA0M0w3IDQ0TDYgNDRMNiA0NUw4IDQ1TDggNDZMMTAgNDZMMTAgNDRMOSA0NEw5IDQ1TDggNDVMOCA0M0wxMSA0M0wxMSA0NUwxMyA0NUwxMyA0NkwxMiA0NkwxMiA0N0wxMyA0N0wxMyA0NkwxNCA0NkwxNCA0N0wxNiA0N0wxNiA0OEwxMSA0OEwxMSA0OUwxMCA0OUwxMCA0OEw5IDQ4TDkgNDlMOCA0OUw4IDUzTDEwIDUzTDEwIDUwTDEyIDUwTDEyIDUxTDExIDUxTDExIDUzTDEyIDUzTDEyIDUxTDEzIDUxTDEzIDUyTDE0IDUyTDE0IDUzTDE1IDUzTDE1IDUyTDE0IDUyTDE0IDQ5TDE1IDQ5TDE1IDUxTDE2IDUxTDE2IDUzTDE3IDUzTDE3IDUwTDE4IDUwTDE4IDQ5TDIwIDQ5TDIwIDUwTDIxIDUwTDIxIDUxTDIwIDUxTDIwIDUyTDE5IDUyTDE5IDUxTDE4IDUxTDE4IDUyTDE5IDUyTDE5IDUzTDIwIDUzTDIwIDUyTDI0IDUyTDI0IDUwTDI1IDUwTDI1IDUzTDI2IDUzTDI2IDUyTDI3IDUyTDI3IDUzTDI4IDUzTDI4IDUyTDI3IDUyTDI3IDUxTDI2IDUxTDI2IDUwTDI4IDUwTDI4IDUxTDMxIDUxTDMxIDUyTDMwIDUyTDMwIDUzTDMzIDUzTDMzIDUyTDM0IDUyTDM0IDUxTDMzIDUxTDMzIDUwTDMyIDUwTDMyIDQ4TDM1IDQ4TDM1IDQ5TDM3IDQ5TDM3IDUxTDM5IDUxTDM5IDUzTDQwIDUzTDQwIDUyTDQ0IDUyTDQ0IDQ5TDQ1IDQ5TDQ1IDUwTDQ2IDUwTDQ2IDUxTDQ3IDUxTDQ3IDUyTDQ2IDUyTDQ2IDUzTDQ4IDUzTDQ4IDUwTDUwIDUwTDUwIDQ5TDUxIDQ5TDUxIDUyTDUwIDUyTDUwIDUxTDQ5IDUxTDQ5IDUzTDUyIDUzTDUyIDQ5TDUzIDQ5TDUzIDQ3TDUyIDQ3TDUyIDQ0TDUzIDQ0TDUzIDQzTDUyIDQzTDUyIDQ0TDUxIDQ0TDUxIDQxTDUzIDQxTDUzIDM1TDUyIDM1TDUyIDM0TDUzIDM0TDUzIDMzTDUyIDMzTDUyIDM0TDUxIDM0TDUxIDMwTDUzIDMwTDUzIDI5TDUyIDI5TDUyIDI3TDUzIDI3TDUzIDI1TDUyIDI1TDUyIDI0TDUzIDI0TDUzIDIzTDUyIDIzTDUyIDIyTDUzIDIyTDUzIDIwTDUxIDIwTDUxIDE4TDUyIDE4TDUyIDE3TDUwIDE3TDUwIDE5TDQ5IDE5TDQ5IDIyTDQ3IDIyTDQ3IDIzTDQ2IDIzTDQ2IDIyTDQ0IDIyTDQ0IDIxTDQyIDIxTDQyIDIwTDQ1IDIwTDQ1IDE5TDQxIDE5TDQxIDIwTDM5IDIwTDM5IDE5TDQwIDE5TDQwIDE4TDQyIDE4TDQyIDE1TDQ1IDE1TDQ1IDE4TDQ2IDE4TDQ2IDIwTDQ3IDIwTDQ3IDIxTDQ4IDIxTDQ4IDIwTDQ3IDIwTDQ3IDE2TDQ2IDE2TDQ2IDE1TDQ1IDE1TDQ1IDE0TDQ2IDE0TDQ2IDEzTDQzIDEzTDQzIDE0TDQxIDE0TDQxIDEzTDQyIDEzTDQyIDEyTDQxIDEyTDQxIDExTDQ1IDExTDQ1IDEyTDQ4IDEyTDQ4IDE0TDQ3IDE0TDQ3IDE1TDQ4IDE1TDQ4IDE0TDQ5IDE0TDQ5IDE1TDUyIDE1TDUyIDE2TDUzIDE2TDUzIDE0TDQ5IDE0TDQ5IDExTDUxIDExTDUxIDhMNDggOEw0OCA5TDQ3IDlMNDcgMTBMNDQgMTBMNDQgOUw0NiA5TDQ2IDhMNDUgOEw0NSA2TDQ0IDZMNDQgN0w0MyA3TDQzIDNMNDQgM0w0NCA0TDQ1IDRMNDUgM0w0NCAzTDQ0IDFMNDMgMUw0MyAwTDQyIDBMNDIgMUw0MSAxTDQxIDBMMzkgMEwzOSAxTDQxIDFMNDEgMkw0MCAyTDQwIDNMNDEgM0w0MSA0TDQwIDRMNDAgNUw0MSA1TDQxIDZMNDAgNkw0MCA4TDM5IDhMMzkgOUw0MSA5TDQxIDExTDQwIDExTDQwIDEwTDM5IDEwTDM5IDExTDQwIDExTDQwIDEyTDQxIDEyTDQxIDEzTDQwIDEzTDQwIDE0TDM5IDE0TDM5IDEzTDM4IDEzTDM4IDExTDM3IDExTDM3IDEwTDM4IDEwTDM4IDdMMzkgN0wzOSA0TDM4IDRMMzggM0wzOSAzTDM5IDJMMzggMkwzOCAzTDM3IDNMMzcgMkwzNiAyTDM2IDFMMzggMUwzOCAwTDM1IDBMMzUgMUwzMyAxTDMzIDBMMzAgMEwzMCAxTDI5IDFMMjkgMEwyNiAwTDI2IDFMMjUgMUwyNSAwTDIxIDBMMjEgMUwyMCAxTDIwIDBMMTkgMEwxOSAxTDE4IDFMMTggMEwxNiAwTDE2IDJMMTUgMkwxNSAxTDE0IDFMMTQgMkwxMyAyTDEzIDBMMTEgMEwxMSAxTDEwIDFMMTAgMFpNMTEgMUwxMSAyTDEwIDJMMTAgM0w5IDNMOSA0TDEyIDRMMTIgNUwxNCA1TDE0IDZMMTMgNkwxMyA3TDE0IDdMMTQgNkwxNSA2TDE1IDhMMTQgOEwxNCAxMEwxNSAxMEwxNSA4TDE2IDhMMTYgNUwxNyA1TDE3IDhMMTggOEwxOCAxMEwxNyAxMEwxNyA5TDE2IDlMMTYgMTFMMTUgMTFMMTUgMTJMMTQgMTJMMTQgMTNMMTMgMTNMMTMgMTRMMTIgMTRMMTIgMTFMMTEgMTFMMTEgMTJMMTAgMTJMMTAgMTZMOSAxNkw5IDE3TDggMTdMOCAxOEw5IDE4TDkgMTlMNiAxOUw2IDIwTDcgMjBMNyAyMUw2IDIxTDYgMjJMNSAyMkw1IDIxTDMgMjFMMyAyM0wyIDIzTDIgMjRMMyAyNEwzIDI1TDQgMjVMNCAyNEwzIDI0TDMgMjNMNSAyM0w1IDI0TDcgMjRMNyAyM0w4IDIzTDggMjJMNyAyMkw3IDIxTDExIDIxTDExIDIzTDEyIDIzTDEyIDI0TDEzIDI0TDEzIDI1TDkgMjVMOSAyN0wxMCAyN0wxMCAyOUw5IDI5TDkgMzFMMTAgMzFMMTAgMzBMMTEgMzBMMTEgMjdMMTIgMjdMMTIgMjhMMTMgMjhMMTMgMjdMMTUgMjdMMTUgMjhMMTYgMjhMMTYgMjdMMTcgMjdMMTcgMzFMMTggMzFMMTggMzVMMjAgMzVMMjAgMzZMMjEgMzZMMjEgMzhMMTkgMzhMMTkgMzdMMTggMzdMMTggMzhMMTcgMzhMMTcgMzJMMTUgMzJMMTUgMzFMMTMgMzFMMTMgMzBMMTUgMzBMMTUgMjlMMTMgMjlMMTMgMzBMMTIgMzBMMTIgMzFMMTMgMzFMMTMgMzZMMTEgMzZMMTEgMzdMMTAgMzdMMTAgMzZMOSAzNkw5IDM3TDggMzdMOCAzNUwxMSAzNUwxMSAzNEwxMiAzNEwxMiAzM0wxMCAzM0wxMCAzMkw4IDMyTDggMzNMNiAzM0w2IDM0TDggMzRMOCAzNUw2IDM1TDYgMzZMNCAzNkw0IDM1TDMgMzVMMyAzOUw0IDM5TDQgMzhMNyAzOEw3IDM5TDUgMzlMNSA0MUw2IDQxTDYgNDJMNyA0Mkw3IDQxTDggNDFMOCAzOUwxMCAzOUwxMCA0MUwxMSA0MUwxMSA0MEwxMiA0MEwxMiA0MkwxMyA0MkwxMyA0NEwxNSA0NEwxNSA0M0wxNCA0M0wxNCA0MkwxNSA0MkwxNSA0MUwxNiA0MUwxNiA0MEwxNyA0MEwxNyA0MUwxOSA0MUwxOSA0MkwxNiA0MkwxNiA0M0wxOSA0M0wxOSA0NEwxNyA0NEwxNyA0NUwxNCA0NUwxNCA0NkwxNiA0NkwxNiA0N0wxNyA0N0wxNyA0OEwxNiA0OEwxNiA1MEwxNyA1MEwxNyA0OEwxOCA0OEwxOCA0N0wxOSA0N0wxOSA0OEwyMCA0OEwyMCA0N0wxOSA0N0wxOSA0NEwyMCA0NEwyMCA0MkwyMSA0MkwyMSA0M0wyMiA0M0wyMiA0NEwyMyA0NEwyMyA0NUwyNCA0NUwyNCA0MkwyMyA0MkwyMyA0MUwyNiA0MUwyNiA0MEwyNCA0MEwyNCAzOUwyNSAzOUwyNSAzOEwyNCAzOEwyNCAzNUwyMiAzNUwyMiAzM0wyMSAzM0wyMSAzMUwyMiAzMUwyMiAzMEwyMyAzMEwyMyAzM0wyNCAzM0wyNCAzNEwyNSAzNEwyNSAzN0wyNiAzN0wyNiAzOUwyNyAzOUwyNyAzN0wyOCAzN0wyOCAzNkwyNyAzNkwyNyAzNEwyOSAzNEwyOSAzMkwzMCAzMkwzMCAzM0wzMiAzM0wzMiAzNEwzMyAzNEwzMyAzNUwzMiAzNUwzMiAzOUwzMyAzOUwzMyA0MEwzNSA0MEwzNSA0MUwzNyA0MUwzNyA0M0wzNiA0M0wzNiA0MkwzNSA0MkwzNSA0M0wzNiA0M0wzNiA0NUwzNyA0NUwzNyA0M0wzOCA0M0wzOCA0MkwzOSA0MkwzOSA0M0w0MSA0M0w0MSA0MUw0MiA0MUw0MiA0NUw0MyA0NUw0MyA0Nkw0MSA0Nkw0MSA0N0w0MCA0N0w0MCA0NUwzOSA0NUwzOSA0NEwzOCA0NEwzOCA0NkwzNyA0NkwzNyA0N0wzOSA0N0wzOSA0OEwzNyA0OEwzNyA0OUwzOSA0OUwzOSA1MUw0MCA1MUw0MCA0OUw0MSA0OUw0MSA1MEw0MyA1MEw0MyA0OUw0MSA0OUw0MSA0N0w0MiA0N0w0MiA0OEw0MyA0OEw0MyA0N0w0NCA0N0w0NCA0NUw0MyA0NUw0MyA0M0w0NCA0M0w0NCA0NEw0OSA0NEw0OSA0M0w1MCA0M0w1MCA0Mkw0OSA0Mkw0OSA0MUw1MSA0MUw1MSA0MEw1MiA0MEw1MiAzOUw1MSAzOUw1MSAzOEw1MiAzOEw1MiAzN0w1MSAzN0w1MSAzNkw1MiAzNkw1MiAzNUw1MCAzNUw1MCAzNEw0NiAzNEw0NiAzNUw0NyAzNUw0NyAzOEw0OCAzOEw0OCAzOUw0NyAzOUw0NyA0MEw0NiA0MEw0NiAzOUw0NSAzOUw0NSAzN0w0NiAzN0w0NiAzNkw0NSAzNkw0NSAzN0w0NCAzN0w0NCAzNUw0NSAzNUw0NSAzM0w0NyAzM0w0NyAzMkw0OCAzMkw0OCAzM0w0OSAzM0w0OSAzMkw0OCAzMkw0OCAzMEw1MCAzMEw1MCAyOUw1MSAyOUw1MSAyN0w1MCAyN0w1MCAyOEw0OSAyOEw0OSAyOUw0OCAyOUw0OCAzMEw0NiAzMEw0NiAyOUw0MyAyOUw0MyAyOEw0NCAyOEw0NCAyNkw0MyAyNkw0MyAyNUw0MSAyNUw0MSAyNEw0NCAyNEw0NCAyMkw0MyAyMkw0MyAyM0w0MiAyM0w0MiAyMUw0MCAyMUw0MCAyMkwzOSAyMkwzOSAyMUwzOCAyMUwzOCAyMkwzNyAyMkwzNyAyMEwzNiAyMEwzNiAyMUwzMyAyMUwzMyAyMEwzMiAyMEwzMiAxOUwzMSAxOUwzMSAxNkwzMiAxNkwzMiAxNEwzMyAxNEwzMyAxMEwzNSAxMEwzNSAxMkwzNiAxMkwzNiA5TDM3IDlMMzcgOEwzNiA4TDM2IDlMMzUgOUwzNSA3TDM2IDdMMzYgNkwzNyA2TDM3IDdMMzggN0wzOCA0TDM2IDRMMzYgNkwzNSA2TDM1IDdMMzQgN0wzNCA2TDMzIDZMMzMgN0wzMiA3TDMyIDZMMzEgNkwzMSA5TDMyIDlMMzIgMTBMMzEgMTBMMzEgMTFMMzIgMTFMMzIgMTNMMzEgMTNMMzEgMTJMMjkgMTJMMjkgMTBMMjggMTBMMjggOUwyNyA5TDI3IDEwTDI2IDEwTDI2IDlMMjUgOUwyNSAxMEwyNiAxMEwyNiAxMUwyNCAxMUwyNCAxMkwyNSAxMkwyNSAxM0wyNiAxM0wyNiAxMkwyNyAxMkwyNyAxMUwyOCAxMUwyOCAxM0wyNyAxM0wyNyAxNEwyNSAxNEwyNSAxNUwyNiAxNUwyNiAxNkwyMiAxNkwyMiAxNUwxOSAxNUwxOSAxNEwxOCAxNEwxOCAxM0wxNyAxM0wxNyAxMkwxNiAxMkwxNiAxMUwxOCAxMUwxOCAxMEwxOSAxMEwxOSA4TDIwIDhMMjAgMTBMMjEgMTBMMjEgN0wyMiA3TDIyIDZMMjEgNkwyMSA1TDE5IDVMMTkgN0wxOCA3TDE4IDVMMTcgNUwxNyAzTDE4IDNMMTggMkwxNiAyTDE2IDNMMTQgM0wxNCA0TDEzIDRMMTMgM0wxMiAzTDEyIDFaTTE5IDFMMTkgMkwyMCAyTDIwIDFaTTIxIDFMMjEgMkwyMiAyTDIyIDFaTTIzIDFMMjMgMkwyNCAyTDI0IDFaTTI4IDFMMjggNEwzMCA0TDMwIDVMMjkgNUwyOSA4TDMwIDhMMzAgNUwzMiA1TDMyIDRMMzQgNEwzNCA1TDM1IDVMMzUgM0wzNiAzTDM2IDJMMzQgMkwzNCAzTDMyIDNMMzIgMUwzMSAxTDMxIDJMMjkgMkwyOSAxWk0yNSAyTDI1IDNMMjQgM0wyNCA0TDIzIDRMMjMgM0wyMiAzTDIyIDRMMjMgNEwyMyA3TDI0IDdMMjQgNEwyNSA0TDI1IDNMMjcgM0wyNyAyWk00MSAyTDQxIDNMNDMgM0w0MyAyWk0xOSAzTDE5IDRMMjAgNEwyMCAzWk0zMCAzTDMwIDRMMzEgNEwzMSAzWk0xNSA0TDE1IDVMMTYgNUwxNiA0Wk0yNSA1TDI1IDhMMjggOEwyOCA1Wk05IDZMOSA3TDEwIDdMMTAgNlpNMjAgNkwyMCA3TDIxIDdMMjEgNlpNMjYgNkwyNiA3TDI3IDdMMjcgNlpNNDEgNkw0MSA5TDQzIDlMNDMgOEw0MiA4TDQyIDZaTTAgOEwwIDlMMSA5TDEgMTBMMCAxMEwwIDExTDIgMTFMMiAxMEw0IDEwTDQgOFpNNiA4TDYgOUw3IDlMNyA4Wk01MiA4TDUyIDEwTDUzIDEwTDUzIDhaTTQ4IDlMNDggMTBMNDcgMTBMNDcgMTFMNDggMTFMNDggMTBMNTAgMTBMNTAgOVpNMTkgMTFMMTkgMTNMMjMgMTNMMjMgMTFMMjIgMTFMMjIgMTJMMjEgMTJMMjEgMTFaTTUyIDExTDUyIDEyTDUwIDEyTDUwIDEzTDUyIDEzTDUyIDEyTDUzIDEyTDUzIDExWk00IDEzTDQgMTRMNSAxNEw1IDEzWk0xNSAxM0wxNSAxNEwxNCAxNEwxNCAxNkwxMyAxNkwxMyAxOEwxMiAxOEwxMiAyMEwxNSAyMEwxNSAyMUwxOCAyMUwxOCAyMkwxNiAyMkwxNiAyNEwxNSAyNEwxNSAyNUwxMyAyNUwxMyAyNkwxNSAyNkwxNSAyN0wxNiAyN0wxNiAyNkwxNSAyNkwxNSAyNUwxNiAyNUwxNiAyNEwxNyAyNEwxNyAyN0wxOCAyN0wxOCAyOEwyMCAyOEwyMCAyOUwyMiAyOUwyMiAyOEwyMyAyOEwyMyAyN0wyMiAyN0wyMiAyNUwxOSAyNUwxOSAyNEwyMSAyNEwyMSAyM0wyMiAyM0wyMiAyNEwyNCAyNEwyNCAyOUwyMyAyOUwyMyAzMEwyNSAzMEwyNSAzMUwyNiAzMUwyNiAzMkwyOCAzMkwyOCAzMUwyNiAzMUwyNiAzMEwyNSAzMEwyNSAyOUwyNyAyOUwyNyAzMEwzMCAzMEwzMCAyOUwzMSAyOUwzMSAyOEwzMiAyOEwzMiAyOUwzMyAyOUwzMyAzMEwzMiAzMEwzMiAzMUwzNCAzMUwzNCAzMEwzNiAzMEwzNiAzMUwzNSAzMUwzNSAzM0wzNiAzM0wzNiAzNEwzNyAzNEwzNyAzNUwzOCAzNUwzOCAzNkwzNSAzNkwzNSAzNEwzNCAzNEwzNCAzNUwzMyAzNUwzMyAzN0wzNSAzN0wzNSA0MEwzNiA0MEwzNiAzOUwzNyAzOUwzNyA0MEwzOCA0MEwzOCA0MUwzOSA0MUwzOSA0Mkw0MCA0Mkw0MCA0MEw0MSA0MEw0MSAzOUw0MiAzOUw0MiA0MUw0MyA0MUw0MyAzOUw0NCAzOUw0NCA0Mkw0NiA0Mkw0NiA0MUw0NSA0MUw0NSAzOUw0NCAzOUw0NCAzOEw0MyAzOEw0MyAzOUw0MiAzOUw0MiAzOEw0MSAzOEw0MSAzN0w0MiAzN0w0MiAzNkw0MSAzNkw0MSAzNUw0MCAzNUw0MCAzNEwzOSAzNEwzOSAzNUwzOCAzNUwzOCAzM0wzOSAzM0wzOSAzMkwzOCAzMkwzOCAzMUwzNyAzMUwzNyAyOUwzOCAyOUwzOCAyOEwzOSAyOEwzOSAyN0w0MCAyN0w0MCAyOEw0MSAyOEw0MSAyN0w0MiAyN0w0MiAyOEw0MyAyOEw0MyAyNkw0MSAyNkw0MSAyNUwzOSAyNUwzOSAyNEw0MCAyNEw0MCAyM0wzOSAyM0wzOSAyMkwzOCAyMkwzOCAyM0wzNyAyM0wzNyAyMkwzNCAyMkwzNCAyM0wzMyAyM0wzMyAyMUwzMiAyMUwzMiAyMkwzMSAyMkwzMSAyMUwyOSAyMUwyOSAyMEwzMSAyMEwzMSAxOUwzMCAxOUwzMCAxN0wyOSAxN0wyOSAxNkwzMSAxNkwzMSAxNEwyOSAxNEwyOSAxM0wyOCAxM0wyOCAxNEwyNyAxNEwyNyAxNUwyOSAxNUwyOSAxNkwyOCAxNkwyOCAxN0wyNyAxN0wyNyAxNkwyNiAxNkwyNiAxN0wyNyAxN0wyNyAxOEwyOCAxOEwyOCAxN0wyOSAxN0wyOSAyMEwyOCAyMEwyOCAxOUwyNiAxOUwyNiAxOEwyNSAxOEwyNSAxN0wyNCAxN0wyNCAxOEwyMyAxOEwyMyAxN0wyMiAxN0wyMiAxNkwyMCAxNkwyMCAxN0wyMSAxN0wyMSAxOEwxOSAxOEwxOSAxN0wxOCAxN0wxOCAxNkwxOSAxNkwxOSAxNUwxOCAxNUwxOCAxNkwxNyAxNkwxNyAxNUwxNSAxNUwxNSAxNEwxNiAxNEwxNiAxM1pNMzQgMTNMMzQgMTZMMzUgMTZMMzUgMThMMzYgMThMMzYgMTlMMzggMTlMMzggMThMNDAgMThMNDAgMTdMNDEgMTdMNDEgMTZMNDAgMTZMNDAgMTVMMzkgMTVMMzkgMTRMMzggMTRMMzggMTVMMzUgMTVMMzUgMTNaTTM2IDEzTDM2IDE0TDM3IDE0TDM3IDEzWk0xMSAxNEwxMSAxNkwxMiAxNkwxMiAxNFpNMjMgMTRMMjMgMTVMMjQgMTVMMjQgMTRaTTM4IDE1TDM4IDE2TDM3IDE2TDM3IDE3TDQwIDE3TDQwIDE2TDM5IDE2TDM5IDE1Wk0yIDE2TDIgMTdMMyAxN0wzIDE4TDcgMThMNyAxN0wzIDE3TDMgMTZaTTE0IDE2TDE0IDE4TDEzIDE4TDEzIDE5TDE1IDE5TDE1IDE3TDE2IDE3TDE2IDE4TDE3IDE4TDE3IDE5TDE4IDE5TDE4IDIxTDE5IDIxTDE5IDIyTDE4IDIyTDE4IDIzTDIxIDIzTDIxIDIxTDIwIDIxTDIwIDE5TDE5IDE5TDE5IDE4TDE3IDE4TDE3IDE2Wk0zMiAxN0wzMiAxOEwzMyAxOEwzMyAxOUwzNCAxOUwzNCAyMEwzNSAyMEwzNSAxOUwzNCAxOUwzNCAxOEwzMyAxOEwzMyAxN1pNMjEgMThMMjEgMjBMMjMgMjBMMjMgMjJMMjIgMjJMMjIgMjNMMjMgMjNMMjMgMjJMMjQgMjJMMjQgMjFMMjYgMjFMMjYgMjNMMjQgMjNMMjQgMjRMMjggMjRMMjggMjNMMzAgMjNMMzAgMjRMMjkgMjRMMjkgMjlMMzAgMjlMMzAgMjZMMzIgMjZMMzIgMjdMMzMgMjdMMzMgMjlMMzcgMjlMMzcgMjhMMzggMjhMMzggMjdMMzcgMjdMMzcgMjZMMzggMjZMMzggMjVMMzUgMjVMMzUgMjRMMzYgMjRMMzYgMjNMMzUgMjNMMzUgMjRMMzIgMjRMMzIgMjVMMzEgMjVMMzEgMjJMMjggMjJMMjggMjNMMjcgMjNMMjcgMjFMMjggMjFMMjggMjBMMjcgMjBMMjcgMjFMMjYgMjFMMjYgMjBMMjUgMjBMMjUgMThMMjQgMThMMjQgMTlMMjMgMTlMMjMgMThaTTAgMTlMMCAyMEwxIDIwTDEgMTlaTTUwIDIwTDUwIDIxTDUxIDIxTDUxIDIyTDUwIDIyTDUwIDI0TDQ5IDI0TDQ5IDI2TDUxIDI2TDUxIDI1TDUwIDI1TDUwIDI0TDUxIDI0TDUxIDIyTDUyIDIyTDUyIDIxTDUxIDIxTDUxIDIwWk0xMyAyMUwxMyAyMkwxNCAyMkwxNCAyM0wxNSAyM0wxNSAyMkwxNCAyMkwxNCAyMVpNNiAyMkw2IDIzTDcgMjNMNyAyMlpNOSAyMkw5IDIzTDEwIDIzTDEwIDIyWk0zOCAyM0wzOCAyNEwzOSAyNEwzOSAyM1pNNDcgMjNMNDcgMjRMNDggMjRMNDggMjNaTTUgMjVMNSAyOEw4IDI4TDggMjVaTTI1IDI1TDI1IDI4TDI4IDI4TDI4IDI1Wk0zMyAyNUwzMyAyN0wzNCAyN0wzNCAyNVpNNDUgMjVMNDUgMjhMNDggMjhMNDggMjVaTTYgMjZMNiAyN0w3IDI3TDcgMjZaTTI2IDI2TDI2IDI3TDI3IDI3TDI3IDI2Wk0zNSAyNkwzNSAyN0wzNiAyN0wzNiAyOEwzNyAyOEwzNyAyN0wzNiAyN0wzNiAyNlpNNDAgMjZMNDAgMjdMNDEgMjdMNDEgMjZaTTQ2IDI2TDQ2IDI3TDQ3IDI3TDQ3IDI2Wk0yMCAyN0wyMCAyOEwyMiAyOEwyMiAyN1pNNiAyOUw2IDMwTDUgMzBMNSAzMUw0IDMxTDQgMzNMNSAzM0w1IDMyTDcgMzJMNyAzMUw4IDMxTDggMzBMNyAzMEw3IDI5Wk00MCAyOUw0MCAzMEw0MiAzMEw0MiAzMUw0MCAzMUw0MCAzM0w0MSAzM0w0MSAzNEw0MiAzNEw0MiAzNUw0NCAzNUw0NCAzNEw0MyAzNEw0MyAzM0w0NSAzM0w0NSAzMkw0NCAzMkw0NCAzMUw0MyAzMUw0MyAzMEw0MiAzMEw0MiAyOVpNNiAzMEw2IDMxTDcgMzFMNyAzMFpNMTkgMzBMMTkgMzFMMjAgMzFMMjAgMzBaTTQ1IDMwTDQ1IDMxTDQ2IDMxTDQ2IDMyTDQ3IDMyTDQ3IDMxTDQ2IDMxTDQ2IDMwWk00MiAzMUw0MiAzMkw0MSAzMkw0MSAzM0w0MiAzM0w0MiAzMkw0MyAzMkw0MyAzMVpNNTIgMzFMNTIgMzJMNTMgMzJMNTMgMzFaTTE0IDMyTDE0IDMzTDE1IDMzTDE1IDMyWk0xOSAzMkwxOSAzNEwyMCAzNEwyMCAzMlpNMjQgMzJMMjQgMzNMMjUgMzNMMjUgMzRMMjcgMzRMMjcgMzNMMjUgMzNMMjUgMzJaTTM2IDMyTDM2IDMzTDM4IDMzTDM4IDMyWk0xIDMzTDEgMzRMMiAzNEwyIDMzWk0xNCAzNEwxNCAzNUwxNiAzNUwxNiAzNFpNMjEgMzVMMjEgMzZMMjIgMzZMMjIgMzVaTTMwIDM1TDMwIDM2TDMxIDM2TDMxIDM1Wk00OCAzNUw0OCAzNkw0OSAzNkw0OSAzOUw0OCAzOUw0OCA0MUw0NyA0MUw0NyA0Mkw0OCA0Mkw0OCA0MUw0OSA0MUw0OSA0MEw1MCA0MEw1MCAzNkw0OSAzNkw0OSAzNVpNNiAzNkw2IDM3TDcgMzdMNyAzOEw4IDM4TDggMzdMNyAzN0w3IDM2Wk0xMyAzNkwxMyAzN0wxNCAzN0wxNCAzNlpNMTUgMzZMMTUgMzlMMTYgMzlMMTYgMzZaTTM5IDM2TDM5IDM4TDM4IDM4TDM4IDQwTDM5IDQwTDM5IDM5TDQxIDM5TDQxIDM4TDQwIDM4TDQwIDM3TDQxIDM3TDQxIDM2Wk0xMSAzN0wxMSAzOEwxMCAzOEwxMCAzOUwxMSAzOUwxMSAzOEwxMiAzOEwxMiAzN1pNMjIgMzdMMjIgMzhMMjEgMzhMMjEgNDBMMjMgNDBMMjMgMzdaTTI5IDM3TDI5IDM4TDI4IDM4TDI4IDQxTDI3IDQxTDI3IDQyTDI1IDQyTDI1IDQzTDI3IDQzTDI3IDQ0TDMxIDQ0TDMxIDQ2TDMwIDQ2TDMwIDQ4TDI5IDQ4TDI5IDUwTDMxIDUwTDMxIDUxTDMyIDUxTDMyIDUyTDMzIDUyTDMzIDUxTDMyIDUxTDMyIDUwTDMxIDUwTDMxIDQ5TDMwIDQ5TDMwIDQ4TDMyIDQ4TDMyIDQ3TDMzIDQ3TDMzIDQ2TDM1IDQ2TDM1IDQ1TDMzIDQ1TDMzIDQ0TDM0IDQ0TDM0IDQzTDMzIDQzTDMzIDQxTDMyIDQxTDMyIDQyTDMxIDQyTDMxIDQxTDMwIDQxTDMwIDQzTDI3IDQzTDI3IDQyTDI5IDQyTDI5IDM4TDMxIDM4TDMxIDM3Wk0zNiAzN0wzNiAzOEwzNyAzOEwzNyAzN1pNMTMgMzhMMTMgNDBMMTQgNDBMMTQgNDFMMTUgNDFMMTUgNDBMMTQgNDBMMTQgMzhaTTE4IDM4TDE4IDM5TDE5IDM5TDE5IDQxTDIwIDQxTDIwIDM5TDE5IDM5TDE5IDM4Wk0zMyAzOEwzMyAzOUwzNCAzOUwzNCAzOFpNMzAgMzlMMzAgNDBMMzEgNDBMMzEgMzlaTTYgNDBMNiA0MUw3IDQxTDcgNDBaTTIxIDQxTDIxIDQyTDIyIDQyTDIyIDQxWk0zMiA0M0wzMiA0NEwzMyA0NEwzMyA0M1pNMTcgNDVMMTcgNDdMMTggNDdMMTggNDVaTTIwIDQ1TDIwIDQ2TDIxIDQ2TDIxIDQ3TDI0IDQ3TDI0IDQ2TDIxIDQ2TDIxIDQ1Wk0yNSA0NUwyNSA0OEwyOCA0OEwyOCA0NVpNMzIgNDVMMzIgNDZMMzMgNDZMMzMgNDVaTTQ1IDQ1TDQ1IDQ4TDQ4IDQ4TDQ4IDQ1Wk0yNiA0NkwyNiA0N0wyNyA0N0wyNyA0NlpNNDYgNDZMNDYgNDdMNDcgNDdMNDcgNDZaTTUwIDQ2TDUwIDQ3TDQ5IDQ3TDQ5IDQ5TDUwIDQ5TDUwIDQ4TDUxIDQ4TDUxIDQ2Wk0yMSA0OEwyMSA1MEwyMiA1MEwyMiA1MUwyMyA1MUwyMyA1MEwyNCA1MEwyNCA0OFpNMTIgNDlMMTIgNTBMMTMgNTBMMTMgNDlaTTIyIDQ5TDIyIDUwTDIzIDUwTDIzIDQ5Wk00NiA0OUw0NiA1MEw0NyA1MEw0NyA0OVpNMzUgNTBMMzUgNTFMMzYgNTFMMzYgNTBaTTM3IDUyTDM3IDUzTDM4IDUzTDM4IDUyWk0wIDBMMCA3TDcgN0w3IDBaTTEgMUwxIDZMNiA2TDYgMVpNMiAyTDIgNUw1IDVMNSAyWk00NiAwTDQ2IDdMNTMgN0w1MyAwWk00NyAxTDQ3IDZMNTIgNkw1MiAxWk00OCAyTDQ4IDVMNTEgNUw1MSAyWk0wIDQ2TDAgNTNMNyA1M0w3IDQ2Wk0xIDQ3TDEgNTJMNiA1Mkw2IDQ3Wk0yIDQ4TDIgNTFMNSA1MUw1IDQ4WiIgZmlsbD0iIzAwMDAwMCIvPjwvZz48L2c+PC9zdmc+Cg==', '2026-09-14 20:19:59', '2026-09-14 20:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Dale Quist', 'crepindale@gmail.com', NULL, '$2y$12$kqtkfRmIHmG7XmwY9uppU.pu5.aBGuqDWjIUQPV7M49QiL4uVllfu', NULL, '2026-09-13 09:27:47', '2026-09-13 09:27:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `consultation_requests`
--
ALTER TABLE `consultation_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`);

--
-- Indexes for table `event_gallery_comments`
--
ALTER TABLE `event_gallery_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_gallery_comments_event_gallery_item_id_foreign` (`event_gallery_item_id`);

--
-- Indexes for table `event_gallery_items`
--
ALTER TABLE `event_gallery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_gallery_items_event_id_foreign` (`event_id`);

--
-- Indexes for table `event_planning_requests`
--
ALTER TABLE `event_planning_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_reference_unique` (`reference`),
  ADD KEY `payments_event_id_foreign` (`event_id`),
  ADD KEY `payments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_reference_unique` (`reference`),
  ADD KEY `tickets_event_id_foreign` (`event_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `consultation_requests`
--
ALTER TABLE `consultation_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_gallery_comments`
--
ALTER TABLE `event_gallery_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_gallery_items`
--
ALTER TABLE `event_gallery_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_planning_requests`
--
ALTER TABLE `event_planning_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_gallery_comments`
--
ALTER TABLE `event_gallery_comments`
  ADD CONSTRAINT `event_gallery_comments_event_gallery_item_id_foreign` FOREIGN KEY (`event_gallery_item_id`) REFERENCES `event_gallery_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_gallery_items`
--
ALTER TABLE `event_gallery_items`
  ADD CONSTRAINT `event_gallery_items_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
