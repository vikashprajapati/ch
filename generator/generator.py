import json
from pprint import pprint
import base64, hashlib

# User Data -> MODIFY ONLY WHEN YOU KNOW WHAT YOU ARE DOING

# Mode is "prod" / "dev"

fileLevelObjectName = "questions"
fieldQuestionNumber = "Qnumber"
fieldQuestionData = "Qdata"
fieldQuestionType = "Qtype"
fieldQuestionAnswer = "Qanswer"
fieldQuestionHint = "Qhints"

# Fixed commands


def queryToCreateDB():
    return """
    CREATE DATABASE IF NOT EXISTS ducs_chakravyuh_mayajaal;
    USE ducs_chakravyuh_mayajaal;
    """


def queryTocreateAllTables():
    return """
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

    """


def queryToTruncateRequiredTables():
    return """
    TRUNCATE TABLE `hint`;
    TRUNCATE TABLE `question`;
    """


# Functions to work on hints


def encodeBase64(stringToEncode, mode):
    if mode == "prod":
        return base64.b64encode(stringToEncode.encode()).decode()
    else:
        return stringToEncode


def decodeBase64(stringToDecode, mode):
    if mode == "prod":
        return base64.b64decode(stringToDecode.encode()).decode()
    else:
        return stringToDecode



def queryToInsertEncodedHints(questionFile, mode):
    query = """\nINSERT INTO `hint` (`ques_id`, `hint_number`, `data`) VALUES \n"""
    with open(questionFile) as file:
        questions = json.load(file)[fileLevelObjectName]
        for qNo, question in enumerate(questions):
            for hintNo, hint in enumerate(question[fieldQuestionHint]):
                questionId = qNo + 1
                hint_number = hintNo + 1
                encoded_hint_data = encodeBase64(hint, mode)
                # generate query here
                query += "({0}, {1}, '{2}'), \n".format(
                    questionId, hint_number, encoded_hint_data)
    return query[:-3] + ";"


# Functions to work on answers


def encodeMd5Hash(stringToEncode, mode):
    if mode == "prod":
        return hashlib.md5(stringToEncode.encode()).hexdigest()
    else:
        return stringToEncode


def queryToInsertEncodedQuestions(questionFile, mode):
    query = """\nINSERT INTO `question` (`id`, `answer`, `data`, `type`) VALUES \n"""
    with open(questionFile) as file:
        questions = json.load(file)[fileLevelObjectName]
        for qNo, question in enumerate(questions):
            questionId = qNo + 1
            answer = encodeMd5Hash(question[fieldQuestionAnswer], mode)
            questionData = question[fieldQuestionData]
            questionType = question[fieldQuestionType]
            # generate query here
            query += "({0}, '{1}', '{2}' ,'{3}'), \n".format(
                questionId, answer, questionData, questionType)
    return query[:-3] + ";"


# generate dump


def generateDatabaseDump(jsonFileOfQuestions,
                         sqlDumpOfQuestions, mode):
    print(queryToCreateDB(), file=open(sqlDumpOfQuestions, "w"))
    print(queryTocreateAllTables(), file=open(sqlDumpOfQuestions, "a"))
    print(queryToTruncateRequiredTables(), file=open(sqlDumpOfQuestions, "a"))
    print(
        queryToInsertEncodedHints(jsonFileOfQuestions, mode),
        file=open(sqlDumpOfQuestions, "a"))
    print(
        queryToInsertEncodedQuestions(jsonFileOfQuestions, mode),
        file=open(sqlDumpOfQuestions, "a"))


def main(*args):
    mode = args[1] if len(args) > 3 else "prod"
    questions = args[2] if len(args) > 3 else "questions.json"
    sqlDump = args[3] if len(args) > 3 else "questions_prod_SQL_dump.sql"
    generateDatabaseDump(questions, sqlDump, mode)


if __name__ == "__main__":
    import sys
    main(*sys.argv)
