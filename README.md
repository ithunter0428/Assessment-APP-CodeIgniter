# Description 
Developed with PHP, Codeigniter and Jquery this app is  designed to reduce cost of assessment (assignment, test and examination) in schools by providing a medium to set question, mark answers, conduct examination and compile results. 

The app features messaging between teachers and students, setting of objective and essay questions, teachers and students course registration, easy marking system, result compilation and result checking.

Technologies used are PHP, Codeigniter, Javascript, Jquery, AJAX, MySql, AdminLte

# App access
The following login can be used to access the app. Note all account password is "password" 


admin@admin.com (Admin User) 

kendan@gmail.com (Student User) 

bami@gmail.com (Teacher User) 

## Demo

http://e-assessment.herokuapp.com/auth/login

# CI-AdminLTE
CodeIgniter 3.1.10 with AdminLTE 2.3.11

## Installation

1. Unzip the package.
2. Upload the `CI-AdminLTE` folders and files to your server. Normally the index.php file will be at your root.
3. Open the `application/config/common/dp_config.php` file with a text editor and set your base URL:
```
// Fill in the file of your project here when you develop locally.
$host_dev = 'CI-AdminLTE';

// Fill in the domain name here when your project is online.
// Example : www.johndoe.com
//           johndoe.com
$host_prod = 'your_domain.tld';
```
4. Create a table named `ci_adminlte` and inject the data from the `install/sql/ci_adminlte.sql` file.
5. Change if necessary the connection information to your database in the `application/config/database.php` file.


## Server Requirements

PHP version 5.6 or newer is recommended.

It should work on 5.4.8 as well, but we strongly advise you NOT to run such old versions of PHP, because of potential security and performance issues, as well as missing features.

## Dependencies
| NAME | VERSION | WEB | REPO |
| :--- | :---: | :---: | :---: |
| CodeIgniter | 3.1.10 | [Website](https://codeigniter.com) | [Github](https://github.com/bcit-ci/CodeIgniter/)
| AdminLTE | 2.3.11 | [Website](https://adminlte.io) | [Github](https://github.com/almasaeed2010/AdminLTE/)
| Bootstrap | 3.3.7 | [Website](https://getbootstrap.com/docs/3.3) | [Github](https://github.com/twbs/bootstrap)
| Ion Auth | 2.6.0 | [Website](http://benedmunds.com/ion_auth) | [Github](https://github.com/benedmunds/CodeIgniter-Ion-Auth)
| jQuery | 2.2.4 | [Website](http://jquery.com) | [Github](https://github.com/jquery/jquery)
| Font Awesome | 4.7.0 | [Website](https://fontawesome.com/v4.7.0) | [Github](https://github.com/FortAwesome/Font-Awesome)
| Mobile Detect | 2.8.30 | [Website](http://mobiledetect.net) | [Github](https://github.com/serbanghita/Mobile-Detect)

## CodeIgniter 3 Documentation

* [User guide](https://codeigniter.com/user_guide)

## Reference

* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [Translations for CodeIgniter System](https://github.com/bcit-ci/codeigniter3-translations)
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE)
