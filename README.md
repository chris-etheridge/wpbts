# WP Blood Clinic application

### Description

This is the application that is being built for Western Province Blood Service, for a Varsity project. This is for learning purposes.

### Setting up

- Run a webserver, and point it to the WEB file
  - Webserver must have PHP and MySQL
- Create a database called `wpbts` 
- Run the `db_complete.sql` in `DB_Scripts` folder on your MySQL instance.
- Run your web server
- Change the `INTERNAL_HOST_URL` string in `com.peachtree.wpbapp.Core.Networking` class to your host.
  - Make sure the `HOST` is NOT `localhost` or `127.0.0.1`
  - Include the right port (`888` is default)
- Navigate to `HOST/login.php` to login
- Launch the application from Android studio

### Credits

- [Android Async Http](http://loopj.com/android-async-http/)

### License

Refer to the `LICENSE` file.