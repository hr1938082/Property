@component('mail::message')
{{"Dear ".$details['name'].","}}
<br>
{{$details['body']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
