  </div></div></div>
<script>
// show / hide password
document.querySelectorAll('input[type="password"]').forEach(function (inp) {
  var w = document.createElement('div'); w.className = 'pw-wrap'; inp.parentNode.insertBefore(w, inp); w.appendChild(inp);
  var b = document.createElement('button'); b.type = 'button'; b.className = 'pw-toggle'; b.setAttribute('aria-label', 'Show password'); b.innerHTML = '<i class="fa-regular fa-eye"></i>';
  b.onclick = function () { var show = inp.type === 'password'; inp.type = show ? 'text' : 'password'; b.innerHTML = show ? '<i class="fa-regular fa-eye-slash"></i>' : '<i class="fa-regular fa-eye"></i>'; b.setAttribute('aria-label', show ? 'Hide password' : 'Show password'); };
  w.appendChild(b);
});
</script>
<script src="assets/app.js"></script></body></html>
