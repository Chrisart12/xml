<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

</head>
<body>
    <div id="app">
        <h2 class="text-center text_margin_bottom">LES OFFRES D'EMPLOI SUR MaStory</h2>
        @foreach($jobs as $job)
        <p><img src="{{  $job->logoURL }}" alt=""> </p>
        <p><img src="{{  $job->imageURL }}" alt=""> </p>
        <p><a href="{{  $job->vacancyURL }}">job</a></p>
        <p><a href="{{  $job->ApplicationURLL }}">Application</a></p>
        <p>{{  $job->departementId }}</p>
        <p>{{  $job->categories[0]}}</p>
        @endforeach
       
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
