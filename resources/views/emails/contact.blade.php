<style>
    .email-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0;
    }

    .contact-details {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 20px;
        margin: 20px 0;
        border-radius: 4px;
    }

    .message-content {
        background: white;
        border: 1px solid #e9ecef;
        padding: 25px;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .contact-item {
        display: flex;
        margin: 10px 0;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .contact-label {
        font-weight: bold;
        color: #495057;
        min-width: 100px;
        margin-right: 15px;
    }

    .contact-value {
        color: #212529;
        flex: 1;
    }

    .message-text {
        line-height: 1.6;
        color: #495057;
        font-size: 16px;
        white-space: pre-wrap;
    }

    .email-footer {
        text-align: center;
        color: #6c757d;
        font-size: 14px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
</style>

@component('mail::message')
    <div class="email-header">
        <h1 style="margin: 0; font-size: 28px;">📧 New Contact Message</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">You have received a new inquiry</p>
    </div>

    <div class="contact-details">
        <h3 style="color: #007bff; margin-top: 0;">📋 Contact Information</h3>
        <div class="contact-item">
            <span class="contact-label">👤 Name:</span>
            <span class="contact-value">{{ $contact->name }}</span>
        </div>
        <div class="contact-item">
            <span class="contact-label">📧 Email:</span>
            <span class="contact-value">{{ $contact->email }}</span>
        </div>
        <div class="contact-item">
            <span class="contact-label">📱 Phone:</span>
            <span class="contact-value">{{ $contact->phone ?? 'Not provided' }}</span>
        </div>
        <div class="contact-item">
            <span class="contact-label">📝 Subject:</span>
            <span class="contact-value">{{ $contact->subject ?? 'No subject' }}</span>
        </div>
        <div class="contact-item" style="border-bottom: none;">
            <span class="contact-label">🕒 Submitted:</span>
            <span class="contact-value">{{ $contact->created_at->format('M d, Y \a\t h:i A') }}</span>
        </div>
    </div>

    <div class="message-content">
        <h3 style="color: #28a745; margin-top: 0;">💬 Message Content</h3>
        <div class="message-text">{{ $contact->message }}</div>
    </div>

@endcomponent
