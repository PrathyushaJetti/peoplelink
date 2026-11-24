const $=(s,r=document)=>r.querySelector(s),$$=(s,r=document)=>[...r.querySelectorAll(s)];
const side=$('#side'),ov=$('#overlay');
const toggle=o=>{side.classList.toggle('open',o);ov.classList.toggle('on',o)};
$('#menuBtn')?.addEventListener('click',()=>toggle(!side.classList.contains('open')));
ov?.addEventListener('click',()=>toggle(false));
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&side)toggle(false)});
$$('form[data-confirm]').forEach(f=>f.addEventListener('submit',e=>{if(!confirm(f.dataset.confirm))e.preventDefault()}));
const fmt=(n,p)=>(p||'')+Math.round(n).toLocaleString('en-IN');
$$('[data-count]').forEach(el=>{const to=+el.dataset.count,p=el.dataset.prefix||'',t0=performance.now(),d=900;
 const step=t=>{const k=Math.min(1,(t-t0)/d);el.textContent=fmt(to*(1-Math.pow(1-k,3)),p);if(k<1)requestAnimationFrame(step)};requestAnimationFrame(step)});
$$('[data-open]').forEach(b=>b.addEventListener('click',()=>{const d=document.getElementById(b.dataset.open);
 if(b.dataset.fill){Object.entries(JSON.parse(b.dataset.fill)).forEach(([k,v])=>{const f=d.querySelector('[name="'+k+'"]');if(f)f.value=v})}
 else d.querySelectorAll('form [name]:not([type=hidden])').forEach(f=>{f.value=f.defaultValue});
 if(b.dataset.title)d.querySelector('[data-dtitle]').textContent=b.dataset.title;d.showModal()}));
$$('[data-close]').forEach(b=>b.addEventListener('click',()=>b.closest('dialog').close()));
$$('dialog').forEach(d=>d.addEventListener('click',e=>{if(e.target===d)d.close()}));
$$('[data-tpl]').forEach(b=>b.addEventListener('click',()=>{Object.entries(JSON.parse(b.dataset.tpl)).forEach(([k,v])=>{const f=document.querySelector('[name="'+k+'"]');if(f)f.value=v});$('[name=title]')?.focus()}));
$$('tbody').forEach(tb=>[...tb.children].forEach((tr,i)=>tr.style.setProperty('--i',Math.min(i,14))));
$$('.top h2,.crumb,.card-h h3,.auth-card h2,.pick h1,.auth-art h1,.soon h3').forEach((el,idx)=>{
 if([...el.children].some(c=>c.tagName!=='BR'))return;
 const base=.15+Math.min(idx,8)*.09;
 el.innerHTML=el.innerHTML.split(/<br\s*\/?>/i).map((line,n)=>'<span class="mask"><span style="--d:'+(base+n*.14).toFixed(2)+'s">'+line+'</span></span>').join('');
});
