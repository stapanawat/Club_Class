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

            console.log("OAuth Callback:", { token, redirect });

            if (token) {
                localStorage.setItem("auth_token", token);
                window.dispatchEvent(new Event("auth-changed"));

                // Update the fallback link
                const link = document.getElementById('manual-link');
                if (link) link.href = redirect;

                setTimeout(() => {
                    window.location.replace(redirect);
                }, 100);
            } else {
                console.error("No token found in URL");
                document.body.innerHTML = "<h3>Error: No token found. <a href='/login' style='color:#fbbf24'>Back to Login</a></h3>";
            }
        });
    </script>
</head>

<body style="background:#010409;color:#fff;text-align:center;padding-top:100px;font-family:sans-serif;">
    <h3>กำลังเข้าสู่ระบบ...</h3>
    <p style="color:#888;margin-top:20px;">
        หากหน้าจอไม่เปลี่ยนอัตโนมัติ <a id="manual-link" href="/dashboard"
            style="color:#fbbf24;text-decoration:underline;">คลิกที่นี่</a>
    </p>
</body>

</html>