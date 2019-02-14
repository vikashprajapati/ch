# DB Generator

1. make a `questions.json` file similar to `sample_questions.json`
2. place all the required files for questions in `chakraData` folder present in the document root
3. make all file names long and unpredictable like `hkebjcwkecbfw.png`

4. run the script `python generator.py` . This will use `questions.json` and a SQL file named `questions_prod_SQL_dump.sql` is generated.

5. For dev mode dump in plain text, use first command from below.

   ```shell
   python generator.py dev questions.json questions_dev_SQL_dump.sql
   python generator.py prod questions.json questions_prod_SQL_dump.sql
   ```

6. import this file in phpmyadmin / mysql, it will automatically create db, tables and populate tables with hashes of questions and hints.

7. also make sure to upload `chakraData` onto the server otherwise questions will break.
