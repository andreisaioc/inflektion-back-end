To get started with this job:

using this repo: https://github.com/php-mime-mail-parser/php-mime-mail-parser

1. Install the mail parser: composer require php-mime-mail-parser/php-mime-mail-parser

2. php must have mbstring and mailparser extensions enabled (could be tricky to install, so i followed the tutorial in the guthub link, and worked with php 8.1)
    sudo apt install php-cli php-mailparse


3. run the "php job.php" command from as a cronjob (crontab)

4. mysql configuration is in the job.php file (username, password, db, tables)