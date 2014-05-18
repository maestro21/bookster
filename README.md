Bookster
========

Bookster - social network for student focused on study. http://bookster.com.ua. Originally started development in 2011, it was first created on basics of Maestro Engine v1 and was later derived into huge social network for Ukrainian students. Unlike Facebook, it is focused on study rather than socialization and contains summaries, subject, lectures, books for universities allowing students to use it in education purposes. Currently there are more than 1300 registered users, few thousands unique visitors per day and position in Alexa rankings within 200k.

This is fully functional development repository featuring all working live modules, social network login, registration, chat, profile settings, lectures, seminars, etc. all necessary structure. To use it, you should download it and execute database schema db/schema.sql. While live database weights more than 150mb, only database structure presents in repository. After executing database schema you should adjust your database and website settings in sqlconf.php in root directory. After that you can launch your website and login using 'admin' login and password and enjoy it's functionality.

Please note, that it is development repository and some modules may be under construction. Currently, it's books.

Differences from Maestro Engine v1
----------------
Although it was derived from Maestro Engine v1, it consists some significan architectural changes:
* There are no CRUD methods for Masterclass. Masterclass only handles global PHP variables and controller functionality like transfering data and parsing result.
* There is no option to create and edit modules 'on a fly' through web interface to prevent unwanted risks when collaborating with junior developers.
* Better file structure:
  1. All 'public' things other developers may need now present in www folder while engine core stays in root. It is done for security purpose so that if you want some junior developer not to break your application, you can give access only to www folder. It also prevents access to 'up' folder where content like photos is stored.
  2. All external things are now under 'external' folder. There are: ckeditor(instead of edit_area), tagit for tags, pdfjs for PDF to html book conversion, plupload for huge file upload
* Templates now have extension .tpl.php instead of .html
* It is now easier to update database structure in ZF2 way. You don't need to do it manually in your database, you just write your delta in 'db/update.php' and launch this file.
