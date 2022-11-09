# is212lms - Software Project Management
## G3 - Team 4

## Steps
- Clone Repo into preferred PHP localhost folder
- Ensure `classConnectionManager.php` server connection settings are accurate, depending on OS
- Ensure server is running (WAMP/MAMP/XAMMP) or prefered PHP server
- Run code from the following file in phpmyadmin or sqlworkbench for database creation
> createLJPS.sql
- Visit site

### Note
Please use the following test emails to test the different roles
- Staff: Susan.Goh@allinone.com.sg
- Manager: Derek.Tan@allinone.com.sg
- HR/ADMIN: john.sim@allinone.com.sg

## Stack
- Vue3
- PHP 8 and above
- MySql
- Codeception (PHP Test)

## Packages Used (Via CDN)
- Vue3
- Axios
- JQuery
- DataTable
- SweetAlert

## Testing Instructions
1. Ensure composer is installed in machine `https://getcomposer.org/`
2. Open Terminal or CMD and navigate to project root folder
3. Install Codeception (PHP Test Package), type the following code in terminal or CMD
> composer require "codeception/codeception" --dev
4. Open `codeception.yml` file and ensure server settings are accurate, depending on OS
5. Ensure server is running (WAMP/MAMP/XAMMP) or prefered PHP server
6. In terminal, run command to start testing
- Mac `vendor/bin/codecept run unit`
- Windows `vendor\bin\codecept run unit`

## Figma Design
> https://www.figma.com/file/FGADwf4Naj4dYSpPi83lE2/LMS-Mockup?node-id=0%3A1 

## Team Members
- daniel.chng.2020@scis.smu.edu.sg
- eunjin.kim.2020@scis.smu.edu.sg
- leon.tan.2020@scis.smu.edu.sg
- xinyee.how.2020@scis.smu.edu.sg
- yongquan.ho.2020@scis.smu.edu.sg
- yuejun.ang.2020@scis.smu.edu.sg
