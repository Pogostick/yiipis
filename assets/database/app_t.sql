CREATE TABLE `app_t` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name_text` varchar(200) NOT NULL,
  `app_url_text` varchar(1024) NOT NULL,
  `dev_app_url_text` varchar(1024) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `dev_server_id` int(11) DEFAULT NULL,
  `last_push_date` datetime DEFAULT NULL,
  `dev_last_push_date` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `lmod_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
