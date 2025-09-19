<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Melawai Hotel' }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    <livewire:front.header />
    <livewire:front.hero />
    <livewire:front.main />
    <livewire:front.mains />
    <livewire:front.footer />
</body>

</html>
