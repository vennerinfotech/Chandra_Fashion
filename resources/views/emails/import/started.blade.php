<!DOCTYPE html>
<html>
<head>
    <title>Import Started</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>🚀 Product Import Started</h2>
    <p>Hello Admin,</p>
    <p>A new product import job has begun.</p>
    
    <table style="border-collapse: collapse; width: 100%; max-width: 600px; border: 1px solid #ddd;">
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9; width: 150px;"><strong>File Name:</strong></td>
            <td style="padding: 10px;">{{ $fileName }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Total Rows:</strong></td>
            <td style="padding: 10px;">{{ $totalRows }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Started At:</strong></td>
            <td style="padding: 10px;">{{ $startTime->format('d M Y, h:i A') }}</td>
        </tr>
    </table>
    
    <p>You will receive another email when the import is completed.</p>
    
    <p>Thanks,<br>
    Hashtag Team</p>
</body>
</html>
