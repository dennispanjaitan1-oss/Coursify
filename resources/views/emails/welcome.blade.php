<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Coursify</title>
</head>
<body style="margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background-color:#fafafa;color:#1a1a1a;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fafafa;padding:60px 20px;">
    <tr>
        <td align="center">
            <table role="presentation" width="540" cellpadding="0" cellspacing="0" style="max-width:540px;width:100%;background-color:#ffffff;border:1px solid #eaeaea;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.02);">
                
                <!-- Logo Header -->
                <tr>
                    <td style="padding:48px 48px 24px;text-align:left;">
                        <span style="font-size:20px;font-weight:700;letter-spacing:-0.5px;color:#111111;text-transform:uppercase;">Coursify</span>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:0 48px 36px;">
                        <h1 style="margin:0 0 16px;font-size:24px;font-weight:600;color:#111111;letter-spacing:-0.3px;line-height:1.3;">
                            Start Your New Learning Journey
                        </h1>
                        <p style="margin:0 0 24px;font-size:14px;color:#666666;line-height:1.6;">
                            Hi {{ $user->name }},<br><br>
                            Your account has been successfully created. This platform is built to support your professional growth with access to structured learning programs from top institutions.
                        </p>
                        
                        <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:16px;">
                            <tr>
                                <td>
                                    <a href="{{ route('courses.index') }}"
                                       style="display:inline-block;background-color:#111111;color:#ffffff;padding:12px 28px;
                                              border-radius:6px;text-decoration:none;font-weight:500;font-size:13px;letter-spacing:0.5px;">
                                        Jelajahi Program
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer Separator -->
                <tr>
                    <td style="padding:0 48px;">
                        <div style="height:1px;background-color:#eaeaea;"></div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding:24px 48px 48px;font-size:12px;color:#999999;line-height:1.5;">
                        <p style="margin:0 0 4px;font-weight:600;color:#666666;">Coursify</p>
                        <p style="margin:0;">
                            This email was sent automatically to confirm your new account registration.<br>
                            &copy; {{ date('Y') }} Coursify. All rights reserved.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>