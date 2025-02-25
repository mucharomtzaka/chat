=============
Chat System
=============

Sistem chat berbasis PHP dengan dukungan PHP 7.4.

Persiapan
---------
1. **Clone Repository**
   ```sh
   git clone https://github.com/mucharomtzaka/chat.git
   cd chat
   ```

2. **Buat Database**
   - Buat database baru dengan nama `chat` di phpMyAdmin.
   - Atur konfigurasi database di file `config/database.php`.
   - Import file SQL `db.sql` ke database `chat`.

3. **Konfigurasi Database**
   ```php
   $db['default'] = array(
       'dsn'      => '',
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'chat',
       'dbdriver' => 'mysqli',
       'dbprefix' => '',
       'pconnect' => FALSE,
       'db_debug' => (ENVIRONMENT !== 'production'),
       'cache_on' => FALSE,
       'cachedir' => '',
       'char_set' => 'utf8',
       'dbcollat' => 'utf8_general_ci',
       'swap_pre' => '',
       'encrypt'  => FALSE,
       'compress' => FALSE,
       'stricton' => FALSE,
       'failover' => array(),
       'save_queries' => TRUE
   );
   ```

4. **Konfigurasi Pusher**
   Sesuaikan konfigurasi Pusher di file `config/config.php`.
   ```php
   $config['pusher'] = [
       'app_id'  => 'xxxxx',
       'key'     => 'xxx',
       'secret'  => 'xxxx',
       'cluster' => 'xxxx',
       'useTLS'  => true
   ];
   ```

5. **Atur Base URL**
   - Sesuaikan `base_url` di `config/config.php` dengan nama folder proyek.
   ```php
   $config['base_url'] = 'http://localhost/chat/';
   ```

6. **Jalankan Composer Update**
   ```sh
   composer update
   ```

Akun Default
------------
- **User**
  - Email: `mucharomtzaka@gmail.com`
  - Password: `12345678`

- **Admin**
  - Email: `admin@test.com`
  - Password: `12345678`

Konfigurasi .htaccess
---------------------
Untuk menghilangkan `index.php` dari URL, gunakan konfigurasi berikut:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

