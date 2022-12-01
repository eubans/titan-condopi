<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">Web Setting</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <?php if(@$Setting){
                            foreach ($Setting as $key => $value) {
                            	if ($value["IKEY"] == "BODY_JSON") {
                            		$Body_Json = json_decode($value['Body_Json'], true);
                            		foreach ($Body_Json as $body_key => $body_item) {
                            			echo '
	                                        <div class="form-group">
	                                            <label for="user_first_name" class="col-sm-3 control-label">'.$body_key.'</label>
	                                            <div class="col-sm-9">
	                                                <textarea style="height: 150px;" class="form-control" name="Body_Json['.$body_key.']">'.trim($body_item).'</textarea>
	                                            </div>
	                                        </div>
	                                    ';
                            		}
                            		echo '<hr/>';
                            	} else {
	                               	if($value["IKEY"] != "Escrow" && $value["IKEY"] != "Title"){
	                                    $type = ($value["IKEY"] != "Email" && $value["IKEY"] != "email") ? 'text' : 'email';
	                                    echo '
	                                        <div class="form-group">
	                                            <label for="user_first_name" class="col-sm-3 control-label">'.$value["Title"].'</label>
	                                            <div class="col-sm-9">
	                                                <input type="'.$type.'" class="form-control" name="'.$value["IKEY"].'" value="'.trim($value["Body_Json"]).'">
	                                            </div>
	                                        </div>
	                                    ';
	                               	} else {
	                                    echo '
	                                        <div class="form-group">
	                                            <label for="user_first_name" class="col-sm-3 control-label">'.$value["Title"].'</label>
	                                            <div class="col-sm-9">
	                                                <textarea style="height: 150px;" class="form-control" name="'.$value["IKEY"].'">'.trim($value["Body_Json"]).'</textarea>
	                                            </div>
	                                        </div>
	                                    ';
	                               	}
	                            }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-md btn-secondary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>