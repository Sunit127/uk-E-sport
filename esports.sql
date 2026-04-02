-- ============================================================
-- E-SPORTS LEAGUE DATABASE - CORRECTED VERSION
-- Description: Complete database schema for E-Sports League
-- Author: E-Sports Development Team
-- Created: 2025
-- ============================================================

-- Drop database if exists (CAUTION: This will delete all data)
DROP DATABASE IF EXISTS `esports_db`;

-- Create database
CREATE DATABASE IF NOT EXISTS `esports_db` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `esports_db`;

-- ============================================================
-- TABLE STRUCTURE: user
-- Description: Admin users for system authentication
-- ============================================================

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','moderator','viewer') COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user with SECURE PASSWORD HASH
-- Username: admin
-- Password: password123
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`, `created_at`, `last_login`, `is_active`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@esports-league.com', 'admin', CURRENT_TIMESTAMP, NULL, 1);

-- Additional admin users (optional)
INSERT INTO `user` (`username`, `password`, `email`, `role`, `is_active`) VALUES
('moderator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator@esports-league.com', 'moderator', 1);

-- ============================================================
-- TABLE STRUCTURE: team
-- Description: E-Sports teams information
-- ============================================================

DROP TABLE IF EXISTS `team`;

CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `founded_date` date DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `social_twitter` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_discord` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_wins` int(11) DEFAULT 0,
  `total_losses` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_location` (`location`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample teams
INSERT INTO `team` (`id`, `name`, `location`, `founded_date`, `description`, `total_wins`, `total_losses`, `is_active`) VALUES
(1, 'NovaCore', 'Sunderland', '2023-01-15', 'Elite gaming squad from Sunderland with top-tier players', 45, 12, 1),
(2, 'IronWolves', 'Newcastle', '2023-03-20', 'Aggressive playstyle team known for strategic dominance', 38, 18, 1),
(3, 'PulseForge', 'Middlesbrough', '2023-02-10', 'Rising stars in the competitive gaming scene', 32, 22, 1),
(4, 'ShadowRift', 'Durham', '2023-04-05', 'Dark horse team with unpredictable tactics', 40, 15, 1);

-- ============================================================
-- TABLE STRUCTURE: participant
-- Description: Individual players/participants in tournaments
-- ============================================================

DROP TABLE IF EXISTS `participant`;

CREATE TABLE `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gamertag` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kills` float DEFAULT 0,
  `deaths` float DEFAULT 0,
  `assists` int(11) DEFAULT 0,
  `headshots` int(11) DEFAULT 0,
  `team_id` int(11) DEFAULT NULL,
  `rank` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Unranked',
  `level` int(11) DEFAULT 1,
  `experience_points` int(11) DEFAULT 0,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'UK',
  `date_of_birth` date DEFAULT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_active` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `gamertag` (`gamertag`),
  KEY `team_id` (`team_id`),
  KEY `idx_kills` (`kills`),
  KEY `idx_active` (`is_active`),
  CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample participants (30 players across 4 teams)
INSERT INTO `participant` (`id`, `firstname`, `surname`, `email`, `gamertag`, `kills`, `deaths`, `assists`, `headshots`, `team_id`, `rank`, `level`, `experience_points`) VALUES
(1, 'Lorette', 'Lamacraft', 'llamacraft0@census.gov', 'LamaElite', 245.5, 98.2, 156, 89, 1, 'Diamond', 45, 12500),
(2, 'Georgeanne', 'Seston', 'gseston1@networksolutions.com', 'SestonPro', 312.8, 102.5, 201, 134, 1, 'Master', 52, 15800),
(3, 'Lemmy', 'Stavers', 'lstavers2@cam.ac.uk', 'LemmySlayer', 189.3, 145.7, 98, 67, 2, 'Platinum', 38, 9500),
(4, 'Eduard', 'Roelvink', 'eroelvink3@studiopress.com', 'EduardGG', 278.9, 87.3, 178, 112, 1, 'Diamond', 48, 14200),
(5, 'Dennis', 'Oxenham', 'doxenham4@chronoengine.com', 'DennisDestroyer', 334.2, 76.8, 223, 156, 4, 'Master', 55, 17500),
(6, 'Lynnett', 'Christophe', 'lchristophe5@yahoo.com', 'LynxGamer', 198.4, 134.6, 145, 78, 1, 'Gold', 42, 11000),
(7, 'Ken', 'Gammidge', 'kgammidge6@telegraph.co.uk', 'KennyKiller', 401.7, 92.1, 267, 189, 4, 'Grandmaster', 58, 19200),
(8, 'Dorie', 'Espina', 'despina7@usnews.com', 'DorieSniper', 256.3, 118.5, 167, 98, 1, 'Platinum', 46, 13400),
(9, 'Lawrence', 'Upsale', 'lupsale8@accuweather.com', 'LawrenceX', 223.6, 156.2, 134, 87, 1, 'Gold', 41, 10800),
(10, 'Evaleen', 'Hartin', 'ehartin9@cornell.edu', 'EvaAssassin', 289.5, 95.7, 198, 125, 2, 'Diamond', 49, 14900),
(11, 'Therese', 'Currin', 'tcurrina@taobao.com', 'TherryGG', 178.2, 167.8, 112, 65, 1, 'Silver', 36, 8700),
(12, 'Chiquita', 'Rapi', 'crapib@sun.com', 'ChiquitaBanana', 267.8, 103.4, 189, 103, 2, 'Platinum', 47, 13800),
(13, 'Corabella', 'Frude', 'cfrudec@npr.org', 'CoraWarrior', 312.1, 88.9, 234, 142, 1, 'Master', 51, 15500),
(14, 'Eveleen', 'Cranna', 'ecrannad@twitpic.com', 'EveCrusher', 245.7, 124.3, 156, 92, 1, 'Diamond', 44, 12200),
(15, 'Brier', 'Westmerland', 'bwestmerlande@home.pl', 'BrierBeast', 356.4, 79.2, 245, 167, 4, 'Master', 54, 16900),
(16, 'Petra', 'Loffhead', 'ploffheadf@rambler.ru', 'PetraPredator', 234.8, 142.6, 167, 89, 2, 'Gold', 43, 11500),
(17, 'Elinor', 'Ranscombe', 'eranscombeg@state.tx.us', 'ElinorElite', 389.2, 71.5, 278, 178, 4, 'Grandmaster', 57, 18700),
(18, 'Reeba', 'Somerbell', 'rsomerbellh@alexa.com', 'ReebaRage', 298.6, 98.7, 212, 134, 4, 'Diamond', 50, 15100),
(19, 'Dulciana', 'Kaming', 'dkamingi@dailymail.co.uk', 'DulciKilla', 267.3, 112.8, 189, 98, 1, 'Platinum', 46, 13100),
(20, 'Eal', 'Willers', 'ewillersj@businessinsider.com', 'EalExecutor', 223.9, 145.1, 145, 76, 1, 'Gold', 40, 10500),
(21, 'Lucina', 'Hessentaler', 'lhessentalerk@histats.com', 'LuciLegend', 378.5, 82.3, 256, 171, 4, 'Master', 56, 17800),
(22, 'Thatch', 'Bosse', 'tbossel@engadget.com', 'ThatchTitan', 412.8, 68.9, 289, 195, 4, 'Grandmaster', 59, 19800),
(23, 'Hanson', 'Adamoli', 'hadamolim@prnewswire.com', 'HansonHero', 289.4, 96.2, 201, 128, 1, 'Diamond', 49, 14600),
(24, 'Mildrid', 'Marton', 'mmartonn@auda.org.au', 'MildyMighty', 334.7, 85.6, 234, 152, 4, 'Master', 53, 16200),
(25, 'Jeana', 'Yakuntzov', 'jyakuntzovo@plala.or.jp', 'JeanaJuggernaut', 298.1, 101.4, 209, 136, 4, 'Diamond', 50, 15300),
(26, 'Ulrick', 'Fyall', 'ufyallp@unc.edu', 'UlrickUnstoppable', 267.9, 118.7, 178, 94, 3, 'Platinum', 47, 13600),
(27, 'Clary', 'Wevell', 'cwevellq@ucoz.com', 'ClaryClutch', 245.3, 129.5, 167, 88, 3, 'Gold', 44, 12000),
(28, 'Cissiee', 'Plewes', 'cplewesr@smh.com.au', 'CissieSnipe', 212.6, 138.9, 145, 79, 1, 'Silver', 39, 9800),
(29, 'Thorn', 'Richen', 'trichens@usnews.com', 'ThornThrasher', 289.7, 107.3, 198, 119, 2, 'Diamond', 48, 14400),
(30, 'Gabriella', 'Clearley', 'gclearleyt@tinypic.com', 'GabbyGamer', 256.8, 115.2, 176, 97, 3, 'Platinum', 45, 12800);

-- ============================================================
-- TABLE STRUCTURE: merchandise
-- Description: Merchandise registration and orders
-- ============================================================

DROP TABLE IF EXISTS `merchandise`;

CREATE TABLE `merchandise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'UK',
  `terms` tinyint(1) NOT NULL DEFAULT 0,
  `newsletter` tinyint(1) DEFAULT 0,
  `order_status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `order_total` decimal(10,2) DEFAULT 0.00,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`order_status`),
  KEY `idx_registered` (`registered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample merchandise registrations
INSERT INTO `merchandise` (`id`, `firstname`, `surname`, `email`, `phone`, `city`, `postal_code`, `terms`, `newsletter`, `order_status`, `order_total`, `registered_at`) VALUES
(1, 'John', 'Smith', 'john.smith@email.com', '07700123456', 'London', 'SW1A 1AA', 1, 1, 'delivered', 45.99, '2025-01-15 10:30:00'),
(2, 'Emma', 'Johnson', 'emma.j@email.com', '07700234567', 'Manchester', 'M1 1AD', 1, 1, 'shipped', 67.50, '2025-01-18 14:20:00'),
(3, 'Michael', 'Williams', 'mike.w@email.com', '07700345678', 'Birmingham', 'B1 1BB', 1, 0, 'processing', 89.99, '2025-01-20 09:15:00'),
(4, 'Sophie', 'Brown', 'sophie.brown@email.com', '07700456789', 'Leeds', 'LS1 1BA', 1, 1, 'pending', 34.99, '2025-01-22 16:45:00'),
(5, 'Oliver', 'Jones', 'oliver.jones@email.com', '07700567890', 'Liverpool', 'L1 1AA', 1, 1, 'delivered', 55.00, '2025-01-25 11:30:00');

-- ============================================================
-- TABLE STRUCTURE: tournament
-- Description: Tournament information and schedules
-- ============================================================

DROP TABLE IF EXISTS `tournament`;

CREATE TABLE `tournament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prize_pool` decimal(10,2) DEFAULT 0.00,
  `max_participants` int(11) DEFAULT 32,
  `current_participants` int(11) DEFAULT 0,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `registration_deadline` datetime NOT NULL,
  `tournament_status` enum('upcoming','ongoing','completed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'upcoming',
  `format` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Single Elimination',
  `rules_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stream_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`tournament_status`),
  KEY `idx_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample tournaments
INSERT INTO `tournament` (`id`, `name`, `game_title`, `description`, `prize_pool`, `max_participants`, `current_participants`, `start_date`, `end_date`, `registration_deadline`, `tournament_status`, `format`) VALUES
(1, 'Spring Championship 2025', 'CS:GO', 'Premier competitive tournament for the spring season', 10000.00, 32, 28, '2025-03-15 10:00:00', '2025-03-17 20:00:00', '2025-03-10 23:59:59', 'upcoming', 'Double Elimination'),
(2, 'Winter Masters 2025', 'Valorant', 'Elite winter tournament series', 15000.00, 16, 16, '2025-02-01 12:00:00', '2025-02-03 18:00:00', '2025-01-28 23:59:59', 'completed', 'Single Elimination'),
(3, 'UK Regional Finals', 'League of Legends', 'Regional championship finals', 25000.00, 8, 6, '2025-04-20 14:00:00', '2025-04-22 22:00:00', '2025-04-15 23:59:59', 'upcoming', 'Round Robin'),
(4, 'Summer Invitational', 'Fortnite', 'Invitation-only summer event', 50000.00, 64, 48, '2025-06-10 10:00:00', '2025-06-15 20:00:00', '2025-06-05 23:59:59', 'upcoming', 'Battle Royale');

-- ============================================================
-- TABLE STRUCTURE: match_history
-- Description: Match results and statistics
-- ============================================================

DROP TABLE IF EXISTS `match_history`;

CREATE TABLE `match_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) DEFAULT NULL,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `team1_score` int(11) DEFAULT 0,
  `team2_score` int(11) DEFAULT 0,
  `winner_id` int(11) DEFAULT NULL,
  `match_date` datetime NOT NULL,
  `match_duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `map_played` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `match_type` enum('group_stage','quarter_final','semi_final','final','exhibition') COLLATE utf8mb4_unicode_ci DEFAULT 'group_stage',
  `vod_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tournament_id` (`tournament_id`),
  KEY `team1_id` (`team1_id`),
  KEY `team2_id` (`team2_id`),
  KEY `winner_id` (`winner_id`),
  CONSTRAINT `match_history_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE,
  CONSTRAINT `match_history_ibfk_2` FOREIGN KEY (`team1_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  CONSTRAINT `match_history_ibfk_3` FOREIGN KEY (`team2_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  CONSTRAINT `match_history_ibfk_4` FOREIGN KEY (`winner_id`) REFERENCES `team` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample match history
INSERT INTO `match_history` (`id`, `tournament_id`, `team1_id`, `team2_id`, `team1_score`, `team2_score`, `winner_id`, `match_date`, `match_duration`, `map_played`, `match_type`) VALUES
(1, 2, 1, 2, 16, 12, 1, '2025-02-01 14:30:00', 45, 'Dust II', 'quarter_final'),
(2, 2, 3, 4, 10, 16, 4, '2025-02-01 16:00:00', 52, 'Inferno', 'quarter_final'),
(3, 2, 1, 4, 16, 14, 1, '2025-02-02 15:00:00', 58, 'Mirage', 'semi_final'),
(4, 1, 2, 3, 13, 16, 3, '2025-01-20 18:00:00', 48, 'Nuke', 'exhibition');

-- ============================================================
-- VIEWS: Useful database views for quick queries
-- ============================================================

-- View: Player Statistics with K/D Ratio
DROP VIEW IF EXISTS `vw_player_stats`;

CREATE VIEW `vw_player_stats` AS
SELECT 
    p.id,
    p.firstname,
    p.surname,
    p.gamertag,
    p.email,
    p.kills,
    p.deaths,
    p.assists,
    p.headshots,
    CASE 
        WHEN p.deaths > 0 THEN ROUND(p.kills / p.deaths, 2)
        ELSE p.kills
    END AS kd_ratio,
    p.rank,
    p.level,
    p.experience_points,
    t.name AS team_name,
    t.location AS team_location,
    p.is_active
FROM participant p
LEFT JOIN team t ON p.team_id = t.id;

-- View: Team Statistics
DROP VIEW IF EXISTS `vw_team_stats`;

CREATE VIEW `vw_team_stats` AS
SELECT 
    t.id,
    t.name AS team_name,
    t.location,
    COUNT(p.id) AS player_count,
    SUM(p.kills) AS total_kills,
    SUM(p.deaths) AS total_deaths,
    CASE 
        WHEN SUM(p.deaths) > 0 THEN ROUND(SUM(p.kills) / SUM(p.deaths), 2)
        ELSE SUM(p.kills)
    END AS team_kd_ratio,
    SUM(p.assists) AS total_assists,
    SUM(p.headshots) AS total_headshots,
    AVG(p.level) AS avg_player_level,
    t.total_wins,
    t.total_losses,
    t.is_active
FROM team t
LEFT JOIN participant p ON t.id = p.team_id AND p.is_active = 1
GROUP BY t.id, t.name, t.location, t.total_wins, t.total_losses, t.is_active;

-- ============================================================
-- INDEXES: Additional indexes for performance
-- ============================================================

ALTER TABLE `participant` ADD INDEX `idx_fullname` (`firstname`, `surname`);
ALTER TABLE `participant` ADD INDEX `idx_gamertag` (`gamertag`);
ALTER TABLE `merchandise` ADD INDEX `idx_fullname_merch` (`firstname`, `surname`);
ALTER TABLE `tournament` ADD INDEX `idx_start_date` (`start_date`);

-- ============================================================
-- SUCCESS MESSAGE
-- ============================================================

SELECT 
    '✓ DATABASE SETUP COMPLETE!' AS status,
    'E-Sports League Database v2.0.1' AS message,
    'All tables, views, and sample data created successfully' AS details,
    'Default Login: admin / password123' AS login_info;

-- ============================================================
-- VERIFICATION QUERIES
-- ============================================================

-- Check admin user
SELECT 'Admin User Check' AS check_type, username, email, role, is_active 
FROM user WHERE username = 'admin';

-- Check table counts
SELECT 'Database Statistics' AS info,
    (SELECT COUNT(*) FROM user) AS total_users,
    (SELECT COUNT(*) FROM team) AS total_teams,
    (SELECT COUNT(*) FROM participant) AS total_participants,
    (SELECT COUNT(*) FROM merchandise) AS total_merchandise,
    (SELECT COUNT(*) FROM tournament) AS total_tournaments;

-- ============================================================
-- END OF SQL FILE
-- ============================================================
