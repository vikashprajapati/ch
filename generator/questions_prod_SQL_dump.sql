
    CREATE DATABASE IF NOT EXISTS ducs_chakravyuh_mayajaal;
    USE ducs_chakravyuh_mayajaal;
    

    CREATE TABLE IF NOT EXISTS `hint` (
    `ques_id` int(11) NOT NULL,
    `hint_number` int(11) NOT NULL,
    `data` varchar(200) DEFAULT NULL,
    PRIMARY KEY (`ques_id`,`hint_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS `levelcleartime` (
    `level` int(11) NOT NULL,
    `time` datetime NOT NULL,
    `time_micro` double NOT NULL,
    `user_id` bigint(20) NOT NULL,
    PRIMARY KEY (`level`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS `question` (
    `id` int(11) NOT NULL,
    `answer` text NOT NULL,
    `data` varchar(200) NOT NULL,
    `type` varchar(5) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS `user` (
    `id` bigint(20) NOT NULL,
    `name` varchar(100) NOT NULL,
    `email` varchar(50) NOT NULL,
    `picture_url` varchar(400) NOT NULL,
    `blocked` int(1) NOT NULL DEFAULT '0',
    `level` int(11) NOT NULL,
    `points` int(11) NOT NULL,
    `level_update_time` datetime NOT NULL,
    `level_update_time_micro` double NOT NULL,
    `last_hint_time` datetime NOT NULL,
    `next_hint` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS `userattempt` (
    `user_id` bigint(20) NOT NULL,
    `level` int(11) NOT NULL,
    `count` int(11) NOT NULL,
    `last_five_attempts` varchar(200) NOT NULL,
    PRIMARY KEY (`user_id`,`level`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE `hint_time_control` (
    `id` int(11) NOT NULL,
    `LowerLevels_fixed_distance_from_last_hint` int(11) DEFAULT '5',
    `LowerLevels_added_time_factor_based_on_hint_level` int(11) DEFAULT '1',
    `partition_point_is_at_level` int(11) DEFAULT '20',
    `UpperLevels_fixed_distance_from_last_hint` int(11) DEFAULT '10',
    `UpperLevels_added_time_factor_based_on_hint_level` int(11) DEFAULT '2',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    INSERT INTO `hint_time_control` (`id`, `LowerLevels_fixed_distance_from_last_hint`, `LowerLevels_added_time_factor_based_on_hint_level`, `partition_point_is_at_level`, `UpperLevels_fixed_distance_from_last_hint`, `UpperLevels_added_time_factor_based_on_hint_level`) VALUES (1, 5, 1, 20, 10, 2);

    

    TRUNCATE TABLE `hint`;
    TRUNCATE TABLE `question`;
    

INSERT INTO `hint` (`ques_id`, `hint_number`, `data`) VALUES 
(1, 1, 'aGludDE='), 
(1, 2, 'aGludDI='), 
(2, 1, 'aGludDM='), 
(2, 2, 'aGludDQ='), 
(3, 1, 'aGludDU='), 
(4, 1, 'aGludDY=');

INSERT INTO `question` (`id`, `answer`, `data`, `type`) VALUES 
(1, '9cdfb439c7876e703e307864c9167a15', 'hello' ,'text'), 
(2, 'ebb7e099481958b192561052613d8386', './chakraData/myIMAGE.png' ,'image'), 
(3, '902fbdd2b1df0c4f70b4a5d23525e932', './chakraData/myAUDIO.mp3' ,'audio'), 
(4, '153495edec1b606c24947b1335998bd9', './chakraData/myVIDEO.mp4' ,'video');
