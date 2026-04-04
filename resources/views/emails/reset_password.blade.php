<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reset Password SMARTELLIB</title>
</head>

<body style="margin:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif">

<table width="100%" cellpadding="0" cellspacing="0">

<tr>
<td align="center" style="
background: #a5f3fc;
background: linear-gradient(
    135deg,
    #a5f3fc 0%,
    #cffafe 50%,
    #ffffff 100%
);
padding:18px;
border-radius:12px 12px 0 0;
color:#0f172a;
font-weight:600;
font-size:16px;">

SMARTELLIB Security

</td>
</tr>

<!-- CARD -->
<table width="520" cellpadding="0" cellspacing="0"
style="background:#ffffff;margin:40px auto;border-radius:14px;
box-shadow:0 10px 25px rgba(0,0,0,0.05);padding:40px">

<tr>
<td align="center">

<!-- LOGO -->
<img src="https://i.imgur.com/NUEDuH0.png"
     width="150"
     alt="SMARTELLIB Logo"
     style="margin-bottom:20px;">

<h2 style="
font-size:22px;
margin-bottom:10px;
color:#111827;
font-weight:600">

Reset Password

</h2>

<p style="
color:#6b7280;
font-size:14px;
line-height:1.6;
margin-bottom:10px">

Halo <strong>{{ $user->nama }}</strong>,

</p>

<p style="
color:#6b7280;
font-size:14px;
line-height:1.6;
margin-bottom:25px">

Kami menerima permintaan untuk mereset password akun
<strong>SMARTELLIB</strong> Anda.

</p>

<!-- BUTTON -->
<a href="{{ $url }}"
style="
display:inline-block;
padding:12px 26px;
background:linear-gradient(90deg,#06b6d4,#0ea5e9);
color:white;
text-decoration:none;
border-radius:8px;
font-size:14px;
font-weight:600;
box-shadow:0 6px 15px rgba(14,165,233,0.35);
margin-bottom:25px">

Reset Password

</a>

<p style="
font-size:13px;
color:#6b7280;
line-height:1.6">

Link ini akan kedaluwarsa dalam <b>60 menit</b>.

</p>

</td>
</tr>

<!-- SECURITY INFO -->
<tr>
<td style="padding-top:20px">

<table width="100%" style="background:#f9fafb;border-radius:8px;padding:15px">

<tr>
<td style="font-size:13px;color:#374151">

<strong>Informasi Permintaan Reset</strong>

</td>
</tr>

<tr>
<td style="font-size:13px;color:#6b7280;padding-top:6px">

IP Address : {{ request()->ip() }}

</td>
</tr>

<tr>
<td style="font-size:13px;color:#6b7280">

Waktu Request : {{ now()->format('d M Y H:i') }}

</td>
</tr>

</table>

</td>
</tr>

<!-- WARNING -->
<tr>
<td style="padding-top:20px">

<p style="
font-size:13px;
color:#6b7280;
line-height:1.6">

Jika Anda tidak meminta reset password, abaikan email ini.
Password Anda tidak akan berubah.

</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="padding-top:25px">

<hr style="border:none;border-top:1px solid #e5e7eb;margin-bottom:15px">

<p style="
font-size:12px;
color:#9ca3af">

© {{ date('Y') }} SMARTELLIB Digital Library  
Sistem perpustakaan digital modern

</p>

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>