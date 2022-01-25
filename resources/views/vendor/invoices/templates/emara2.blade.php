<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $invoice->name }}</title>
    <style type="text/css">
        /* Main Body */
        @page {
            margin-top: 1cm;
            margin-bottom: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        body {
            direction: rtl;
            background: #fff;
            color: #000;
            margin: 0cm;
            /* font-family: sans-serif; */
            font-family: "tajawal";
            font-size: 11pt;
            line-height: 100%;
            /* fixes inherit dompdf bug */
        }

        h1,
        h2,
        h3,
        h4 {
            font-weight: bold;
            margin: 0;
        }

        h1 {
            font-size: 16pt;
            margin: 5mm 0;
        }

        h2 {
            font-size: 14pt;
        }

        h3,
        h4 {
            font-size: 11pt;
        }

        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        li,
        ul {
            margin-bottom: 0.75em;
        }

        p {
            margin: 0;
            padding: 0;
        }

        p+p {
            margin-top: 1.25em;
        }

        a {
            border-bottom: 1px solid;
            text-decoration: none;
        }

        /* Basic Table Styling */
        table {
            border-collapse: collapse;
            border-spacing: 0;
            page-break-inside: always;
            border: 0;
            margin: 0;
            padding: 0;
        }

        th,
        td {
            vertical-align: top;
            text-align: right;
        }

        table.container {
            width: 100%;
            border: 0;
        }

        tr.no-borders,
        td.no-borders {
            border: 0 !important;
            border-top: 0 !important;
            border-bottom: 0 !important;
            padding: 0 !important;
            width: auto;
        }

        /* Header */
        table.head {
            margin-bottom: 12mm;
        }

        td.header img {
            /* img width & heights can only be set with inline styles (mpdf 8.0) https://github.com/mpdf/mpdf/issues/366 */
            /* using wpo_wcpdf_header_logo_img_element filter instead in wcpdf-mpdf.php */
        }

        td.header {
            font-size: 16pt;
            font-weight: 700;
        }

        td.shop-info {
            width: 40%;
        }

        .document-type-label {
            text-transform: uppercase;
        }

        /* Recipient addressses & order data */
        table.order-data-addresses {
            width: 100%;
            margin-bottom: 10mm;
        }

        td.order-data {
            width: 40%;
        }

        .invoice .shipping-address {
            width: 30%;
        }

        .packing-slip .billing-address {
            width: 30%;
        }

        td.order-data table th {
            font-weight: normal;
            padding-right: 2mm;
        }

        /* Order details */
        table.notes-totals,
        table.order-details {
            width: 100%;
            margin-bottom: 8mm;
        }

        .quantity,
        .price {
            width: 20%;
        }

        .order-details tr,
        .notes-totals tr {
            page-break-inside: always;
            page-break-after: auto;
        }

        .notes-totals td,
        .notes-totals th,
        .order-details td,
        .order-details th {
            border-bottom: 1px #ccc solid;
            border-top: 1px #ccc solid;
            padding: 0.375em;
        }

        .notes-totals th,
        .order-details th {
            font-weight: bold;
            text-align: right;
        }

        .order-details thead th {
            color: white;
            background-color: black;
            border-color: black;
        }

        /* product bundles compatibility */
        .order-details tr.bundled-item td.product {
            padding-left: 5mm;
        }

        .order-details tr.product-bundle td,
        .order-details tr.bundled-item td {
            border: 0;
        }

        .order-details tr.bundled-item.hidden {
            display: none;
        }

        /* item meta formatting for WC2.6 and older */
        dl {
            margin: 4px 0;
        }

        dt,
        dd,
        dd p {
            display: inline;
            font-size: 7pt;
            line-height: 7pt;
        }

        dd {
            margin-left: 5px;
        }

        dd:after {
            content: "\A";
            white-space: pre;
        }

        /* item-meta formatting for WC3.0+ */
        .wc-item-meta,
        ul.meta {
            margin: 4px 0;
            font-size: 8pt;
            line-height: 8pt;
        }

        .wc-item-meta p,
        ul.meta p {
            display: inline;
        }

        .wc-item-meta li,
        ul.meta li {
            margin: 0;
            margin-right: 5px;
            font-size: 20pt;
            line-height: 50px;
        }

        /* Notes & Totals */
        .customer-notes {
            margin-top: 5mm;
        }

        table.totals {
            width: 100%;
        }

        table.totals th,
        table.totals td {
            border: 0;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        table.totals th.description,
        table.totals td.price {
            width: 50%;
        }

        table.totals tr.order_total td,
        table.totals tr.order_total th {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            font-weight: bold;
        }

        table.totals tr.payment_method {
            display: none;
        }

        /* Footer Imprint */
        #footer {
            position: absolute;
            bottom: 0;
            left: 2cm;
            right: 2cm;
            height: 2cm;
            /* if you change the footer height, don't forget to change the bottom (=negative height) and the @page margin-bottom as well! */
            text-align: center;
            border-top: 0.1mm solid gray;
            margin-bottom: 0;
            padding-top: 2mm;
        }

        /* page numbers */
        .pagenum:before {
            content: counter(page);
        }

        .pagenum,
        .pagecount {
            font-family: sans-serif;
        }

        /* Mostafa */
        .css-address {
            font-size: 9pt;
        }

        #footer {
            line-height: 1.5em;
        }

        td.shop-info {
            line-height: 1.3em;
        }

        div#aaa {
            border: 0px solid red;
            padding: 10px;
            margin: 10px;
        }

        #meta1234>li,
        #meta1234 li,
        #meta1234 * li {
            border: 0px solid red !important;
            padding: 10px !important;
            display: block !important;
            overflow: visible !important;
        }
    </style>
