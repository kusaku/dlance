SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE `ci_associated`;
TRUNCATE `ci_balance_applications`;
TRUNCATE `ci_banned`;
TRUNCATE `ci_blogs`;
TRUNCATE `ci_blogs_comments`;
TRUNCATE `ci_cart`;
TRUNCATE `ci_categories_followers`;
TRUNCATE `ci_contacts`;
TRUNCATE `ci_contacts`;
TRUNCATE `ci_daily_auth`;
TRUNCATE `ci_designs`;
TRUNCATE `ci_designs_banned`;
TRUNCATE `ci_designs_comments`;
TRUNCATE `ci_designs_options`;
TRUNCATE `ci_designs_views`;
TRUNCATE `ci_downloads`;
TRUNCATE `ci_events`;
TRUNCATE `ci_events`;
TRUNCATE `ci_groups`;
TRUNCATE `ci_images`;
TRUNCATE `ci_messages`;
TRUNCATE `ci_payments`;
TRUNCATE `ci_portfolio`;
TRUNCATE `ci_profile`;
TRUNCATE `ci_purchased`;
TRUNCATE `ci_purses`;
TRUNCATE `ci_rating`;
TRUNCATE `ci_ratings`;
TRUNCATE `ci_reports`;
TRUNCATE `ci_reviews`;
TRUNCATE `ci_services`;
TRUNCATE `ci_tags`;
TRUNCATE `ci_transaction`;
TRUNCATE `ci_users`;
TRUNCATE `ci_users_followers`;
TRUNCATE `ci_users_settings`;
TRUNCATE `ci_views`;
TRUNCATE `ci_votes`;
INSERT INTO `ci_groups` (`id`, `user_id`, `name`) VALUES
(1, 0, 'Общая группа'),
(2, 0, 'Избранные'),
(3, 0, 'Архив'),
(4, 0, 'Черный список');
INSERT INTO `ci_users` (`id`, `username`, `password`, `email`, `name`, `surname`, `sex`, `userpic`, `day`, `month`, `year`, `ip_address`, `created`, `last_login`, `active`, `activation_code`, `views`, `short_descr`, `full_descr`, `icq`, `skype`, `telephone`, `website`, `balance`, `rating`, `tariff_period`, `tariff`, `team`, `city_id`, `country_id`) 
VALUES (0, '', '', '', '', '', 0, '', 0, 0, 0, '', NULL, NULL, 0, '', 0, '', NULL, '', '', '', '', 0, 0, 0, 1, NULL, NULL, NULL);
INSERT INTO `ci_users_settings` (`id`, `user_id`, `mailer`, `notice`, `hint`, `adult`) 
VALUES ('0', '0', '0', '0', '0', '0');

SET FOREIGN_KEY_CHECKS = 1;
