<?php
// source: /home/ali/www/ospf/app/presenters/templates/Train/default.latte

use Latte\Runtime as LR;

class Template2816582733 extends Latte\Runtime\Template
{
	public $blocks = [
		'css' => 'blockCss',
		'content' => 'blockContent',
		'js' => 'blockJs',
	];

	public $blockTypes = [
		'css' => 'html',
		'content' => 'html',
		'js' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('css', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		$this->renderBlock('js', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['item'])) trigger_error('Variable $item overwritten in foreach on line 45');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockCss($_args)
	{
		extract($_args);
?>
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background-image: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
		}

		h1{
			color: white;;
			font-weight: 400;
			margin-top:  60px;
			text-transform: uppercase;
		}
		h2 {
			color: white;
			position: relative;
			margin-bottom: 40px;
			font-size: 1.5rem;
		}

		table thead tr th{
			color: #ffffff;
			font-weight: 300;
			font-size: 1.7rem;
		}

	</style>
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div class="container">
	<h1>Train Simulation game Leader board</h1>
	<h2>Download & play <a href="">Here (Logisim project)</a></h2>
	<table class="datatable">
		<thead>
		<tr>
			<th>Země</th>
			<th>Uživatel</th>
			<th>Skóre</th>
			<th>Datum</th>
		</tr>
		</thead>
		<tbody>
<?php
		$iterations = 0;
		foreach ($data as $item) {
?>		<tr>
			<th><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->countery_flag)) /* line 46 */ ?>" alt="coutnry flag"></th>
			<th><?php echo LR\Filters::escapeHtmlText($item->user) /* line 47 */ ?></th>
			<th><?php echo LR\Filters::escapeHtmlText($item->score) /* line 48 */ ?></th>
			<th><?php echo LR\Filters::escapeHtmlText($item->date->format('m.d.Y (H:i)')) /* line 49 */ ?></th>
		</tr>
<?php
			$iterations++;
		}
?>
		</tbody>
	</table>
</div>
<?php
	}


	function blockJs($_args)
	{
		extract($_args);
?>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function () {
			$('.datatable').DataTable();
		});
	</script>
<?php
	}

}
