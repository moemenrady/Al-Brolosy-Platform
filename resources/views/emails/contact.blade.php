<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; }
        h2 { color: #d7a7a4; }
        .detail { margin-bottom: 15px; padding: 10px; border: 1px solid #eee; background: white; border-left: 5px solid #624641; }
        strong { color: #624641; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Contact Message Received</h2>
        <p>You have received a new contact message from your website:</p>

        <div class="detail">
            <strong>Name:</strong> {{ $formData['name'] ?? 'N/A' }}
        </div>
        
        <div class="detail">
            <strong>Email:</strong> {{ $formData['email'] }}
        </div>
        
        <div class="detail">
            <strong>Message:</strong>
            <p style="white-space: pre-wrap; margin-top: 5px; padding-left: 10px; border-left: 2px solid #d7a7a4;">{{ $formData['message'] }}</p>
        </div>
        
        <p>---<br>End of message.</p>
    </div>
</body>
</html>