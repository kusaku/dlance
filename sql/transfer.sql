SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `dlanceinno`.`ci_users` (`id`, `username`, `password`, `email`, `name`, `surname`, `sex`, `userpic`, `day`, `month`, `year`, `ip_address`, `created`, `last_login`, `active`, `activation_code`, `views`, `short_descr`, `full_descr`, `icq`, `skype`, `telephone`, `website`, `balance`, `rating`, `tariff_period`, `tariff`, `team`, `city_id`, `country_id`)
SELECT `id`, `username`, `password`, `email`, `name`, `surname`, `sex`, `userpic`, `day`, `month`, `year`, `ip_address`, `created`, `last_login`, `active`, `activation_code`, `views`, `short_descr`, `full_descr`, `icq`, `skype`, `telephone`, `website`, `balance`, `rating`, 0, 0, 1, `city_id`, `country_id` FROM `dlance`.`ci_users`;

INSERT INTO `dlanceinno`.`ci_users_settings` (`id`, `user_id`, `mailer`, `notice`, `hint`, `adult`)
SELECT  `id` , `user_id` , `mailer` , `notice` , 0, 0  FROM `dlance`.`ci_users_settings`;

INSERT INTO `dlanceinno`.`ci_designs` (`id`, `user_id`, `category`, `date`, `title`, `descr`, `text`, `small_image1`, `mid_image1`, `full_image1`, `small_image2`, `mid_image2`, `full_image2`, `small_image3`, `mid_image3`, `full_image3`, `dfile`, `source`, `price_1`, `price_2`, `payment_type`, `sales`, `views`, `status`, `like`, `dislike`, `rating`, `moder`)
SELECT `id`, `user_id`, `category`, `date`, `title`, `descr`, `text`, `small_image` as `small_image1`, `small_image` as `mid_image1`, `full_image` as `full_image1`, '', '', '', '', '', '', '', '', `price_1`, `price_2`, `payment_type`, `sales`, `views`, `status`, 0, 0, 0, 1 FROM `dlance`.`ci_designs`;

INSERT INTO `dlanceinno`.`ci_designs_options` (`design_id`, `destination`, `theme`, `flash`, `stretch`, `columns`, `quality`, `type`, `tone`, `bright`, `style`, `adult`)
SELECT `id` AS `design_id`, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0 FROM `dlance`.`ci_designs`;

INSERT INTO `dlanceinno`.`ci_portfolio` (`id`, `user_id`, `position`, `date`, `title`, `descr`, `small_image`, `full_image`)
SELECT `id`, `user_id`, `position`, `date`, `title`, `descr`, `small_image`, `full_image` FROM `dlance`.`ci_portfolio`;

INSERT INTO `dlanceinno`.`ci_profile` (`user_id`, `price_1`, `price_2`)
SELECT `user_id`, `price_1`, `price_2` FROM `dlance`.`ci_profile`;

INSERT INTO `dlanceinno`.`ci_reviews` (`id`, `user_id`, `from_id`, `date`, `text`, `rating`, `moder_date`, `moder_user_id`)
SELECT `id` , `user_id` , 0, `date` , CONCAT( `project` , '<br/>', `text` , '<br/>', `project` ) AS `text` , `rating` , 0, 0 FROM `dlance`.`ci_reviews`;

SET FOREIGN_KEY_CHECKS = 1;
