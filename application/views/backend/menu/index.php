<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Menu</h2>
			</div>
			<div class="x_content">
				<!-- END section -->
			    <section id="demo">
			         <ol class="sortable ui-sortable">
			            <li id="list_1" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed">
			               <div><span class="disclose"><span></span></span>Item 1</div>
			               <ol>
			                  <li id="list_2" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed">
			                     <div><span class="disclose"><span></span></span>Sub Item 1.1</div>
			                     <ol>
			                        <li id="list_3" class="mjs-nestedSortable-leaf">
			                           <div><span class="disclose"><span></span></span>Sub Item 1.2</div>
			                        </li>
			                     </ol>
			                  </li>
			               </ol>
			            </li>
			            <li id="list_4" class="mjs-nestedSortable-leaf">
			               <div><span class="disclose"><span></span></span>Item 2</div>
			            </li>
			            <li id="list_5" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed">
			               <div>
								<span class="disclose"><span></span></span>
								Item 3
						   </div>
			               <ol>
			                  <li id="list_6" class="mjs-nestedSortable-no-nesting mjs-nestedSortable-leaf">
			                     <div><span class="disclose"><span></span></span>Sub Item 3.1 (no nesting)</div>
			                  </li>
			                  <li id="list_7" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed">
			                     <div><span class="disclose"><span></span></span>Sub Item 3.2</div>
			                     <ol>
			                        <li id="list_8" class="mjs-nestedSortable-leaf">
			                           <div><span class="disclose"><span></span></span>Sub Item 3.2.1</div>
			                        </li>
			                     </ol>
			                  </li>
			               </ol>
			            </li>
			            <li id="list_9" class="mjs-nestedSortable-leaf">
			               <div><span class="disclose"><span></span></span>Item 4</div>
			            </li>
			            <li id="list_10" class="mjs-nestedSortable-leaf">
			               <div><span class="disclose"><span></span></span>Item 5</div>
			            </li>
			         </ol>
			    </section>
			    <!-- END #demo -->
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>skins/menu/css/style.css">
<script type="text/javascript" src="<?php echo base_url(); ?>skins/menu/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>skins/menu/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>skins/menu/js/jquery.ui.touch-punch.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>skins/menu/js/jquery.mjs.nestedSortable.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).ready(function(){
         	$('ol.sortable').nestedSortable({
         		forcePlaceholderSize: true,
         		handle: 'div',
         		helper:	'clone',
         		items: 'li',
         		opacity: .6,
         		placeholder: 'placeholder',
         		revert: 250,
         		tabSize: 25,
         		tolerance: 'pointer',
         		toleranceElement: '> div',
         		maxLevels: 3,
         		isTree: true,
         		expandOnHover: 700,
         		startCollapsed: true
         	});

         	$('.disclose').on('click', function() {
         		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
         	});

         	$('#serialize').click(function(){
         		serialized = $('ol.sortable').nestedSortable('serialize');
         		$('#serializeOutput').text(serialized+'\n\n');
         	})
         
         	$('#toHierarchy').click(function(e){
         		hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
         		hiered = dump(hiered);
         		(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
         		$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
         	})
         
         	$('#toArray').click(function(e){
         		arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
         		arraied = dump(arraied);
         		(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
         		$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
         	})
         
         });
         
         function dump(arr,level) {
         	var dumped_text = "";
         	if(!level) level = 0;
         
         	//The padding given at the beginning of the line.
         	var level_padding = "";
         	for(var j=0;j<level+1;j++) level_padding += "    ";
         
         	if(typeof(arr) == 'object') { //Array/Hashes/Objects
         		for(var item in arr) {
         			var value = arr[item];
         
         			if(typeof(value) == 'object') { //If it is an array,
         				dumped_text += level_padding + "'" + item + "' ...\n";
         				dumped_text += dump(value,level+1);
         			} else {
         				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
         			}
         		}
         	} else { //Strings/Chars/Numbers etc.
         		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
         	}
         	return dumped_text;
         }
	});
</script>