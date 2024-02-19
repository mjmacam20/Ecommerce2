<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <table>
        <tr><td>Dear {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Please click on below link to activate your account:-:</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><a href="{{ url('/user/confirm/'.$code) }}">Confirm Account</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Sincerly,</td></tr>
        <tr><td>Wavepad Management</td></tr>
    </table>
    
</body>
</html>