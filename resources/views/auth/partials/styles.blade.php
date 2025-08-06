@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp

<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon"
    href="{{ isset($systemSetting->favicon) && !empty($systemSetting->favicon) ? asset($systemSetting->favicon) : asset('frontend/eVento_Favicon.png') }}" />

<!-- BOOTSTRAP CSS -->
<link id="style" href="{{ asset('backend') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

<!-- STYLE CSS -->
<link href="{{ asset('backend') }}/css/style.css" rel="stylesheet" />
<link href="{{ asset('backend') }}/css/skin-modes.css" rel="stylesheet" />



<!--- FONT-ICONS CSS -->
<link href="{{ asset('backend') }}/plugins/icons/icons.css" rel="stylesheet" />

<!-- INTERNAL Switcher css -->
<link href="{{ asset('backend') }}/switcher/css/switcher.css" rel="stylesheet">
<link href="{{ asset('backend') }}/switcher/demo.css" rel="stylesheet">
