@if(session()->has('popup.message'))
    <script>
        notification(
            "{{ session('popup.title') }}",
            "{{ session('popup.message') }}",
            "{{ session('popup.type') }}",
            "{{ session('popup.icon') }}",
            "{{ session('popup.animate.enter') }}",
            "{{ session('popup.animate.exit') }}",
            "{{ session('popup.delay') }}"
        );
    </script>
@endif