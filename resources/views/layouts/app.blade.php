<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="description"
              content="Vous avez perdu un animal ? Signalez-le nous via ce formulaire">
        <meta name="keywords"
              content="animal, animal perdu, déclaration">
        <meta name="author"
              content="Dominique Vilain">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible"
              content="ie=edge">
        <title>{!! $title !!}</title>
        <link rel="apple-touch-icon"
              sizes="180x180"
              href="/apple-touch-icon.png">
        <link rel="icon"
              type="image/png"
              sizes="32x32"
              href="/favicon-32x32.png">
        <link rel="icon"
              type="image/png"
              sizes="16x16"
              href="/favicon-16x16.png">
        <link rel="manifest"
              href="/site.webmanifest">
        <link rel="stylesheet"
              href="/css/main.css">
    </head>
    <body>
        @component('layouts.navigation')
        @endcomponent
        {!! $slot !!}
    </body>
</html>
