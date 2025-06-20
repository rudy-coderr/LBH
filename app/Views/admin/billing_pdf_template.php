<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Letty's Birthing Home - Billing Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6a1b9a;
            padding-bottom: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px; /* space between logo and text */
        }

        .logo-img {
            width: 70px;
            height: auto;
            /* margin-right removed */
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #6a1b9a;
        }

        .company-details {
            font-size: 14px;
            line-height: 1.5;
        }

        .invoice-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #6a1b9a;
        }

        .invoice-details {
            background-color: #f5f0f9;
            border-left: 4px solid #6a1b9a;
            padding: 15px 20px;
            margin-bottom: 30px;
            border-radius: 0 5px 5px 0;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }

        .detail-label {
            width: 150px;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        .status-paid {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-unpaid {
            background-color: #ffebee;
            color: #c62828;
        }

        .status-partial {
            background-color: #fff8e1;
            color: #f57f17;
        }

        .notes-section {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo">
                <img src="<?= $logo ?>" alt="Letty's Birthing Home Logo" class="logo-img">

                <div>
                    <div class="company-name">Letty's Birthing Home</div>
                    <div class="company-details">
                       4433 Sta Justina <br>
                        Buhi,Camarines Sur<br>
                        CP: 09436546332
                    </div>
                </div>
            </div>
            <div>
                <strong>Invoice #:</strong> <?= esc($bill['id'] ?? 'INV-'.date('Ymd')) ?>
            </div>
        </div>

        <div class="invoice-title">Billing Invoice</div>

        <div class="invoice-details">
            <div class="detail-row">
                <div class="detail-label">Patient Name:</div>
                <div><?= esc($patient['full_name']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Amount:</div>
                <div><strong>P <?= esc(number_format($bill['amount'], 2)) ?></strong></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div>
                    <?php
                    $statusClass = '';
                    $status = strtolower(esc($bill['payment_status']));
                    if ($status === 'paid') {
                        $statusClass = 'status-paid';
                    } elseif ($status === 'unpaid') {
                        $statusClass = 'status-unpaid';
                    } else {
                        $statusClass = 'status-partial';
                    }
                    ?>
                    <span class="status-badge <?= $statusClass ?>"><?= esc($bill['payment_status']) ?></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Payment Date:</div>
                <div><?= esc($bill['payment_date']) ?: 'N/A' ?></div>
            </div>
        </div>

        <div class="notes-section">
            <strong>Notes:</strong>
            <p><?= esc($bill['notes']) ?: 'No additional notes.' ?></p>
        </div>

        <div class="footer">
            Thank you for choosing Letty's Birthing Home.<br>
            For billing inquiries, please contact our accounting department at accounting@lettysbirthinghome.ph
        </div>
    </div>
</body>
</html>
