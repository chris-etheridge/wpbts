# WP Blood Clinic application

### Description

This is the application that is being built for Western Province Blood Service, for a Varsity project. This is for learning purposes.

### Setting up

- Install a webserver with PHP and MySQL
  - OSX: [MAMP](https://www.mamp.info)
  - Windows: [WAMP](https://sourceforge.net/projects/wampserver/)
  - Linux: [XAMPP/AMMPS](http://ampps.com/download)
- Run the webserver, and point the `web root` to the `web` folder
- Create a database called `wpbts` 
- Run the `db_complete.sql` in `DB_Scripts` folder on your MySQL instance.
- Change the `API_BASE` string in `res/values/api_urls.xml` file to your host.
  - Make sure the `HOST` is NOT `localhost` or `127.0.0.1`
  - Include the right port (`8888` is default)
- Navigate to `HOST/login.php` to login
- Launch the application from Android studio

### Credits

- [Android Async Http](http://loopj.com/android-async-http/)

### License

Refer to the `LICENSE` file.