<!DOCTYPE html>
<html>
<body style="margin:0;background:#f3f4f6;font-family:Arial">

<table width="100%" cellpadding="0" cellspacing="0">

<tr>
<td align="center" style="
background: linear-gradient(135deg,#a5f3fc,#cffafe,#ffffff);
padding:18px;
font-weight:600;
font-size:16px;">
SMARTELLIB
</td>
</tr>

<tr>
<td align="center">

<table width="520" style="
background:#fff;
margin:40px auto;
border-radius:14px;
padding:40px">

<tr>
<td align="center">

<img src="https://i.imgur.com/NUEDuH0.png" width="140">

<h2 style="color:#111827;margin-top:20px">
  Akun Aktif Kembali
</h2>

<p style="color:#6b7280">
  Halo {{ $user->nama }},
</p>

<p style="color:#6b7280">
  Akun Anda telah diaktifkan kembali.
</p>

<a href="{{ url('/login') }}"
style="
display:inline-block;
margin-top:20px;
padding:10px 20px;
background:#06b6d4;
color:#fff;
text-decoration:none;
border-radius:8px;">
  Login
</a>

<p style="font-size:12px;color:#9ca3af;margin-top:30px">
© {{ date('Y') }} SMARTELLIB
</p>

</td>
</tr>

</table>

</td>
</tr>

</table>

</body>
</html>