A Laravel application to generate QR Codes required for e-invoicing standard by [ZATCA](https://zatca.gov.sa/en/E-Invoicing/Pages/default.aspx) in Saudi Arabia.
You can use it as a ready-made code template for your projects to support ZATCA QR codes.

This application is built using the following libraries:

-   [Salla ZATCA](https://github.com/SallaApp/ZATCA) implementation.
-   [Chillerlan](https://github.com/chillerlan/php-qrcode) QR Code library
-   Barryvdh [DOMPDF Wrapper](https://github.com/barryvdh/laravel-dompdf) for Laravel.

## Features

-   Download QR code image directly.
-   Save QR code image to server.
-   Generate PDF with QR code image.
-   Add an image in the center of the QR code image.

## Usage

To get started, this is all you need to do:

Note: Create an empty database first. Then use its name in the .env file.

```bash
$ git clone https://github.com/mostafaaminflakes/Invoice-Test.git
$ cd Invoice-Test
$ composer install
$ npm install
$ npm run dev
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate 
$ php artisan serve
```

## Reading the QR Code information

You can read the QR Code information using [E-Invoice QR Reader KSA](https://play.google.com/store/apps/details?id=com.posbankbh.einvoiceqrreader). It's designed to display the QR Code contents of any E-Invoice that is compliant with the Zakat and Tax Authority in Saudi Arabia.
