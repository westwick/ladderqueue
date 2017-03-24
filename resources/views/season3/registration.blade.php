@extends('layouts.app')

@section('head')
    <style>
        section.form-section {
            margin-bottom: 1.25rem;
        }

        .form-section-title {
            font-size: 17px;
        }
        .form-section-note {
            font-size: 14px;
            margin-bottom: 0.5rem;
        }
        .schedule-times {
            padding: 0 1rem;
        }
        .time-select {
            margin-right: 0.75rem;
        }
        .season3-registration .form-error {
            display: block;
        }
    </style>
@endsection

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-6 medium-centered">
            <div class="panel season3-registration">
                <h2 class="text-center">Carbon X Season 3 Registration</h2>
                <div class="callout">
                    <p>Before continuing, please be sure you have read and are familiar with the <a href="#">Season 3 Rules</a> as well as the CarbonX <a href="#">Player Code of Conduct</a>.</p>
                </div>
                <p>You are registering your team: <strong style="font-size: 1.25rem">{{Auth::user()->team->name}}</strong></p>
                <form method="post" action="/season3/register" id="season3form">
                    {{ csrf_field() }}
                    <season3reg></season3reg>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/svgcheckbx.js"></script>
@endsection