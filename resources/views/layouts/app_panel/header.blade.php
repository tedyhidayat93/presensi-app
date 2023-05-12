<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/css/style.css">
  <link rel="stylesheet" href="{{asset('admin_template/dist')}}/assets/css/components.css">

    @stack('styles')

<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">