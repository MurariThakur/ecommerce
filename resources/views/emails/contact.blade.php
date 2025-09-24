@component('mail::message')
    # New Contact Form Submission

    **Name:** {{ $contact->name }}
    **Email:** {{ $contact->email }}
    **Phone:** {{ $contact->phone ?? 'Not provided' }}
    **Subject:** {{ $contact->subject ?? 'No subject' }}

    **Message:**
    {{ $contact->message }}

    @component('mail::button', ['url' => route('admin.contact.show', $contact->id)])
        View in Admin Panel
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
