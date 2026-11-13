{{-- Estilos compartidos para los dashboards (paleta restaurante: rojo / naranja / amarillo) --}}
<style type="text/css">
	.dash {
		--d-red:#c62828; --d-orange:#ef6c00; --d-amber:#f9a825; --d-green:#2e7d32;
		--d-ink:#3a2c24; --d-muted:#8d7b6f; --d-border:#efe4da; --d-bg:#fbf7f3;
		font-size:14px; color:var(--d-ink);
	}
	.dash * { box-sizing:border-box; }

	/* Encabezado (compacto) */
	.dash-hero{
		display:flex; align-items:center; gap:12px; flex-wrap:wrap;
		padding:10px 16px; border-radius:12px; color:#fff; margin-bottom:14px;
		background:linear-gradient(120deg,#c62828 0%,#ef6c00 55%,#f9a825 100%);
		box-shadow:0 8px 20px -14px rgba(198,40,40,.55);
	}
	.dash-hero__icon{
		flex:0 0 auto; width:34px; height:34px; border-radius:9px;
		background:rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center; font-size:16px;
	}
	.dash-hero__title{ margin:0; font-size:15px; font-weight:700; line-height:1.2; }
	.dash-hero__sub{ margin:1px 0 0; font-size:11px; color:rgba(255,255,255,.85); text-transform:capitalize; line-height:1.2; }
	.dash-hero__spacer{ flex:1 1 auto; }

	/* Tarjetas de estadística */
	.dash-stats{ display:grid; grid-template-columns:repeat(auto-fit,minmax(210px,1fr)); gap:16px; margin-bottom:22px; }
	.dash-stat{
		position:relative; overflow:hidden;
		background:#fff; border:1px solid var(--d-border); border-radius:14px; padding:18px 18px 0;
		box-shadow:0 6px 18px -12px rgba(58,44,36,.35);
		display:flex; flex-direction:column; min-height:132px;
	}
	.dash-stat__row{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
	.dash-stat__value{ font-size:26px; font-weight:800; line-height:1.1; word-break:break-word; }
	.dash-stat__label{ font-size:11px; font-weight:700; letter-spacing:.6px; text-transform:uppercase; color:var(--d-muted); margin-top:4px; }
	.dash-stat__icon{
		flex:0 0 auto; width:42px; height:42px; border-radius:12px;
		display:flex; align-items:center; justify-content:center; font-size:18px; color:#fff;
	}
	.dash-stat__foot{
		margin:14px -18px 0; padding:9px 18px; font-size:12px; font-weight:600;
		display:flex; align-items:center; justify-content:space-between;
		background:var(--d-bg); color:var(--d-muted); text-decoration:none;
	}
	.dash-stat__foot:hover{ color:var(--d-ink); }
	.dash-stat--sales  .dash-stat__value{ color:var(--d-green); }  .dash-stat--sales  .dash-stat__icon{ background:var(--d-green); }
	.dash-stat--month  .dash-stat__value{ color:var(--d-amber); }  .dash-stat--month  .dash-stat__icon{ background:var(--d-amber); }
	.dash-stat--caja   .dash-stat__value{ color:var(--d-red); }    .dash-stat--caja   .dash-stat__icon{ background:linear-gradient(135deg,var(--d-red),var(--d-orange)); }
	.dash-stat--info   .dash-stat__value{ color:var(--d-orange); } .dash-stat--info   .dash-stat__icon{ background:var(--d-orange); }

	/* Paneles / cards */
	.dash-card{
		background:#fff; border:1px solid var(--d-border); border-radius:14px; overflow:hidden;
		box-shadow:0 6px 18px -12px rgba(58,44,36,.3); margin-bottom:20px;
	}
	/* Para cards que contienen selectpicker / datepicker: el dropdown no debe recortarse */
	.dash-card--overflow{ overflow:visible; }
	.dash-card--overflow .dash-card__head{ border-radius:14px 14px 0 0; }
	.dash-card__head{
		display:flex; align-items:center; gap:9px; padding:9px 14px;
		border-bottom:1px solid var(--d-border); background:#fdfaf7; font-weight:700; font-size:12.5px;
		text-transform:uppercase; letter-spacing:.4px;
	}
	.dash-card__head .fa{
		width:24px; height:24px; border-radius:7px; display:flex; align-items:center; justify-content:center;
		background:rgba(239,108,0,.12); color:var(--d-orange); font-size:12px;
	}
	.dash-card__head .dash-card__extra{ margin-left:auto; font-weight:600; font-size:12px; color:var(--d-muted); }
	.dash-card__body{ padding:16px 18px; }
	.dash-card__body--flush{ padding:0; }

	/* Tabla */
	.dash-table{ width:100%; margin:0; border-collapse:collapse; }
	.dash-table thead th{
		background:#fdf0e7; color:var(--d-red); font-size:11px; letter-spacing:.5px; text-transform:uppercase;
		padding:10px 12px; text-align:left; border-bottom:2px solid var(--d-border);
	}
	.dash-table tbody td{ padding:10px 12px; border-bottom:1px solid #f4ece5; vertical-align:middle; }
	.dash-table tbody tr:hover{ background:#fdfaf7; }
	.dash-table .dash-thumb{ width:34px; height:34px; border-radius:8px; object-fit:cover; margin-right:8px; vertical-align:middle; border:1px solid var(--d-border); }
	.dash-pill{ display:inline-block; padding:3px 10px; border-radius:999px; font-size:12px; font-weight:700; }
	.dash-pill--red{ background:rgba(198,40,40,.12); color:var(--d-red); }
	.dash-pill--green{ background:rgba(46,125,50,.12); color:var(--d-green); }
	.dash-pill--amber{ background:rgba(249,168,37,.16); color:#b06f00; }
	.dash-empty{ padding:26px; text-align:center; color:var(--d-muted); font-size:13px; }

	/* Contenedor de gráfico */
	.dash-chart{ width:100%; min-height:320px; }

	/* Accesos rápidos */
	.dash-quick{ display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:14px; }
	.dash-quick a{
		display:flex; flex-direction:column; align-items:center; gap:8px; text-decoration:none;
		padding:18px 12px; border:1px solid var(--d-border); border-radius:14px; background:#fff; color:var(--d-ink);
		transition:transform .12s, box-shadow .12s, border-color .12s;
	}
	.dash-quick a:hover{ transform:translateY(-2px); box-shadow:0 10px 22px -14px rgba(198,40,40,.5); border-color:#f0c9a6; }
	.dash-quick .fa{ font-size:22px; color:var(--d-orange); }
	.dash-quick span{ font-size:12px; font-weight:700; text-align:center; }

	.dash-grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
	@media (max-width:900px){ .dash-grid-2{ grid-template-columns:1fr; } }
</style>