</head>

<body>
    <table class="head container">
        <tr>
            <td class="header">
                {{-- Header --}}
                @if($invoice->logo)
                <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
                @endif
            </td>
            <td class="shop-info">
                <div class="shop-name">
                    <h3>مؤسسة المقاولات</h3>
                </div>
                <div class="shop-address css-address">jjj</div>
            </td>
        </tr>
    </table>

    <h1 class="document-type-label">
        <?php echo "فاتورة ضريبية"; ?>
    </h1>


    <table class="order-data-addresses">
        <tr>
            <td class="address billing-address">
                333
                <div class="billing-email">333</div>
                <div class="billing-phone">333</div>
            </td>
            <td class="address shipping-address">
                <h3>333</h3>
                333
            </td>
            <td class="order-data">
                <table>
                    <tr class="invoice-number">
                        <th><?php echo 'رقم الفاتورة: ' ?></th>
                        <td>222</td>
                    </tr>
                    <tr class="invoice-date">
                        <th><?php echo 'تاريخ الفاتورة: '; ?></th>
                        <td>222</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table class="order-details">
        <thead>
            <tr>
                <th class="product" colspan="2"><?php echo 'المنتج'; ?></th>
                <th class="quantity"><?php echo 'الكمية'; ?></th>
                <th class="price"><?php echo 'سعر القطعة'; ?></th>
            </tr>
        </thead>
        <tbody>
            <tr class="<?php echo '1'; ?>">
                <td class="product" style="border-bottom: 1px solid #ccc; width: 65px;">
                    <span><?php echo '1'; ?></span>
                </td>
                <td style="border-bottom: 1px solid #ccc;">
                    <div class="item-name" id="aaa"><?php echo '1'; ?></div>
                    <ul class="meta" id="meta1234" style="direction: rtl; float: right;">
                    </ul>
                    <div class="item-meta"><?php echo '1'; ?>
                    </div>
                </td>
                <td class="quantity" style="border-bottom: 1px solid #ccc;"><?php echo '1'; ?></td>
                <td class="price" style="border-bottom: 1px solid #ccc;"><?php echo '1'; ?></td>
            </tr>

        </tbody>
    </table>

    <table class="notes-totals" style="width:100%">
        <tbody>
            <tr class="no-borders">
                <td class="no-borders" style="width:60%">
                    <div class="document-notes">
                        <h3><?php echo 'ملاحظات'; ?></h3>
                        222
                    </div>
                    <br>
                    <div class="customer-notes">
                        <h3><?php echo 'ملاحظات العميل'; ?></h3>
                        111
                    </div>
                </td>
                <td class="no-borders totals-cell" style="width:40%">
                    <table class="totals">
                        <tfoot>
                            <tr>
                                <th class="description">q</th>
                                <td class="price"><span class="totals-price">q</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>