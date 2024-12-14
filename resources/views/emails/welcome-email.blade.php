@component('mail::message')
# Welcome to Cymer Larave

this is a community of fellow developers and we love that you have joined us.

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Regards,<br>
{{ config('app.name') }}
{{-- Cymer --}}
@endcomponent
