<div class="row">
    <div class="medium-8 columns">
        <div class="row">
            <div class="medium-3 columns">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/get-involved">Get Involved</a></li>
                    <li><a href="/announcements">Announcements</a></li>
                    <li><a href="/code-of-conduct">Code of Conduct</a></li>
                    <li><a href="/season3/rules">Season 3 Rules</a></li>
                    <li><a href="https://bitbucket.org/awestwick/cxleague/issues" target="_blank">Report a Bug</a></li>
                </ul>
            </div>
            <div class="medium-3 columns">
                <h4>Get In Touch</h4>
                <ul>
                    <li><a href="https://www.twitch.tv/carbonx_tv" target="_blank"><i class="icon ion-social-twitch"></i> Twitch</a></li>
                    <li><a href="https://twitter.com/carbonx_league" target="_blank"><i class="icon ion-social-twitter"></i> Twitter</a></li>
                    {{--<li><a href="#"><i class="icon ion-social-facebook"></i> Facebook</a></a></li>--}}
                    <li><a href="https://www.youtube.com/channel/UCzjlYNiChADil0IPfRwaUWA" target="_blank"><i class="icon ion-social-youtube"></i> Youtube</a></li>
                    <li><a href="https://discord.gg/fshER5N" target="_blank"><i class="icon ion-ios-telephone"></i> Discord</a></li>
                </ul>
            </div>
            <div class="medium-6 columns">
                <h4>Latest News</h4>
                <ul>
                    @foreach(App\Announcement::orderBy('created_at', 'desc')->take(3)->get() as $announcement)
                        <li><a href="/announcements">{{$announcement->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="medium-4 columns">
        <img class="footer-logo" src="/images/cel.png" />
        <p class="footer-about">Continental was founded in 2016 and has since grown to become an established online gaming community.  We are fueled by our love for great entertainment, and fair competition. Our talented team of employees work hard to bring our vision to life in order to create a one of a kind gaming experience for all of our clients.</p>
    </div>
</div>