<?php require( '../../../../../wp-load.php' ); ?>
<script type="text/javascript" src="<?php get_template_directory_uri('/js/jquery.js') ?>"></script>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-includes/js/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script type="text/javascript">
	function insertSymbol(symbol) {
		tinyMCE.execCommand("mceInsertContent",false," [" + symbol + "] ");
		tinyMCEPopup.close();
	}
</script>
<style>
table, th, td{
	border: 0px solid #333;
	padding:5px;
}
table {
	border-collapse:collapse;
}
</style>
<input type="hidden" id="pokerSymbolInput" />
<table width="100%">
	<tr align="center">
    	<td><a href="javascript:" onclick="insertSymbol('2c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/2c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('2d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/2d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('2h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/2h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('2s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/2s.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('3c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/3c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('3d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/3d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('3h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/3h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('3s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/3s.gif" /></a></td>
    </tr>
	<tr align="center">
    	<td><a href="javascript:" onclick="insertSymbol('4c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/4c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('4d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/4d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('4h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/4h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('4s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/4s.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('5c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/5c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('5d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/5d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('5h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/5h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('5s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/5s.gif" /></a></td>
    </tr>
	<tr align="center">
    	<td><a href="javascript:" onclick="insertSymbol('6c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/6c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('6d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/6d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('6h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/6h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('6s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/6s.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('7c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/7c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('7d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/7d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('7h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/7h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('7s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/7s.gif" /></a></td>
    </tr>
	<tr align="center";>
    	<td><a href="javascript:" onclick="insertSymbol('8c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/8c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('8d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/8d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('8h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/8h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('8s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/8s.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('9c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/9c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('9d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/9d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('9h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/9h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('9s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/9s.gif" /></a></td>
    </tr>
	<tr align="center">
    	<td><a href="javascript:" onclick="insertSymbol('10c')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/10c.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('10d')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/10d.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('10h')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/10h.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('10s')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/10s.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('ac')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/ac.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('ad')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/ad.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('ah')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/ah.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('as')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/as.gif" /></a></td>
    </tr>
	<tr align="center">
    	<td><a href="javascript:" onclick="insertSymbol('jc')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/jc.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('jd')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/jd.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('jh')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/jh.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('js')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/js.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('qc')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/qc.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('qd')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/qd.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('qh')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/qh.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('qs')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/qs.gif" /></a></td>
    </tr>
	<tr align="center">
    	<td><a href="javascript:" onclick="insertSymbol('kc')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/kc.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('kd')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/kd.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('kh')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/kh.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('ks')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/ks.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('xc')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/xc.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('xd')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/xd.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('xh')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/xh.gif" /></a></td>
    	<td><a href="javascript:" onclick="insertSymbol('xs')"><img src="<?php bloginfo('template_url'); ?>/includes/tinymce/cards/xs.gif" /></a></td>
    </tr>
    
</table>