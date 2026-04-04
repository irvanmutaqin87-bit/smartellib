<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

@vite('resources/css/app.css')

<title>Lupa Password SMARTELLIB</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen">

<!-- TOAST SUCCESS -->
@if(session('status'))
<div id="toast-success"
class="fixed top-6 left-1/2 -translate-x-1/2 z-50
opacity-0 -translate-y-6 transition-all duration-500">

<div class="backdrop-blur-xl bg-emerald-400/20 border border-emerald-300/40
text-emerald-900 px-6 py-2 rounded-xl shadow-xl text-sm font-medium
max-w-md text-center break-words">

{{ session('status') }}

</div>
</div>
@endif

<!-- TOAST ERROR -->
@if(session('error'))
<div id="toast-error"
class="fixed top-6 left-1/2 -translate-x-1/2 z-50
opacity-0 -translate-y-6 transition-all duration-500">

<div class="backdrop-blur-xl bg-red-400/20 border border-red-300/40
text-red-900 px-6 py-2 rounded-xl shadow-xl text-sm font-medium
max-w-md text-center break-words">

{{ session('error') }}

</div>
</div>
@endif


<div class="flex flex-col items-center justify-center min-h-screen py-12 px-4">

<!-- LOGO -->
<div class="mb-8 reveal reveal-scale">
<img src="{{ asset('/img/logo.png') }}" class="w-56 drop-shadow-xl">
</div>


<!-- CARD -->
<div class="w-[460px] max-w-full bg-white rounded-2xl p-8 shadow-lg reveal reveal-up delay-100">

<h1 class="text-2xl font-bold text-black mb-1 text-center">
Lupa Kata Sandi?
</h1>

<p class="text-gray-500 mb-10 text-sm text-center max-w-xs mx-auto">
Masukkan email akun Anda dan kami akan mengirimkan link untuk reset password.
</p>

<form method="POST" action="{{ route('password.email') }}" id="resetForm">
@csrf

<!-- EMAIL -->
<input
id="email"
type="email"
name="email"
value="{{ old('email') }}"
placeholder="Email"
class="w-full mb-4 px-4 py-3 rounded-xl text-sm
bg-gradient-to-br from-cyan-100/60 to-white/40
border border-white/50
backdrop-blur-md
shadow-sm
focus:ring-2 focus:ring-cyan-400/60
focus:border-cyan-400
hover:shadow-md
outline-none transition-all duration-300
@error('email') border-red-400 ring-2 ring-red-300 @enderror">

@error('email')
<p class="text-xs text-red-500 mb-2 ml-1 error-message" data-error-for="email">
{{ $message }}
</p>
@enderror


<!-- BUTTON -->
<button
id="resetButton"
type="submit"
class="w-full py-2.5 rounded-xl text-white font-semibold
bg-gradient-to-r from-cyan-400 via-sky-500 to-sky-400
shadow-md shadow-cyan-200/40
hover:from-cyan-500 hover:via-sky-600 hover:to-sky-500
hover:shadow-lg hover:shadow-cyan-300/50
active:opacity-90
transition-all duration-300
flex items-center justify-center gap-2">

<span id="resetText">
Kirim Link Reset Password
</span>

<svg id="resetSpinner"
class="hidden w-4 h-4 animate-spin"
xmlns="http://www.w3.org/2000/svg"
fill="none"
viewBox="0 0 24 24">

<circle class="opacity-25"
cx="12"
cy="12"
r="10"
stroke="currentColor"
stroke-width="4"></circle>

<path class="opacity-75"
fill="currentColor"
d="M4 12a8 8 0 018-8v8z"></path>

</svg>
</button>

</form>


<!-- LINK LOGIN -->
<p class="text-center text-gray-500 mt-3 text-sm">
Sudah ingat password?
<a href="{{ route('login') }}"
class="text-cyan-600 hover:underline transition">
Login Sekarang
</a>
</p>

</div>
</div>



<!-- TOAST SCRIPT -->
<script>

document.addEventListener("DOMContentLoaded", function () {

const successToast = document.getElementById("toast-success");
const errorToast = document.getElementById("toast-error");

function animateToast(toast){

if(!toast) return;

setTimeout(() => {
toast.classList.remove("opacity-0","-translate-y-6");
},100);

setTimeout(() => {

toast.classList.add("opacity-0","-translate-y-6");

setTimeout(()=>{ toast.remove(); },500);

},3500);

}

animateToast(successToast);
animateToast(errorToast);


// redirect ke login setelah success
if(successToast){
setTimeout(() => {
window.location.href = "{{ route('login') }}";
},3500);
}

});

</script>



<!-- SPINNER SCRIPT -->
<script>

document.addEventListener("DOMContentLoaded", function () {

const form = document.getElementById("resetForm");
const button = document.getElementById("resetButton");
const text = document.getElementById("resetText");
const spinner = document.getElementById("resetSpinner");
const email = document.getElementById("email");

form.addEventListener("submit", function () {

if (!email.value.trim()) return;

button.disabled = true;
button.classList.add("opacity-70","cursor-not-allowed");

text.textContent = "Mengirim...";
spinner.classList.remove("hidden");

});

});

</script>



<!-- ANIMASI REVEAL -->
<script>

document.addEventListener("DOMContentLoaded", () => {

const animationMap = {
"reveal-left": "animate-slideLeft",
"reveal-right": "animate-slideRight",
"reveal-up": "animate-slideUp",
"reveal-scale": "animate-scaleIn"
};

const observer = new IntersectionObserver((entries, observer) => {

entries.forEach(entry => {

if (!entry.isIntersecting) return;

for (let key in animationMap) {

if (entry.target.classList.contains(key)) {
entry.target.classList.add(animationMap[key]);
break;
}

}

observer.unobserve(entry.target);

});

}, { threshold: 0.2 });

document.querySelectorAll(".reveal")
.forEach(el => observer.observe(el));

});

</script>

</body>
</html>