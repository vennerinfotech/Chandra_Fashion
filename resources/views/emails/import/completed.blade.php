<!DOCTYPE html>
<html>
<head>
    <title>Import Results</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    @php
        $statusColor = $log->status === 'completed' ? '#28a745' : '#dc3545';
        $statusText = $log->status === 'completed' ? 'Success' : 'Failed';
        $skippedCount = $log->skipped_rows ?? 0;
        $failedCount = $log->failed_rows ?? 0;
        // Assuming 'successful_rows' tracks purely new/updated, but total processed counts everything
        $successCount = $log->processed_rows - $skippedCount - $failedCount;
    @endphp

    <h2 style="color: {{ $statusColor }};">
        {{ $log->status === 'completed' ? '✅ Import Completed' : '❌ Import Failed' }}
    </h2>
    <p>Hello Admin,</p>
    <p>The product import job has finished. Here are the details:</p>

    <table style="border-collapse: collapse; width: 100%; max-width: 600px; border: 1px solid #ddd; margin-bottom: 20px;">
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9; width: 180px;"><strong>Status:</strong></td>
            <td style="padding: 10px; font-weight: bold; color: {{ $statusColor }};">{{ $statusText }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>File Name:</strong></td>
            <td style="padding: 10px;">{{ $log->file_name }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Total Rows:</strong></td>
            <td style="padding: 10px;">{{ $log->total_rows }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Imported Successfully:</strong></td>
            <td style="padding: 10px; color: green; font-weight: bold;">{{ $successCount }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Already Existing / Skipped:</strong></td>
            <td style="padding: 10px; color: orange; font-weight: bold;">{{ $skippedCount }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Failed / Errors:</strong></td>
            <td style="padding: 10px; color: red; font-weight: bold;">{{ $failedCount }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f9f9f9;"><strong>Completed At:</strong></td>
            <td style="padding: 10px;">{{ $log->completed_at ? $log->completed_at->format('d M Y, h:i A') : 'N/A' }}</td>
        </tr>
    </table>

    @if($log->error_message)
        <div style="background-color: #fff3f3; border: 1px solid #ffa0a0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            <strong style="color: #dc3545;">Critical Error:</strong>
            <p style="margin: 5px 0;">{{ $log->error_message }}</p>
        </div>
    @endif

    @if(!empty($log->skipped_details))
        <h3>⚠️ Skipped Products & Reasons</h3>
        <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Row</th>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Product Code</th>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($log->skipped_details as $detail)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $detail['row'] ?? '-' }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $detail['product_code'] ?? '-' }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $detail['reason'] ?? 'Skipped' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p>Thanks,<br>
    Hashtag Team</p>
</body>
</html>
