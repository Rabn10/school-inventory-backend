<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            line-height: 24px;
            font-size: 12px;
        }

        body {
            font-family: 'Poppins';
            font-style: normal;
            background-color: #E5E5E5;
        }

        /*the outermost container*/
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 4%;
            background-color: #ffffff;
            border: 1px solid #E5E5E5;
        }

        /*grid containers for header, content and footer*/
        .header-grid {
            display: flex;
        }

        .content-grid {
            display: grid;
            align-items: center;
            grid-template-columns: auto;
        }

        .footer-flex {
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .footer-grid {
            display: grid;
            align-items: center;
            justify-content: center;
        }

        .footer-grid > div {
            display: flex;
        }

        .footer-grid > div > img {
            width: 40px;
            height: 40px;
        }

        /*text colors for the email layout*/
        .primaryTextColor {
            color: #000000;
        }

        .secondaryTextColor {
            color: #4E4B66;
        }

        .lightGrayTextColor {
            color: #6E7191;
        }

        .lightTextColor {
            color: #fcfcfc !important;
        }

        /*text related properties the entire layout*/
        .headerText {
            margin: auto auto auto 4% !important;
            font-weight: 500;
            margin: auto 0;
            font-size: 16px !important;
        }

        .hello {
            font-weight: 600;
            font-size: 14px !important;
        }

        .contentText {
            font-weight: 500;
            line-height: 18px !important;
        }

        .footerText {
            margin: auto auto auto 4% !important;
            font-weight: 400;
            margin: auto 0;
            font-size: 10px !important;
        }

        .capitalize {
            text-transform: capitalize;
        }

        /*anchor tag color*/
        a {
            color: #002D72;
        }

        /*image tag*/
        img {
            width: 80px;
            height: 80px;
            background-position: center;
            background-repeat: no-repeat;
            height: 80px;
            filter: drop-shadow(0px 4px 30px rgba(0, 0, 0, 0.12));
            border-radius: 50%;
        }

        /*spacing for the entire layout*/
        .mt-1 {
            margin-top: 10px;
        }

        .mt-2 {
            margin-top: 20px;
        }

        .mt-3 {
            margin-top: 30px;
        }

        .mt-4 {
            margin-top: 40px;
        }

        .ml-1 {
            margin-left: 12px;
        }

        /*button*/
        .btn {
            text-decoration: none;
            text-align: center;
            color: #fcfcfc !important;
            width: 11rem;
            text-transform: uppercase;
            background-color: #002D72;
            padding: 10px;
        }

        /*media query for mobile*/
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
            }
        }
    </style>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
<div id="app">
    <div class="container">
        @yield('header')

        @yield('content')

        <hr class="mt-2"/>

        <div class="footer-grid mt-2">
            @yield('footer')
        </div>
    </div>
</div>
</body>
</html>
