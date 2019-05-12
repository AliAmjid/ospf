<?php
// source: /home/ali/www/ospf/app/presenters/templates/@layout.latte

use Latte\Runtime as LR;

class Templatebc3a0c2338 extends Latte\Runtime\Template
{
	public $blocks = [
		'css' => 'blockCss',
		'js' => 'blockJs',
	];

	public $blockTypes = [
		'css' => 'html',
		'js' => 'html',
	];


	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>MyOSPF v<?php echo LR\Filters::escapeHtmlText($version) /* line 5 */ ?></title>
	<script src="/js/libs-<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($version)) /* line 6 */ ?>.js"></script>
	<link rel="stylesheet" href="/css/libs-<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($version)) /* line 7 */ ?>.css">
	<link rel="stylesheet" href="/css/release-<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($version)) /* line 8 */ ?>.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('css', get_defined_vars());
?>
	<style>
		.souhrn, #eq, .eq, .dulezite {
			display: none;
		}
	</style>
</head>

<body>
<?php
		$this->renderBlock('content', $this->params, 'html');
?>
	<br>
	<br>
	<br>
	<i class="signature" style="position: absolute; top: 96%; margin-left: 90%">Made by <b>Ali Amjid</b></i>
	<br>
	<br>
	<script src="/js/release-<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($version)) /* line 28 */ ?>.js"></script>
	<div class="under-me"></div>
<?php
		$this->renderBlock('js', get_defined_vars());
		$iterations = 0;
		foreach ($flashes as $flash) {
?>
		<script>
			swal({
				position: 'top-end',
				type: <?php echo LR\Filters::escapeJs($flash->type) /* line 36 */ ?>,
				title: <?php echo LR\Filters::escapeJs($flash->message) /* line 37 */ ?>,
				showConfirmButton: false,
				timer: 1500
			})
		</script>
<?php
			$iterations++;
		}
?>

	<script>
		$(document).ready(function () {
			$('.under-me').next().hide();
		});
	</script>
</body>
</html>
<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 32');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockCss($_args)
	{
		
	}


	function blockJs($_args)
	{
		
	}

}
