@extends('layouts.app')

@section('head')
    <script src="/js/moment.js"></script>
    <script src="/js/moment-timezones.js"></script>
@endsection

@section('content')
    <section class="row main-top-padder padbot">
        <div class="small-12 columns">
            <div class="panel" style="min-height: 80vh">
                <schedule :games="{{ $games }}"></schedule>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
{{--<script src="https://unpkg.com/vue/dist/vue.js"></script>--}}
{{--<script>--}}
    {{--var app = new Vue({--}}
        {{--el: '#app',--}}

    {{--})--}}
{{--</script>--}}
<script>
    $(function() {
        $('.tzdisplay').click(function(e) {
            e.preventDefault();
            $('.timezone-select').css('display', 'inline-block');
            $('.timezone-select-hide').css('display', 'inline-block');
        })

        $('.timezone-select-hide').click(function(e) {
            e.preventDefault();
            $(this).hide();
            $('.timezone-select').hide();
        })
    })
</script>
@endsection