@extends('layouts.app')

@section('head')
    <style>
        pre {
            height: 100px;
        }
    </style>
@endsection

@section('content')
    <section class="season3-nav main-mb main-top-padder">
        <div class="row">
            <div class="medium-12 medium-centered columns">
                <ul>
                    <li><a class="active">Messages</a></li>
                    <li><a class="">Archived</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="row padbot">
        <div class="large-6 columns large-centered all-conversations">
            @if(count($conversations) > 0)
            <conversations :convos="{{$conversations}}"></conversations>
            @else
                <div class="main-top-padder">
                    <div class="empty-state">
                        No messages
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection