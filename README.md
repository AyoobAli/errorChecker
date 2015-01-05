errorChecker
============

errorChecker is written in PHP, its a command line script that can run in both Linux and Windows. it will go though your web application files and visit all the pages and search for the error messages, and if there was any error it will give back the URL of that file.



###How to use:
```
php errorChecker.php "/var/www/WebAppToCheck" "http://127.0.0.1/WebAppToCheck"
```
This will check your web application for four types of errors (Fatal error, Parse error, Warning, and Notice).


If you want to check your application for any custom error or text, you can do so as following:
```
php errorChecker.php "/var/www/WebAppToCheck" "http://127.0.0.1/WebAppToCheck" "SQL syntax" "Fatal error"
```
This will check your application for the words "**sql syntax**" or "**fatal error**".

The first argument "/var/www/WebAppToCheck" is the location of the script in your system.
And the second argument "http://127.0.0.1/WebAppToCheck" is the URL of the script in your local or production system.


*NOTE:* DON'T place the tool in the same directory of your web application, it will cause an endless loop.

![ScreenShot](http://www.ayoobali.com/wp-content/uploads/2015/01/err01.png)

![ScreenShot](http://www.ayoobali.com/wp-content/uploads/2015/01/err02.png)

