<x-mail::message>

Dear {{$user->name}}
Task {{$user->title}}
{{$message}}
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
