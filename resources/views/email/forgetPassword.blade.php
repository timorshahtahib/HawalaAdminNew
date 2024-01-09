<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Verify Email | {{ config('app.APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body style="background-color:#f0f3fc; padding: 20px 0px;">
    <div style="margin: 50px 0px;">
        <table cellpadding="0" cellspacing="0" style="font-family: 'Inter','sans-serif'; font-size: 15px; font-weight: 400; max-width: 700px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15); width:50%; ">
            <thead>
                <tr style="background-color: #3b395e; border: none; height: 70px;">
                    <th scope="col" style="padding: 28px;display: flex;align-items: center; justify-content: space-between;">
                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="<?php echo Config::get('app.APP_NAME'); ?>" title="<?php echo Config::get('app.APP_NAME'); ?>" style="height: 24px;" />
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td style="padding: 25px 25px 0; color: #161c2d; font-size: 18px; text-align: center;">
                        You have requested to reset your password.!
                    </td>
                </tr>
                <tr>
                    <td style="padding: 25px 25px 0; color: #7c8ca3; font-size: 14px; text-align: center; line-height: 1.5;">
                        <p>Hello, We cannot simply send you your old password. A unique link to reset your password has been generated for you. To reset your password, click the following link and follow the instructions.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 25px 25px 0; color: #161c2d; font-size: 18px; text-align: center;">
                        <a href="{{ $token }}" target="_blank" style="padding: 10px 20px; outline: none; text-decoration: none; font-size: 16px;  border-radius: 4px; background-color: #242e4d; border: 1px solid #242e4d; color: #ffffff;">Click Here</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 25px 25px 0; color: #7c8ca3; font-size: 14px; text-align: center; line-height: 1.5;">
                        <p>If you did not request a password reset, no further action is required.<br>Thanks & Regards,<br>Skote Support team.</p>
                    </td>
                </tr>
                

                <td style="padding: 28px; color: #7c8ca3; background-color: #f8f9fc; font-size: 13px;">
                    <div style="display: flex;gap: 10px;">
                        <div style="flex-shrink: 0;">
                            <img src="https://preview.pichforest.com/images/help.png" alt="" style="height: 36px;">
                        </div>
                        <div style="flex-grow: 1;">
                            <h5 style="color: #161c2d; font-size: 14px; margin: 0 0 5px; font-weight: 500;">Any Questions?</h5>
                            <p style="margin: 0; line-height: 1.5;">If you need any help, please <a href="javascript:void(0)" target="_blank" style="color: #2f75d0;text-decoration: none;">Contact support.</a></p>
                        </div>
                    </div>
                </td>
                
                <tr>
                    <td style="padding: 20px 8px; color: #cad2dd; background-color: #3b395e; text-align: center;">
                    {{ date('Y') }} @ <a href="#" style="color: #cad2dd; text-decoration: none;">Skote</a>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
</body>

</html>
