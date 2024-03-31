<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Esmart-Crm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="shortcut icon" href="{{asset('Asset/assets/images/favicon.ico')}}">

    <!-- third party css -->
    <link href="{{asset('Asset/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Asset/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Asset/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Asset/assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('Asset/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- icons -->
    <link href="{{asset('Asset/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
{{--    Full Calendar --}}
    <link href="{{asset('Asset/assets/libs/fullcalendar/main.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('Asset/css/timeline.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('Asset/css/myStyle.css')}}" type="text/css" rel="stylesheet">

    <link href="{{asset('Asset/assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('Asset/assets/libs/dropify/css/dropify.min.css')}}" rel="stylesheet" type="text/css">

    <style>
        /* For Chrome, Edge, and Safari */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #999;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-track {
            background-color: #eee;
            border-radius: 5px;
        }

        /* For Firefox */
        ::-moz-scrollbar {
            width: 10px;
        }

        ::-moz-scrollbar-thumb {
            background-color: #999;
            border-radius: 5px;
        }

        ::-moz-scrollbar-track {
            background-color: #eee;
            border-radius: 5px;
        }

        /* For all browsers (fallback) */
        div {
            scrollbar-width: thin;
            scrollbar-color: #999 #eee;
        }
    </style>

</head>

<!-- body start -->
<body class="loading" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

