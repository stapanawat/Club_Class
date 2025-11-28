<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ยืนยันอีเมล</title>
</head>

<body>
    <p>สวัสดี {{ $name }},</p>

    <p>กรุณาคลิกลิงก์ด้านล่างเพื่อยืนยันอีเมลของคุณ ภายใน 30 นาที:</p>

    <!-- ✅ ลิงก์ยืนยัน ต้องใช้ $verifyUrl -->
    <p>
        <a style="
               display:inline-block;
               padding:10px 18px;
               background:#f59e0b;
               color:#ffffff;
               border-radius:6px;
               text-decoration:none;
               font-weight:bold; " href="http://localhost:8000/login">กดยืนยันอีเมล</a>
    </p>

    <!-- ลิงก์ไปหน้า login เพิ่มเติม (optional) -->


    <p> ระบบ Exclusive Content ย</p>
</body>

</html>