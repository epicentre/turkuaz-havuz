# Turkuaz Havuz

Turkuaz havuz için yapılmış basit giriş-çıkış kontrol uygulaması. Projede laravel 7 + Vue 2 kullanıldı.

Vue'ye hızlı giriş yapmak için aşağıdaki repo dan yararlanıldı.
https://github.com/cretueusebiu/laravel-vue-spa

## Installation

- git clone https://github.com/epicentre/turkuaz-havuz.git
- composer install
- Copy `.env.example` to `.env` and set your database connection details
- run `php artisan key:generate` and `php artisan jwt:secret`
- `php artisan migrate --seed`

## Development

- `npm install`
- `npm run watch` komutu ile resources/js klasöründe yaptığınız değişiklikler anlık olarak build edilir.
- `npm run prod` komutu ile production dosyaları oluşturulur.

Postman collection file <b>Turkuaz.postman_collection.json </b>
