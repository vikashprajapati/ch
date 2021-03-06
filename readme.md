# chakravyuh

Please refer [app.ini](./app.ini.php) before moving forward.
To change event's start and end date, goto [timer.php](./timer.php)

## DB

- import `questions_dev_SQL_dump.sql` to test in dev mode. Set `devmode = 1` in [app.ini.php](./app.ini.php)
- import `questions_prod_SQL_dump.sql` to test the prod mode. Set `devmode = 0` in [app.ini.php](./app.ini.php)

## todo

- [x] These 3 files were in gitignore we need to rebuild / recode these
  - [x] database.txt
  - [x] hintzz.txt
  - [x] hasher.php
- [x] jquery issue i think. Animations and live load & hints not working.
- [x] md5 hasher.php for hints and answer i.e. to populate them
- [x] login popup not coming for facebook login - a frame because it set 'X-Frame-Options' to 'deny'.
- [x] remove timer
- [x] json file from avinash
- [x] hasher.php or hasher.py
- [x] question table and hint table
- [x] 5 table generate if not exists + 2 table truncate + generate complete DB commands shit
- [x] questions shuffle -> admin -> by changing ids of questions
- [x] user block karna hai - set `blocked` field corresponding to user as `1` . The example query `UPDATE user SET blocked= '1' WHERE user.name= "JATIN ROHILLA"`
- [x] test everything in dev mode - generated by generator
- [x] test everything in production mode - generated by generator
- [x] hints ka time control -> itni minute baad
- [x] thumbs up -> should not affect dom
- [x] 12 attemps visible - done
- [x] play a mini event for self test
- [x] fix favicon.ico
- [ ] move start and end date control to db
- [ ] UI colors and everything
- [ ] documentation and instructions
- [ ] thumbs up ki placement
- [ ] index page is stacking old error messages. we need to remove them.
- [ ] add developers name to page in main sankalan
- [ ] a set of positive and negative words for each question, to show the right path.
- [ ] test on firefox - fb login not working
- [ ] when user puts answer in first attempt, no row is generated in userattempts. Make a row & put value "correctAns" when he enter right answer
- [ ] test fb by loggin jayants id on fb
- [ ] lag in user attemps ->> enter an empty array in user attempts when user reaches next level
- [ ] winner on level x -> no of questions
- [ ] fb app login popup
- [ ] start end time
- [ ] user attemps ke saath name as well
 
## Deploy time

- give the admin ssh access / mysql workbench access to monitor the db live
- FB login app live
- [x] deploy site to https for fb to work

## future scope

- game status -> paused - 1/0 -> "pause" - PAUSE GAME BUTTON
- change a hint / answer at last moment

## Secrets

- md5 hashing is used while submitting answers.
- DB -> answers -> store -> in md5
- for hints base64 decode is used.
- `app.ini.php` is used for config. It has been gitignored. use `scp` to paste it to server.
- a sample `app.ini.php` has been provided. Make a `app.ini.php` based on it before starting.
- also, actual `production-dump.sql` and actual `chakraData` has been put in secret & secret is gitignored. Use scp to paste data to server and import dump directly.

# DB Structure

## Tables

- QUESTION (ID, ANSWER, DATA, TYPE)

- HINT (QID, HINT#, HINT)

- USER (ID, NAME, EMAIL, PICTURE_URL, BLOCKED, LEVEL#, POINTS, LEVEL_UPDATE_TIME, LEVEL_UPDATE_TIME_MICRO, LAST_HINT_TIME, NEXT_HINT#)

- USERATTEMPT (UID, LEVEL, COUNT, LAST_FIVE_ATTEMPTS)

- LEVELCLEAR (LEVEL#, TIME, TIME_MICRO, UID)

- HINT_TIME_CONTROL
  -$LowerLevels_fixed_distance_from_last_hint = 5
  - $LowerLevels_added_time_factor_based_on_hint_level = 1
  - $partition_point_is_at_level = 20
  - $UpperLevels_fixed_distance_from_last_hint = 10
  - $UpperLevels_added_time_factor_based_on_hint_level = 2


## Scoring

1. Top 20 - 10
2. Next 30 - 9
3. Rest - 8 points
