## Description

A Laravel application to generate customer invoices with QR Codes required for the e-invoicing standard by [ZATCA](https://zatca.gov.sa/en/E-Invoicing/Pages/default.aspx) in Saudi Arabia.
You can use it as a ready-made module in your projects to support invoices with ZATCA compliant QR codes.

## Features

-   Create/Edit/Search/Export/Delete invoices.
-   PDF support.
-   QR code support.
-   Application Settings [Account, VAT amount, search locations, and QR code data].

## Usage

Note: Create an empty database first. Then use its credentials in the .env file.

To get started, this is all you need to do:

```bash
$ git clone https://github.com/mostafaaminflakes/Laravel-Invocing-App.git
$ cd Laravel-Invocing-App
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

## Further Notes - DevOps

This application is:

-   Developed using [Laravel](https://laravel.com/).
-   Using [GitHub](https://github.com/) as a repository.
-   Using [Forge](https://forge.laravel.com/) for deployment.
-   Published to a [DigitalOcean](https://www.digitalocean.com/) droplet.
