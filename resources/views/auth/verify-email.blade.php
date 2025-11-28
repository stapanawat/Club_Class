<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันอีเมล - Exclusive Content</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full text-center border border-gray-700">
        <h2 class="text-2xl font-bold mb-4 text-amber-500">ยืนยันอีเมลของคุณ</h2>

        <p class="mb-6 text-gray-300">
            ขอบคุณที่สมัครสมาชิก! ก่อนเริ่มต้นใช้งาน กรุณายืนยันอีเมลของคุณโดยคลิกลิงก์ที่เราส่งไปให้ทางอีเมล
        </p>

        @if (session('message') == 'Verification link sent!')
            <div class="mb-4 font-medium text-sm text-green-400">
                ส่งลิงก์ยืนยันใหม่ไปยังอีเมลของคุณแล้ว
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                    ส่งลิงก์ยืนยันอีกครั้ง
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-400 hover:text-white underline">
                    ออกจากระบบ
                </button>
            </form>
        </div>
    </div>
</body>

</html>