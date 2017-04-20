@component('mail::message')
# Introduction

Hi {{ $user->name }}, thanks for registering!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
