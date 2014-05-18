<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
		<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>"><?=T('adm_books');?></a>	
				<a href="<?=$pre.$class?>/add" class="plusindent"><img title="<?=T('hint_add');?>" src="<?=PUB;?>img/admadd.png"></a>
			</h1>	
		</td>

		<td>
			<input type="text" class="bigsearch search" id="search" name="search" value="<?=$search;?>">
		</td>

		<td>		
			<div class="searchpic" onclick="doSearch('<?=$path.$class?>')">
			<img src="<?=PUB;?>img/search-white.png">	</div>
		</td>	
</table>

<hr color="lightgray">
	
<? } ?>
	
<?php switch($do){ 
	case 'add': ?>
	<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<br />
	<div id="container">
		<a id="pickfiles" href="javascript:;">[Select files]</a> 
		<a id="uploadfiles" href="javascript:;">[Upload files]</a>
	</div>
	<script type="text/javascript" src="<?=BASE_PATH;?>external/plupload/plupload.full.min.js"></script>
		<script type="text/javascript">
// Custom example logic

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: $('container'), // ... or DOM Element itself
	url : '<?=$pre.$class?>/up',
	flash_swf_url : '<?=BASE_PATH;?>external/plupload/Moxie.swf',
	silverlight_xap_url : '<?=BASE_PATH;?>external/plupload/Moxie.xap',
	chunk_size : '300kb',
	
	filters : {
		max_file_size : '100mb',
		mime_types: [
			{title : "PDF", extensions : "pdf"}
		]
	},

	init: {
		PostInit: function() {
			$('filelist').innerHTML = '';

			$('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				$('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		},

		Error: function(up, err) {
			$('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();

</script>
	<?php	
	break;
 } ?>