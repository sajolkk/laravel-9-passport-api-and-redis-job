<x-mail::message>
{{-- # Introduction --}}
Hi {{ $data['name'] }},
Thank you for create account. Your account created successfully.

<x-mail::button :url="''">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
