@extends('layouts.app')

@section('head')
    <style>
        .player-message-brief {
            margin-top: 0;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
        }
        .first {
            margin-top: 2rem;
        }
        .player-avatar {
            width: 50px;
            height: 50px;
            border-radius: 100%;
            display: inline;
            margin-right: 12px;
            flex: 0;
        }
        .player-message {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            flex-direction: column;
            flex: 5;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .player-message .previewline {
            color: #949aa6;
            font-size: 15px;
            margin: 0;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 100%;
        }
        .player-message strong {
            display: block;
            padding-top: 5px;
            line-height: 14px;
        }
        .message-timestamp {
            flex: 1;
            padding-left: 1rem;
        }
        .message-timestamp p {
            color: #949aa6;
            font-size: 15px;
            margin: 0;
        }



        .conversation {
            /*margin-top: 2rem;*/
            display: flex;
            margin-bottom: 10px;
        }
        .speaker-avatar {
            width: 65px;
            height: 65px;
            border-radius: 100%;
            display: inline;
            margin-right: 12px;
            flex: 0;
        }
        .message {
            margin: 0 0 0 1.25rem;
            flex: 5;
            position: relative;
            background: #ebedf2;
            padding: 1rem;
            font-size: 17px;
            line-height: 25px;
            border-radius: 3px;
            min-height: 100px;
            display: flex;
            flex-direction: column;
        }
        .message-white {
            background: #fff;
        }
        .message p {
            margin: 0;
        }
        .message .message-body {
            flex: 5;
            margin-bottom: 1.25rem;
        }
        .message::after {
            content: " ";
            position: absolute;
            display: block;
            top: 50px;
            left: -22px;
            height: 0;
            width: 0;
            border-top: 22px solid #ebedf2;
            border-left: 22px solid transparent;
        }
        .message-white::after {
            content: " ";
            position: absolute;
            display: block;
            top: 50px;
            left: -22px;
            height: 0;
            width: 0;
            border-top: 22px solid #fff;
            border-left: 22px solid transparent;
        }
        .message .timestamp {
            font-size: 13px;
            color: #aeb4bf;
            flex: 1
        }
        .cooldividier {
            display: inline-block;
            margin: 0 5px 2px;
            width: 4px;
            height: 4px;
            background: #aeb4bf;
            border-radius: 100%;
        }

        .newmessage {
            resize: none;
            padding: 9px;
            padding-right: 16px;
            background: #FFF;
            border: 1px solid #ccd0d9;
            color: #2a2f35;
            margin: 0 10px 10px 0;
            border-radius: 3px;
            font-size: 15px;
            line-height: 22px;
            min-height: 100px;
            max-height: 400px;
            box-shadow: none !important;
            -webkit-transition: border-color 75ms ease-in;
            -moz-transition: border-color 75ms ease-in;
            transition: border-color 75ms ease-in;
        }

        .message-input {
            display: block;
        }

        .sendbutton {
            min-width: 120px;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-4 columns">
            <div class="panel player-message-brief first">
                <img class="player-avatar" src="/images/logocircle.jpg" />
                <div class="player-message">
                    <strong>Wearwolf</strong>
                    <p class="previewline">Hey when are you planning to add all those new features we talked about</p>
                </div>
                <div class="message-timestamp">
                    <p>Mar 7</p>
                </div>
            </div>
            <div class="panel player-message-brief">
                <img class="player-avatar" src="/images/logocircle.jpg" />
                <div class="player-message">
                    <strong>Wearwolf</strong>
                    <p class="previewline">Hi</p>
                </div>
                <div class="message-timestamp">
                    <p>Mar 7</p>
                </div>
            </div>
        </div>
        <div class="medium-8 columns">
            <div class="conversations">
                <div class="conversation first">
                    <img class="speaker-avatar" src="/images/logocircle.jpg" />
                    <div class="message message-white">
                        <p class="message-body">This is some text right here yo</p>
                        <p class="timestamp">Sent Mar 7<span class="cooldividier"></span>10:24 pm</p>
                    </div>
                </div>
                <div class="conversation">
                    <img class="speaker-avatar" src="/images/logocircle.jpg" />
                    <div class="message">
                        <p class="message-body">Hey, welcome to Carbon X! If you have any questions or need help with anything, please join us on Discord using the link in the footer.</p>
                        <p class="timestamp">Sent Mar 7<span class="cooldividier"></span>10:24 pm</p>
                    </div>
                </div>
                <div class="conversation">
                    <img class="speaker-avatar" src="/images/logocircle.jpg" />
                    <div class="message">
                        <p class="message-body">Hey, welcome to Carbon X! If you have any questions or need help with anything, please join us on Discord using the link in the footer. I wrote an even longer sentence just to see what it would look like, really.</p>
                        <p class="timestamp">Sent Mar 7<span class="cooldividier"></span>10:24 pm</p>
                    </div>
                </div>
                <div class="conversation">
                    <img class="speaker-avatar" src="/images/logocircle.jpg" />
                    <div class="message message-input">
                        <textarea placeholder="Type your message here" class="newmessage" maxlength="180"></textarea>
                        <a href="#" class="button sendbutton">Send</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection