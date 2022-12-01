<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Add new system functions</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
			    <?php if(@$this->input->get("create") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Add new successful!</strong> You can update the data here
					</div>
				<?php endif;?>
				<?php if(@$this->input->get("edit") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Update successful!</strong> You can update the data here
					</div>
				<?php endif;?>
				<?php if(@$this->input->get("delete") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Delete successful!</strong>
					</div>
				<?php endif;?>
				<?php if(@$post["status"] == "error"):?>
				    <div class="alert alert-danger fade in alert-dismissable">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Error updates!</strong> Please check the input data
					    <?php echo @$post["error"];?>
					</div>
				<?php endif;?>
				<form class="form-horizontal form-label-left" method="post">
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name System <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Module_Name" class="form-control col-md-7 col-xs-12" name="Module_Name" placeholder="Name System" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Module_Key">Identifier System<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Module_Key" class="form-control col-md-7 col-xs-12" name="Module_Key" placeholder="Identifier System" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Module_Url">Path<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Module_Url" class="form-control col-md-7 col-xs-12" name="Module_Url" placeholder="Path" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Parent_ID">Select the parent system</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Parent_ID" class="form-control col-md-7 col-xs-12" name="Parent_ID">
							    <option value="0">&mdash; &mdash; Select the parent system &mdash; &mdash;</option>
								<?php echo @$option_modules;?>
							</select>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Order">Order</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Order" class="form-control col-md-7 col-xs-12" name="Order" placeholder="Order" type="number"> </div>
					</div>	
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Icon">Icon display</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Icon" class="form-control col-md-7 col-xs-12" name="Icon" placeholder="Icon display" type="text" readonly> 
						<div class="list-box-icon">
								<section id="web-application">
									<div class="row fontawesome-icon-list">
										<div class="fa-hover col-md-6"><a href="#/adjust"><i class="fa fa-adjust"></i> fa-adjust</a> </div>
										<div class="fa-hover col-md-6"><a href="#/anchor"><i class="fa fa-anchor"></i> fa-anchor</a> </div>
										<div class="fa-hover col-md-6"><a href="#/archive"><i class="fa fa-archive"></i> fa-archive</a> </div>
										<div class="fa-hover col-md-6"><a href="#/area-chart"><i class="fa fa-area-chart"></i> fa-area-chart</a> </div>
										<div class="fa-hover col-md-6"><a href="#/arrows"><i class="fa fa-arrows"></i> fa-arrows</a> </div>
										<div class="fa-hover col-md-6"><a href="#/arrows-h"><i class="fa fa-arrows-h"></i> fa-arrows-h</a> </div>
										<div class="fa-hover col-md-6"><a href="#/arrows-v"><i class="fa fa-arrows-v"></i> fa-arrows-v</a> </div>
										<div class="fa-hover col-md-6"><a href="#/asterisk"><i class="fa fa-asterisk"></i> fa-asterisk</a> </div>
										<div class="fa-hover col-md-6"><a href="#/at"><i class="fa fa-at"></i> fa-at</a> </div>
										<div class="fa-hover col-md-6"><a href="#/car"><i class="fa fa-automobile"></i> fa-automobile <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/ban"><i class="fa fa-ban"></i> fa-ban</a> </div>
										<div class="fa-hover col-md-6"><a href="#/university"><i class="fa fa-bank"></i> fa-bank <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/bar-chart"><i class="fa fa-bar-chart"></i> fa-bar-chart</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bar-chart"><i class="fa fa-bar-chart-o"></i> fa-bar-chart-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/barcode"><i class="fa fa-barcode"></i> fa-barcode</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bars"><i class="fa fa-bars"></i> fa-bars</a> </div>
										<div class="fa-hover col-md-6"><a href="#/beer"><i class="fa fa-beer"></i> fa-beer</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bell"><i class="fa fa-bell"></i> fa-bell</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bell-o"><i class="fa fa-bell-o"></i> fa-bell-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bell-slash"><i class="fa fa-bell-slash"></i> fa-bell-slash</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bell-slash-o"><i class="fa fa-bell-slash-o"></i> fa-bell-slash-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bicycle"><i class="fa fa-bicycle"></i> fa-bicycle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/binoculars"><i class="fa fa-binoculars"></i> fa-binoculars</a> </div>
										<div class="fa-hover col-md-6"><a href="#/birthday-cake"><i class="fa fa-birthday-cake"></i> fa-birthday-cake</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bolt"><i class="fa fa-bolt"></i> fa-bolt</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bomb"><i class="fa fa-bomb"></i> fa-bomb</a> </div>
										<div class="fa-hover col-md-6"><a href="#/book"><i class="fa fa-book"></i> fa-book</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bookmark"><i class="fa fa-bookmark"></i> fa-bookmark</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bookmark-o"><i class="fa fa-bookmark-o"></i> fa-bookmark-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/briefcase"><i class="fa fa-briefcase"></i> fa-briefcase</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bug"><i class="fa fa-bug"></i> fa-bug</a> </div>
										<div class="fa-hover col-md-6"><a href="#/building"><i class="fa fa-building"></i> fa-building</a> </div>
										<div class="fa-hover col-md-6"><a href="#/building-o"><i class="fa fa-building-o"></i> fa-building-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bullhorn"><i class="fa fa-bullhorn"></i> fa-bullhorn</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bullseye"><i class="fa fa-bullseye"></i> fa-bullseye</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bus"><i class="fa fa-bus"></i> fa-bus</a> </div>
										<div class="fa-hover col-md-6"><a href="#/taxi"><i class="fa fa-cab"></i> fa-cab <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/calculator"><i class="fa fa-calculator"></i> fa-calculator</a> </div>
										<div class="fa-hover col-md-6"><a href="#/calendar"><i class="fa fa-calendar"></i> fa-calendar</a> </div>
										<div class="fa-hover col-md-6"><a href="#/calendar-o"><i class="fa fa-calendar-o"></i> fa-calendar-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/camera"><i class="fa fa-camera"></i> fa-camera</a> </div>
										<div class="fa-hover col-md-6"><a href="#/camera-retro"><i class="fa fa-camera-retro"></i> fa-camera-retro</a> </div>
										<div class="fa-hover col-md-6"><a href="#/car"><i class="fa fa-car"></i> fa-car</a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-down"><i class="fa fa-caret-square-o-down"></i> fa-caret-square-o-down</a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-left"><i class="fa fa-caret-square-o-left"></i> fa-caret-square-o-left</a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-right"><i class="fa fa-caret-square-o-right"></i> fa-caret-square-o-right</a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-up"><i class="fa fa-caret-square-o-up"></i> fa-caret-square-o-up</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cc"><i class="fa fa-cc"></i> fa-cc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/certificate"><i class="fa fa-certificate"></i> fa-certificate</a> </div>
										<div class="fa-hover col-md-6"><a href="#/check"><i class="fa fa-check"></i> fa-check</a> </div>
										<div class="fa-hover col-md-6"><a href="#/check-circle"><i class="fa fa-check-circle"></i> fa-check-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/check-circle-o"><i class="fa fa-check-circle-o"></i> fa-check-circle-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/check-square"><i class="fa fa-check-square"></i> fa-check-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/check-square-o"><i class="fa fa-check-square-o"></i> fa-check-square-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/child"><i class="fa fa-child"></i> fa-child</a> </div>
										<div class="fa-hover col-md-6"><a href="#/circle"><i class="fa fa-circle"></i> fa-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/circle-o"><i class="fa fa-circle-o"></i> fa-circle-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/circle-o-notch"><i class="fa fa-circle-o-notch"></i> fa-circle-o-notch</a> </div>
										<div class="fa-hover col-md-6"><a href="#/circle-thin"><i class="fa fa-circle-thin"></i> fa-circle-thin</a> </div>
										<div class="fa-hover col-md-6"><a href="#/clock-o"><i class="fa fa-clock-o"></i> fa-clock-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/times"><i class="fa fa-close"></i> fa-close <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/cloud"><i class="fa fa-cloud"></i> fa-cloud</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cloud-download"><i class="fa fa-cloud-download"></i> fa-cloud-download</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cloud-upload"><i class="fa fa-cloud-upload"></i> fa-cloud-upload</a> </div>
										<div class="fa-hover col-md-6"><a href="#/code"><i class="fa fa-code"></i> fa-code</a> </div>
										<div class="fa-hover col-md-6"><a href="#/code-fork"><i class="fa fa-code-fork"></i> fa-code-fork</a> </div>
										<div class="fa-hover col-md-6"><a href="#/coffee"><i class="fa fa-coffee"></i> fa-coffee</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cog"><i class="fa fa-cog"></i> fa-cog</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cogs"><i class="fa fa-cogs"></i> fa-cogs</a> </div>
										<div class="fa-hover col-md-6"><a href="#/comment"><i class="fa fa-comment"></i> fa-comment</a> </div>
										<div class="fa-hover col-md-6"><a href="#/comment-o"><i class="fa fa-comment-o"></i> fa-comment-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/comments"><i class="fa fa-comments"></i> fa-comments</a> </div>
										<div class="fa-hover col-md-6"><a href="#/comments-o"><i class="fa fa-comments-o"></i> fa-comments-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/compass"><i class="fa fa-compass"></i> fa-compass</a> </div>
										<div class="fa-hover col-md-6"><a href="#/copyright"><i class="fa fa-copyright"></i> fa-copyright</a> </div>
										<div class="fa-hover col-md-6"><a href="#/credit-card"><i class="fa fa-credit-card"></i> fa-credit-card</a> </div>
										<div class="fa-hover col-md-6"><a href="#/crop"><i class="fa fa-crop"></i> fa-crop</a> </div>
										<div class="fa-hover col-md-6"><a href="#/crosshairs"><i class="fa fa-crosshairs"></i> fa-crosshairs</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cube"><i class="fa fa-cube"></i> fa-cube</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cubes"><i class="fa fa-cubes"></i> fa-cubes</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cutlery"><i class="fa fa-cutlery"></i> fa-cutlery</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tachometer"><i class="fa fa-dashboard"></i> fa-dashboard <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/database"><i class="fa fa-database"></i> fa-database</a> </div>
										<div class="fa-hover col-md-6"><a href="#/desktop"><i class="fa fa-desktop"></i> fa-desktop</a> </div>
										<div class="fa-hover col-md-6"><a href="#/dot-circle-o"><i class="fa fa-dot-circle-o"></i> fa-dot-circle-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/download"><i class="fa fa-download"></i> fa-download</a> </div>
										<div class="fa-hover col-md-6"><a href="#/pencil-square-o"><i class="fa fa-edit"></i> fa-edit <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/ellipsis-h"><i class="fa fa-ellipsis-h"></i> fa-ellipsis-h</a> </div>
										<div class="fa-hover col-md-6"><a href="#/ellipsis-v"><i class="fa fa-ellipsis-v"></i> fa-ellipsis-v</a> </div>
										<div class="fa-hover col-md-6"><a href="#/envelope"><i class="fa fa-envelope"></i> fa-envelope</a> </div>
										<div class="fa-hover col-md-6"><a href="#/envelope-o"><i class="fa fa-envelope-o"></i> fa-envelope-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/envelope-square"><i class="fa fa-envelope-square"></i> fa-envelope-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/eraser"><i class="fa fa-eraser"></i> fa-eraser</a> </div>
										<div class="fa-hover col-md-6"><a href="#/exchange"><i class="fa fa-exchange"></i> fa-exchange</a> </div>
										<div class="fa-hover col-md-6"><a href="#/exclamation"><i class="fa fa-exclamation"></i> fa-exclamation</a> </div>
										<div class="fa-hover col-md-6"><a href="#/exclamation-circle"><i class="fa fa-exclamation-circle"></i> fa-exclamation-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/exclamation-triangle"><i class="fa fa-exclamation-triangle"></i> fa-exclamation-triangle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/external-link"><i class="fa fa-external-link"></i> fa-external-link</a> </div>
										<div class="fa-hover col-md-6"><a href="#/external-link-square"><i class="fa fa-external-link-square"></i> fa-external-link-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/eye"><i class="fa fa-eye"></i> fa-eye</a> </div>
										<div class="fa-hover col-md-6"><a href="#/eye-slash"><i class="fa fa-eye-slash"></i> fa-eye-slash</a> </div>
										<div class="fa-hover col-md-6"><a href="#/eyedropper"><i class="fa fa-eyedropper"></i> fa-eyedropper</a> </div>
										<div class="fa-hover col-md-6"><a href="#/fax"><i class="fa fa-fax"></i> fa-fax</a> </div>
										<div class="fa-hover col-md-6"><a href="#/female"><i class="fa fa-female"></i> fa-female</a> </div>
										<div class="fa-hover col-md-6"><a href="#/fighter-jet"><i class="fa fa-fighter-jet"></i> fa-fighter-jet</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-archive-o"><i class="fa fa-file-archive-o"></i> fa-file-archive-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-audio-o"><i class="fa fa-file-audio-o"></i> fa-file-audio-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-code-o"><i class="fa fa-file-code-o"></i> fa-file-code-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-excel-o"><i class="fa fa-file-excel-o"></i> fa-file-excel-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-image-o"><i class="fa fa-file-image-o"></i> fa-file-image-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-video-o"><i class="fa fa-file-movie-o"></i> fa-file-movie-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-pdf-o"><i class="fa fa-file-pdf-o"></i> fa-file-pdf-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-image-o"><i class="fa fa-file-photo-o"></i> fa-file-photo-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-image-o"><i class="fa fa-file-picture-o"></i> fa-file-picture-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-powerpoint-o"><i class="fa fa-file-powerpoint-o"></i> fa-file-powerpoint-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-audio-o"><i class="fa fa-file-sound-o"></i> fa-file-sound-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-video-o"><i class="fa fa-file-video-o"></i> fa-file-video-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-word-o"><i class="fa fa-file-word-o"></i> fa-file-word-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/file-archive-o"><i class="fa fa-file-zip-o"></i> fa-file-zip-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/film"><i class="fa fa-film"></i> fa-film</a> </div>
										<div class="fa-hover col-md-6"><a href="#/filter"><i class="fa fa-filter"></i> fa-filter</a> </div>
										<div class="fa-hover col-md-6"><a href="#/fire"><i class="fa fa-fire"></i> fa-fire</a> </div>
										<div class="fa-hover col-md-6"><a href="#/fire-extinguisher"><i class="fa fa-fire-extinguisher"></i> fa-fire-extinguisher</a> </div>
										<div class="fa-hover col-md-6"><a href="#/flag"><i class="fa fa-flag"></i> fa-flag</a> </div>
										<div class="fa-hover col-md-6"><a href="#/flag-checkered"><i class="fa fa-flag-checkered"></i> fa-flag-checkered</a> </div>
										<div class="fa-hover col-md-6"><a href="#/flag-o"><i class="fa fa-flag-o"></i> fa-flag-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bolt"><i class="fa fa-flash"></i> fa-flash <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/flask"><i class="fa fa-flask"></i> fa-flask</a> </div>
										<div class="fa-hover col-md-6"><a href="#/folder"><i class="fa fa-folder"></i> fa-folder</a> </div>
										<div class="fa-hover col-md-6"><a href="#/folder-o"><i class="fa fa-folder-o"></i> fa-folder-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/folder-open"><i class="fa fa-folder-open"></i> fa-folder-open</a> </div>
										<div class="fa-hover col-md-6"><a href="#/folder-open-o"><i class="fa fa-folder-open-o"></i> fa-folder-open-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/frown-o"><i class="fa fa-frown-o"></i> fa-frown-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/futbol-o"><i class="fa fa-futbol-o"></i> fa-futbol-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/gamepad"><i class="fa fa-gamepad"></i> fa-gamepad</a> </div>
										<div class="fa-hover col-md-6"><a href="#/gavel"><i class="fa fa-gavel"></i> fa-gavel</a> </div>
										<div class="fa-hover col-md-6"><a href="#/cog"><i class="fa fa-gear"></i> fa-gear <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/cogs"><i class="fa fa-gears"></i> fa-gears <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/gift"><i class="fa fa-gift"></i> fa-gift</a> </div>
										<div class="fa-hover col-md-6"><a href="#/glass"><i class="fa fa-glass"></i> fa-glass</a> </div>
										<div class="fa-hover col-md-6"><a href="#/globe"><i class="fa fa-globe"></i> fa-globe</a> </div>
										<div class="fa-hover col-md-6"><a href="#/graduation-cap"><i class="fa fa-graduation-cap"></i> fa-graduation-cap</a> </div>
										<div class="fa-hover col-md-6"><a href="#/users"><i class="fa fa-group"></i> fa-group <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/hdd-o"><i class="fa fa-hdd-o"></i> fa-hdd-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/headphones"><i class="fa fa-headphones"></i> fa-headphones</a> </div>
										<div class="fa-hover col-md-6"><a href="#/heart"><i class="fa fa-heart"></i> fa-heart</a> </div>
										<div class="fa-hover col-md-6"><a href="#/heart-o"><i class="fa fa-heart-o"></i> fa-heart-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/history"><i class="fa fa-history"></i> fa-history</a> </div>
										<div class="fa-hover col-md-6"><a href="#/home"><i class="fa fa-home"></i> fa-home</a> </div>
										<div class="fa-hover col-md-6"><a href="#/picture-o"><i class="fa fa-image"></i> fa-image <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/inbox"><i class="fa fa-inbox"></i> fa-inbox</a> </div>
										<div class="fa-hover col-md-6"><a href="#/info"><i class="fa fa-info"></i> fa-info</a> </div>
										<div class="fa-hover col-md-6"><a href="#/info-circle"><i class="fa fa-info-circle"></i> fa-info-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/university"><i class="fa fa-institution"></i> fa-institution <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/key"><i class="fa fa-key"></i> fa-key</a> </div>
										<div class="fa-hover col-md-6"><a href="#/keyboard-o"><i class="fa fa-keyboard-o"></i> fa-keyboard-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/language"><i class="fa fa-language"></i> fa-language</a> </div>
										<div class="fa-hover col-md-6"><a href="#/laptop"><i class="fa fa-laptop"></i> fa-laptop</a> </div>
										<div class="fa-hover col-md-6"><a href="#/leaf"><i class="fa fa-leaf"></i> fa-leaf</a> </div>
										<div class="fa-hover col-md-6"><a href="#/gavel"><i class="fa fa-legal"></i> fa-legal <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/lemon-o"><i class="fa fa-lemon-o"></i> fa-lemon-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/level-down"><i class="fa fa-level-down"></i> fa-level-down</a> </div>
										<div class="fa-hover col-md-6"><a href="#/level-up"><i class="fa fa-level-up"></i> fa-level-up</a> </div>
										<div class="fa-hover col-md-6"><a href="#/life-ring"><i class="fa fa-life-bouy"></i> fa-life-bouy <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/life-ring"><i class="fa fa-life-buoy"></i> fa-life-buoy <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/life-ring"><i class="fa fa-life-ring"></i> fa-life-ring</a> </div>
										<div class="fa-hover col-md-6"><a href="#/life-ring"><i class="fa fa-life-saver"></i> fa-life-saver <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/lightbulb-o"><i class="fa fa-lightbulb-o"></i> fa-lightbulb-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/line-chart"><i class="fa fa-line-chart"></i> fa-line-chart</a> </div>
										<div class="fa-hover col-md-6"><a href="#/location-arrow"><i class="fa fa-location-arrow"></i> fa-location-arrow</a> </div>
										<div class="fa-hover col-md-6"><a href="#/lock"><i class="fa fa-lock"></i> fa-lock</a> </div>
										<div class="fa-hover col-md-6"><a href="#/magic"><i class="fa fa-magic"></i> fa-magic</a> </div>
										<div class="fa-hover col-md-6"><a href="#/magnet"><i class="fa fa-magnet"></i> fa-magnet</a> </div>
										<div class="fa-hover col-md-6"><a href="#/share"><i class="fa fa-mail-forward"></i> fa-mail-forward <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/reply"><i class="fa fa-mail-reply"></i> fa-mail-reply <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/reply-all"><i class="fa fa-mail-reply-all"></i> fa-mail-reply-all <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/male"><i class="fa fa-male"></i> fa-male</a> </div>
										<div class="fa-hover col-md-6"><a href="#/map-marker"><i class="fa fa-map-marker"></i> fa-map-marker</a> </div>
										<div class="fa-hover col-md-6"><a href="#/meh-o"><i class="fa fa-meh-o"></i> fa-meh-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/microphone"><i class="fa fa-microphone"></i> fa-microphone</a> </div>
										<div class="fa-hover col-md-6"><a href="#/microphone-slash"><i class="fa fa-microphone-slash"></i> fa-microphone-slash</a> </div>
										<div class="fa-hover col-md-6"><a href="#/minus"><i class="fa fa-minus"></i> fa-minus</a> </div>
										<div class="fa-hover col-md-6"><a href="#/minus-circle"><i class="fa fa-minus-circle"></i> fa-minus-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/minus-square"><i class="fa fa-minus-square"></i> fa-minus-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/minus-square-o"><i class="fa fa-minus-square-o"></i> fa-minus-square-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/mobile"><i class="fa fa-mobile"></i> fa-mobile</a> </div>
										<div class="fa-hover col-md-6"><a href="#/mobile"><i class="fa fa-mobile-phone"></i> fa-mobile-phone <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/money"><i class="fa fa-money"></i> fa-money</a> </div>
										<div class="fa-hover col-md-6"><a href="#/moon-o"><i class="fa fa-moon-o"></i> fa-moon-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/graduation-cap"><i class="fa fa-mortar-board"></i> fa-mortar-board <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/music"><i class="fa fa-music"></i> fa-music</a> </div>
										<div class="fa-hover col-md-6"><a href="#/bars"><i class="fa fa-navicon"></i> fa-navicon <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/newspaper-o"><i class="fa fa-newspaper-o"></i> fa-newspaper-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/paint-brush"><i class="fa fa-paint-brush"></i> fa-paint-brush</a> </div>
										<div class="fa-hover col-md-6"><a href="#/paper-plane"><i class="fa fa-paper-plane"></i> fa-paper-plane</a> </div>
										<div class="fa-hover col-md-6"><a href="#/paper-plane-o"><i class="fa fa-paper-plane-o"></i> fa-paper-plane-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/paw"><i class="fa fa-paw"></i> fa-paw</a> </div>
										<div class="fa-hover col-md-6"><a href="#/pencil"><i class="fa fa-pencil"></i> fa-pencil</a> </div>
										<div class="fa-hover col-md-6"><a href="#/pencil-square"><i class="fa fa-pencil-square"></i> fa-pencil-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/pencil-square-o"><i class="fa fa-pencil-square-o"></i> fa-pencil-square-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/phone"><i class="fa fa-phone"></i> fa-phone</a> </div>
										<div class="fa-hover col-md-6"><a href="#/phone-square"><i class="fa fa-phone-square"></i> fa-phone-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/picture-o"><i class="fa fa-photo"></i> fa-photo <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/picture-o"><i class="fa fa-picture-o"></i> fa-picture-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/pie-chart"><i class="fa fa-pie-chart"></i> fa-pie-chart</a> </div>
										<div class="fa-hover col-md-6"><a href="#/plane"><i class="fa fa-plane"></i> fa-plane</a> </div>
										<div class="fa-hover col-md-6"><a href="#/plug"><i class="fa fa-plug"></i> fa-plug</a> </div>
										<div class="fa-hover col-md-6"><a href="#/plus"><i class="fa fa-plus"></i> fa-plus</a> </div>
										<div class="fa-hover col-md-6"><a href="#/plus-circle"><i class="fa fa-plus-circle"></i> fa-plus-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/plus-square"><i class="fa fa-plus-square"></i> fa-plus-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/plus-square-o"><i class="fa fa-plus-square-o"></i> fa-plus-square-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/power-off"><i class="fa fa-power-off"></i> fa-power-off</a> </div>
										<div class="fa-hover col-md-6"><a href="#/print"><i class="fa fa-print"></i> fa-print</a> </div>
										<div class="fa-hover col-md-6"><a href="#/puzzle-piece"><i class="fa fa-puzzle-piece"></i> fa-puzzle-piece</a> </div>
										<div class="fa-hover col-md-6"><a href="#/qrcode"><i class="fa fa-qrcode"></i> fa-qrcode</a> </div>
										<div class="fa-hover col-md-6"><a href="#/question"><i class="fa fa-question"></i> fa-question</a> </div>
										<div class="fa-hover col-md-6"><a href="#/question-circle"><i class="fa fa-question-circle"></i> fa-question-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/quote-left"><i class="fa fa-quote-left"></i> fa-quote-left</a> </div>
										<div class="fa-hover col-md-6"><a href="#/quote-right"><i class="fa fa-quote-right"></i> fa-quote-right</a> </div>
										<div class="fa-hover col-md-6"><a href="#/random"><i class="fa fa-random"></i> fa-random</a> </div>
										<div class="fa-hover col-md-6"><a href="#/recycle"><i class="fa fa-recycle"></i> fa-recycle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/refresh"><i class="fa fa-refresh"></i> fa-refresh</a> </div>
										<div class="fa-hover col-md-6"><a href="#/times"><i class="fa fa-remove"></i> fa-remove <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/bars"><i class="fa fa-reorder"></i> fa-reorder <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/reply"><i class="fa fa-reply"></i> fa-reply</a> </div>
										<div class="fa-hover col-md-6"><a href="#/reply-all"><i class="fa fa-reply-all"></i> fa-reply-all</a> </div>
										<div class="fa-hover col-md-6"><a href="#/retweet"><i class="fa fa-retweet"></i> fa-retweet</a> </div>
										<div class="fa-hover col-md-6"><a href="#/road"><i class="fa fa-road"></i> fa-road</a> </div>
										<div class="fa-hover col-md-6"><a href="#/rocket"><i class="fa fa-rocket"></i> fa-rocket</a> </div>
										<div class="fa-hover col-md-6"><a href="#/rss"><i class="fa fa-rss"></i> fa-rss</a> </div>
										<div class="fa-hover col-md-6"><a href="#/rss-square"><i class="fa fa-rss-square"></i> fa-rss-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/search"><i class="fa fa-search"></i> fa-search</a> </div>
										<div class="fa-hover col-md-6"><a href="#/search-minus"><i class="fa fa-search-minus"></i> fa-search-minus</a> </div>
										<div class="fa-hover col-md-6"><a href="#/search-plus"><i class="fa fa-search-plus"></i> fa-search-plus</a> </div>
										<div class="fa-hover col-md-6"><a href="#/paper-plane"><i class="fa fa-send"></i> fa-send <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/paper-plane-o"><i class="fa fa-send-o"></i> fa-send-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/share"><i class="fa fa-share"></i> fa-share</a> </div>
										<div class="fa-hover col-md-6"><a href="#/share-alt"><i class="fa fa-share-alt"></i> fa-share-alt</a> </div>
										<div class="fa-hover col-md-6"><a href="#/share-alt-square"><i class="fa fa-share-alt-square"></i> fa-share-alt-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/share-square"><i class="fa fa-share-square"></i> fa-share-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/share-square-o"><i class="fa fa-share-square-o"></i> fa-share-square-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/shield"><i class="fa fa-shield"></i> fa-shield</a> </div>
										<div class="fa-hover col-md-6"><a href="#/shopping-cart"><i class="fa fa-shopping-cart"></i> fa-shopping-cart</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sign-in"><i class="fa fa-sign-in"></i> fa-sign-in</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sign-out"><i class="fa fa-sign-out"></i> fa-sign-out</a> </div>
										<div class="fa-hover col-md-6"><a href="#/signal"><i class="fa fa-signal"></i> fa-signal</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sitemap"><i class="fa fa-sitemap"></i> fa-sitemap</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sliders"><i class="fa fa-sliders"></i> fa-sliders</a> </div>
										<div class="fa-hover col-md-6"><a href="#/smile-o"><i class="fa fa-smile-o"></i> fa-smile-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/futbol-o"><i class="fa fa-soccer-ball-o"></i> fa-soccer-ball-o <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort"><i class="fa fa-sort"></i> fa-sort</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-alpha-asc"><i class="fa fa-sort-alpha-asc"></i> fa-sort-alpha-asc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-alpha-desc"><i class="fa fa-sort-alpha-desc"></i> fa-sort-alpha-desc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-amount-asc"><i class="fa fa-sort-amount-asc"></i> fa-sort-amount-asc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-amount-desc"><i class="fa fa-sort-amount-desc"></i> fa-sort-amount-desc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-asc"><i class="fa fa-sort-asc"></i> fa-sort-asc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-desc"><i class="fa fa-sort-desc"></i> fa-sort-desc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-desc"><i class="fa fa-sort-down"></i> fa-sort-down <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-numeric-asc"><i class="fa fa-sort-numeric-asc"></i> fa-sort-numeric-asc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-numeric-desc"><i class="fa fa-sort-numeric-desc"></i> fa-sort-numeric-desc</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort-asc"><i class="fa fa-sort-up"></i> fa-sort-up <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/space-shuttle"><i class="fa fa-space-shuttle"></i> fa-space-shuttle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/spinner"><i class="fa fa-spinner"></i> fa-spinner</a> </div>
										<div class="fa-hover col-md-6"><a href="#/spoon"><i class="fa fa-spoon"></i> fa-spoon</a> </div>
										<div class="fa-hover col-md-6"><a href="#/square"><i class="fa fa-square"></i> fa-square</a> </div>
										<div class="fa-hover col-md-6"><a href="#/square-o"><i class="fa fa-square-o"></i> fa-square-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/star"><i class="fa fa-star"></i> fa-star</a> </div>
										<div class="fa-hover col-md-6"><a href="#/star-half"><i class="fa fa-star-half"></i> fa-star-half</a> </div>
										<div class="fa-hover col-md-6"><a href="#/star-half-o"><i class="fa fa-star-half-empty"></i> fa-star-half-empty <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/star-half-o"><i class="fa fa-star-half-full"></i> fa-star-half-full <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/star-half-o"><i class="fa fa-star-half-o"></i> fa-star-half-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/star-o"><i class="fa fa-star-o"></i> fa-star-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/suitcase"><i class="fa fa-suitcase"></i> fa-suitcase</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sun-o"><i class="fa fa-sun-o"></i> fa-sun-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/life-ring"><i class="fa fa-support"></i> fa-support <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/tablet"><i class="fa fa-tablet"></i> fa-tablet</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tachometer"><i class="fa fa-tachometer"></i> fa-tachometer</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tag"><i class="fa fa-tag"></i> fa-tag</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tags"><i class="fa fa-tags"></i> fa-tags</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tasks"><i class="fa fa-tasks"></i> fa-tasks</a> </div>
										<div class="fa-hover col-md-6"><a href="#/taxi"><i class="fa fa-taxi"></i> fa-taxi</a> </div>
										<div class="fa-hover col-md-6"><a href="#/terminal"><i class="fa fa-terminal"></i> fa-terminal</a> </div>
										<div class="fa-hover col-md-6"><a href="#/thumb-tack"><i class="fa fa-thumb-tack"></i> fa-thumb-tack</a> </div>
										<div class="fa-hover col-md-6"><a href="#/thumbs-down"><i class="fa fa-thumbs-down"></i> fa-thumbs-down</a> </div>
										<div class="fa-hover col-md-6"><a href="#/thumbs-o-down"><i class="fa fa-thumbs-o-down"></i> fa-thumbs-o-down</a> </div>
										<div class="fa-hover col-md-6"><a href="#/thumbs-o-up"><i class="fa fa-thumbs-o-up"></i> fa-thumbs-o-up</a> </div>
										<div class="fa-hover col-md-6"><a href="#/thumbs-up"><i class="fa fa-thumbs-up"></i> fa-thumbs-up</a> </div>
										<div class="fa-hover col-md-6"><a href="#/ticket"><i class="fa fa-ticket"></i> fa-ticket</a> </div>
										<div class="fa-hover col-md-6"><a href="#/times"><i class="fa fa-times"></i> fa-times</a> </div>
										<div class="fa-hover col-md-6"><a href="#/times-circle"><i class="fa fa-times-circle"></i> fa-times-circle</a> </div>
										<div class="fa-hover col-md-6"><a href="#/times-circle-o"><i class="fa fa-times-circle-o"></i> fa-times-circle-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tint"><i class="fa fa-tint"></i> fa-tint</a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-down"><i class="fa fa-toggle-down"></i> fa-toggle-down <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-left"><i class="fa fa-toggle-left"></i> fa-toggle-left <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/toggle-off"><i class="fa fa-toggle-off"></i> fa-toggle-off</a> </div>
										<div class="fa-hover col-md-6"><a href="#/toggle-on"><i class="fa fa-toggle-on"></i> fa-toggle-on</a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-right"><i class="fa fa-toggle-right"></i> fa-toggle-right <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/caret-square-o-up"><i class="fa fa-toggle-up"></i> fa-toggle-up <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/trash"><i class="fa fa-trash"></i> fa-trash</a> </div>
										<div class="fa-hover col-md-6"><a href="#/trash-o"><i class="fa fa-trash-o"></i> fa-trash-o</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tree"><i class="fa fa-tree"></i> fa-tree</a> </div>
										<div class="fa-hover col-md-6"><a href="#/trophy"><i class="fa fa-trophy"></i> fa-trophy</a> </div>
										<div class="fa-hover col-md-6"><a href="#/truck"><i class="fa fa-truck"></i> fa-truck</a> </div>
										<div class="fa-hover col-md-6"><a href="#/tty"><i class="fa fa-tty"></i> fa-tty</a> </div>
										<div class="fa-hover col-md-6"><a href="#/umbrella"><i class="fa fa-umbrella"></i> fa-umbrella</a> </div>
										<div class="fa-hover col-md-6"><a href="#/university"><i class="fa fa-university"></i> fa-university</a> </div>
										<div class="fa-hover col-md-6"><a href="#/unlock"><i class="fa fa-unlock"></i> fa-unlock</a> </div>
										<div class="fa-hover col-md-6"><a href="#/unlock-alt"><i class="fa fa-unlock-alt"></i> fa-unlock-alt</a> </div>
										<div class="fa-hover col-md-6"><a href="#/sort"><i class="fa fa-unsorted"></i> fa-unsorted <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/upload"><i class="fa fa-upload"></i> fa-upload</a> </div>
										<div class="fa-hover col-md-6"><a href="#/user"><i class="fa fa-user"></i> fa-user</a> </div>
										<div class="fa-hover col-md-6"><a href="#/users"><i class="fa fa-users"></i> fa-users</a> </div>
										<div class="fa-hover col-md-6"><a href="#/video-camera"><i class="fa fa-video-camera"></i> fa-video-camera</a> </div>
										<div class="fa-hover col-md-6"><a href="#/volume-down"><i class="fa fa-volume-down"></i> fa-volume-down</a> </div>
										<div class="fa-hover col-md-6"><a href="#/volume-off"><i class="fa fa-volume-off"></i> fa-volume-off</a> </div>
										<div class="fa-hover col-md-6"><a href="#/volume-up"><i class="fa fa-volume-up"></i> fa-volume-up</a> </div>
										<div class="fa-hover col-md-6"><a href="#/exclamation-triangle"><i class="fa fa-warning"></i> fa-warning <span class="text-muted">(alias)</span></a> </div>
										<div class="fa-hover col-md-6"><a href="#/wheelchair"><i class="fa fa-wheelchair"></i> fa-wheelchair</a> </div>
										<div class="fa-hover col-md-6"><a href="#/wifi"><i class="fa fa-wifi"></i> fa-wifi</a> </div>
										<div class="fa-hover col-md-6"><a href="#/wrench"><i class="fa fa-wrench"></i> fa-wrench</a> </div>
									</div>
								</section>
							</div>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Module_Class">Class custom css</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Module_Class" class="form-control col-md-7 col-xs-12" name="Module_Class" placeholder="Class custom css" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Status<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Status" class="form-control col-md-7 col-xs-12" name="Status">   
						    	<option value="1">Activity</option>
							    <option value="0">Shut down</option>
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url(@$base_controller);?>" class="btn btn-primary">Back</a><button id="send" type="submit" class="btn btn-success">Add new</button> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("click",".list-box-icon .fa-hover a",function(){
		var text = $(this).find("i").attr("class");
		$("input[name='Icon']").val(text);
		return false;
	});
</script>