@component('mail::message')
# New Villa Inquiry

You have received a new inquiry from **{{ $inquiry->name }}**.

@if($inquiry->villa)
### Villa: {{ $inquiry->villa->name }}
@endif

### Guest Details
- **Name:** {{ $inquiry->name }}
- **Email:** {{ $inquiry->email }}
@if($inquiry->phone)
- **Phone:** {{ $inquiry->phone }}
@endif
@if($inquiry->whatsapp)
- **WhatsApp:** {{ $inquiry->whatsapp }}
@endif

### Stay Details
@if($inquiry->check_in)
- **Check-in:** {{ $inquiry->check_in->format('F d, Y') }}
@endif
@if($inquiry->check_out)
- **Check-out:** {{ $inquiry->check_out->format('F d, Y') }}
@endif
@if($inquiry->number_of_guests)
- **Guests:** {{ $inquiry->number_of_guests }}
@endif

### Message
{!! nl2br(e($inquiry->message)) !!}

@if($inquiry->special_requests)
### Special Requests
{!! nl2br(e($inquiry->special_requests)) !!}
@endif

@component('mail::button', ['url' => route('admin.inquiries.show', $inquiry)])
View Inquiry in Admin
@endcomponent

---
*This inquiry was submitted from the website on {{ $inquiry->created_at->format('F d, Y \a\t g:i A') }}.*
@endcomponent
