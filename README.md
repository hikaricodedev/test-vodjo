Cara running project test :
Pastikan terinstall di device yang akan digunakan untuk menguji:
- XAMPP / php 8.2^ + apache
- NodeJS
- MySQL
- Composer

1. Clone Repository ini ke device yang akan digunakan
2. buka terminal lalu arahkan ke folder project yang sudah di clone
3. run command : composer install
4. run command : npm install
5. copy .env.example ke .env
6. ubah settingan database sesuai konfigurasi pada deivce yang digunakan, dan jangan lupa ubah driver sqlite ke mysql
7. run command : php artisan key:generate
8. run command : php artisan config:cache
9. run command : php artisan migrate
10. run command : php artisan db:seed --class=DummyUserSeeder
11. lalu buka 2 terminal/command prompt lalu arahkan ke folder project test
12. di terminal pertama lakukan run command: php artisan serve
13. di terminal kedua lakukan run command : npm run dev
14. lalu buka di browser address http://localhost:8000
15. untuk user dummy yaitu:
email :admin@mail.com
password : Admin123
