<?php if (isset($result) && $result != null) : ?>
    <section class="section listing-section section-padding-b-40" id="listing">
        <div class="container">
    		<div class="row">
    			<div class="col-sm-6"></div>
    			<div class="col-sm-6 text-right">
    				<div class="row">
    					<div class="col-sm-12">View by: 
							<div class="btn-group viewby" role="group" aria-label="Second group">
								<button type="button" data-value="20" class="btn no-border-radius btn-secondary <?php echo @$per_page == 20 ? 'active' : ''; ?>">20</button>
								<button type="button" data-value="50" class="btn btn-secondary no-border-radius <?php echo @$per_page == 50 ? 'active' : ''; ?>">50</button>
								<button type="button" data-value="100" class="btn btn-secondary no-border-radius <?php echo @$per_page == 100 ? 'active' : ''; ?>">100</button>
							</div>
						</div>
					</div>
				</div>
    		</div><br/><br/>
            <div class="row">
                <?php
    			$index_count = 0;
                $index = 0;
                foreach ($result as $key => $item): ?>
                    <div class="col-sm-3 col-xs-6">
                        <!-- Item -->
                        <?php $this->load->view("frontend/home/item",['item' => $item]); ?>
                    </div>
                    <?php 
                        $index++;
                		$index_count++;
                        //if ($index == 4) {
                            //echo '</div><div class="row">';
                        //    $index = 0;
                            if ($index_count == 8) {
                            	echo '</div><div class="row">';
                        		$this->load->view("frontend/home/subscribe");
                        	}
                        //}
                    ?>
                <?php endforeach; ?>
            </div>
            <div class="text-center">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.viewby .btn-secondary').click(function () {
        	if ($(this).hasClass('active')) {
        		return false;
        	}
        	var value = $(this).attr('data-value');
        	var query_string = '';
        	var queries = {};
        	if (document.location.search.indexOf('&') > -1) {
				$.each(document.location.search.substr(1).split('&'),function(c,q){
					var i = q.split('=');
					if (i[0] != 'q' && i[0] != 'per_page') {
						query_string = query_string + '&' + i[0] + '=' + i[1];
					}
				});
			}
			query_string = '?q=true&per_page=' + value + query_string;
			window.location.href = query_string;
        });
    });
</script>