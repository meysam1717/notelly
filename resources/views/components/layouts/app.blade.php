<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Anitec Team' }}</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script>
        let telegram = window.Telegram.WebApp;
        telegram.MainButton.color = "#ff8a65";
        telegram.MainButton.textColor = "#ffffff";
        telegram.BackButton.isVisible = true;
        telegram.BackButton.show();
        telegram.BackButton.onClick(function (event) {
            telegram.MainButton.hide();
            if (window.location.pathname === '/'){
                telegram.close();
            }else{
                history.back();
            }
        })
        // telegram.isClosingConfirmationEnabled = true;
        // telegram.enableClosingConfirmation = true;
    </script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body>

{{ $slot }}


<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('notify', (event) => {
            telegram.showAlert(event.message)
        });
    });
</script>
@stack('js')
@livewireScriptConfig
</body>

</html>