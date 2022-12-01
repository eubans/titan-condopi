<?php if (isset($result) && $result != null) : ?>
    <section class="section listing-section section-padding-b-40" id="listing">
        <div class="container">
    		<div class="row">
    			<div class="col-sm-6"><a href="/listing/type/<?php echo $type;?>"><h2 class="georgia font-s-24 color-2b2b33"><?php echo $type;?></h2></a></div>
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