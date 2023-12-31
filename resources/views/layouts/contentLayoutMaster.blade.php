@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
    lang="@if (session()->has('locale')) {{ session()->get('locale') }}@else{{ $configData['defaultLanguage'] }} @endif"
    data-textdirection="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    @if ($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ $brand }} admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, {{ $brand }} admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>@yield('title') | {{ $brand }}</title>
    <link rel="apple-touch-icon" href="{{ asset(mix('images/logo.jpg')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(mix('images/logo.jpg')) }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    {{-- Include core + vendor Styles --}}
    @include('panels.styles')

</head>
<!-- END: Head-->

@auth('admin')
    @php
        $model = 'Admin';
        $route = 'admins';
        $guard = 'admin';
    @endphp
@endauth
@auth('editor')
    @php
        $model = 'Editor';
        $route = 'editors';
        $guard = 'editor';
    @endphp
@endauth

<!-- BEGIN: Body-->
@isset($configData['mainLayoutType'])
    @extends($configData['mainLayoutType'] === 'horizontal' ? 'layouts.horizontalLayoutMaster' : 'layouts.verticalLayoutMaster')
@endisset
