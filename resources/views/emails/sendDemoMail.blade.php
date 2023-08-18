<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>{{ $mailData['title'] }}</h2>
        </div>
        <div class="content">
            {{-- <p>Hello [Nama Pengguna],</p> --}}
            <p>Anda menerima email ini karena telah mengajukan permintaan reset password untuk akun Anda.</p>
            <p>Berikut adalah kode OTP (One-Time Password) untuk mereset password Anda:</p>
            <h3 style="text-align: center; background-color: #f2f2f2; padding: 10px;">{{ $mailData['body'] }}</h3>
            <p>Jika Anda tidak merasa melakukan permintaan ini, Anda dapat mengabaikan email ini.</p>
            <p>Terima kasih,</p>
            <p>Tim Dukungan Kami</p>
        </div>
        <div class="footer">
            <p>Email ini adalah email otomatis, jangan membalas.</p>
        </div>
    </div>
</body>

</html>
