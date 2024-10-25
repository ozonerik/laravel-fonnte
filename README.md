<h1>Laravel Fonnte</h1>

![image](https://github.com/user-attachments/assets/9685d2bc-42ae-4df2-8069-84a0b25d5aa3)


<p>Project ini berguna bagi Anda yang ingin menggunakan API WhatsApp Gateway dari <a href="https://md.fonnte.com/new/register.php?ref=137" target="_blank">Fonnte</a></p>

<h2>Fitur</h2>
<ol>
    <li>Send Message</li>
    <li>List All Devices</li>
    <li>Create New Device</li>
    <li>Connect Device via QR Code</li>
    <li>Disconnect Device</li>
    <li>Delete Device</li>
</ol>

<h2>Cara Install</h2>
1. Pastikan sudah memiliki local development server

2. Clone project ini dengan perintah: 
<br>git clone git@github.com:muhazmi/laravel-fonnte.git

3. Sesuaikan value di file .env dari:
<br>DB_CONNECTION
<br>DB_HOST
<br>DB_PORT
<br>DB_DATABASE
<br>DB_USERNAME
<br>DB_PASSWORD

4. Jalankan perintah:
<br>composer install
<br>php artisan key:generate
<br>php artisan migrate --seed
<br>php artisan serve

5. Isi ACCOUNT_TOKEN di file .env yang dapat kamu miliki pada halaman Setting jika sudah registrasi di website Fonnte. Silahkan <a href="https://md.fonnte.com/new/register.php?ref=137" target="_blank">klik disini</a> untuk registrasi sebagai member baru. 

<h2>Dokumentasi Resmi</h2>
Silahkan kunjungi <a href="https://docs.fonnte.com/" target="_blank">disini</a>

<h2>Disclaimer</h2>
<p>Silahkan bagi yang ingin berkontribusi dalam pengembangan project ini karena apa yang ada disini hanya mencakup dasarnya saja.</p>
<p>Semoga bermanfaat!</p>
