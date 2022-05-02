<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gambling Invitation</title>

        <link rel="shortcut icon" href="{{ asset('GamblingIco.ico') }}" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">Gambling Group</a>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <!-- Page heading-->
                            <h1 class="mb-5">Discover the affiliates closest to you!</h1>
                            <form class="form-subscribe" method="POST" id="contactForm" action="{{ route('discoverAffiliates') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control form-control-lg" id="affiliates" type="file" name="file" placeholder="Affiliates file"/>
                                        @error('file')
                                            <div class="alert-danger">{{$errors->first('file') }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-auto"><button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button></div>
                                </div>
                                <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="features-icons bg-light text-center" id="affiliates">
            <div class="container">
                <div class="row">
                    @if(isset($validAffiliates) && is_array($validAffiliates))
                        @forelse($validAffiliates as $affiliate)
                            <div class="col-lg-3">
                                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                                    <div class="features-icons-icon d-flex"><i class="bi-building m-auto text-primary"></i></div>
                                    <h3><span class="text-sm text-secondary">{{$affiliate->getAffiliateId()}}: </span>{{$affiliate->getName()}}</h3>
                                    <p class="lead mb-0">Just {{$affiliate->getDistanceFromOffice()}}kms away from your office!</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-12">
                                <div class="alert alert-secondary">
                                   No affiliates near your office :(
                                </div>
                            </div>
                        @endforelse
                        <script type="text">
                        window.onload = function() {
                            window.location.href = "#affiliates";
                        };
                        </script>
                    @endif
                </div>
            </div>
        </section>
    </body>
</html>
