<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendConfirmationEmail($toEmail, $bookInOrderDetails, $userName, $totalPayment, $deliveryAddress) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pddat2602@gmail.com';
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('pddat2602@gmail.com', 'BookNest Website');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Order Confirmation';

        $orderItemsHtml = '';
        foreach ($bookInOrderDetails as $item) {
            $orderItemsHtml .= "
                <tr>
                    <td>{$item['title']}</td>
                    <td>" . number_format($item['price'], 0, ',', '.') . "</td>
                    <td>{$item['quantity']}</td>
                    <td>" . number_format($item['price'] * $item['quantity'], 0, ',', '.') . "</td>
                </tr>
            ";
        }

        $mail->Body = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }
                .order-details table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .order-details th, .order-details td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: center;
                }
                .total-payment {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='email-content'>
                    <p>Hello <strong>{$userName}</strong>,</p>
                    <p>Thank you for your order at BookNest!</p>
                    <p>Here are the details of your order:</p>
                    <table class='order-details'>
                        <tr>
                            <th>Book Title</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        {$orderItemsHtml}
                    </table>
                    <p><strong>Total Payment:</strong> " . number_format($totalPayment, 0, ',', '.') . "</p>
                    <p><strong>Delivery Address:</strong> {$deliveryAddress}</p>
                    <p>We will notify you about the delivery status as soon as possible.</p>
                    <p>If you have any questions, please feel free to contact us.</p>
                    <p>Best regards,</p>
                    <p>BookNest.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
        return false;
    }
}
