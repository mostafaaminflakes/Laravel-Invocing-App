<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{(App::isLocale('en') ? 'ltr' : 'rtl')}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:300,800" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Tajawal:300,800" rel="stylesheet">

    <!-- Styles -->
</head>

<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div><strong>{{ __('INVOICE DETAILS') }}</strong>
                            <div>EFC00{{ $invoice->invoice_number }}</div>
                            <div>EFC00{{ $invoice_items }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>