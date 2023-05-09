@component('mail::message')
# Game stats are ready!

Click the button to see how did you do.

@component('mail::button', ['url' => 'http://localhost:8000/emailStats/' . session()->get("fix")])
Link to stats sheet
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
