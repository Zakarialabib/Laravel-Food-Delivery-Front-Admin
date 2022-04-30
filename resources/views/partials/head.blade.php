@php($logo = \App\Models\BusinessSetting::where(['key' => 'icon'])->first()->value ?? '')
<link rel="shortcut icon" href="">
<link rel="icon" type="image/x-icon" href="{{ asset('storage/app/public/business/' . $logo ?? '') }}">

<link rel="stylesheet" href="{{ asset('public/assets/css/app.css') }}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
<link rel="icon" type="image/png" href="{{ asset('public/assets/images/favicon.png') }}">
<link rel="stylesheet" href="{{ asset('public/assets/css/styles.css') }}">
<!-- fontawesome -->
<link rel="stylesheet" href="{{ asset('public/assets/landing/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/landing/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/admin/css/toastr.css') }}">

@laravelTelInputStyles