<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting...</title>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const token = params.get("token");
            const redirect = params.get("redirect") || "/dashboard";

            if (token) {
                localStorage.setItem("auth_token", token);
                window.dispatchEvent(new Event("auth-changed"));
            }
            
            window.location.href = redirect;
        });
    </script>
</head>
<body style="background:#010409;color:#fff;text-align:center;padding-top:100px;">
    <h3>กำลังเข้าสู่ระบบ...</h3>
</body>
</html>
