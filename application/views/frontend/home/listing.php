<?php if (isset($result1) && $result1 != null) : ?>
    <section class="section listing-section section-padding-b-40" id="listing">
        <div class="container">
    		<div class="row">
    			<div class="col-sm-6">
    				<a href="/listing/type/RESIDENTIAL"><h2 class="georgia font-s-24 color-2b2b33">RESIDENTIAL</h2></a>
    			</div>
    			<div class="col-sm-6 text-right">
    				
				</div>
    		</div><br/><br/>
            <div class="row">
                <?php
    			$index_count = 0;
                $index = 0;
                foreach ($result1 as $key => $item): ?>
                    <div class="col-sm-3 col-xs-6">
                        <!-- Item -->
                        <?php $this->load->view("frontend/home/item",['item' => $item]); ?>
                    </div>
                    <?php 
                        $index++;
                		$index_count++;
                        if ($index_count == 8) {
                        	echo '</div><div class="row">';
                    		$this->load->view("frontend/home/subscribe");
                    	}
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section><hr />
<?php endif; ?>
						

<?php if (isset($result2) && $result2 != null) : ?>

    <section class="section listing-section section-padding-b-40" id="listing">

        <div class="container">

    		<div class="row">

    			<div class="col-sm-6">

    				<a href="/listing/type/RESIDENTIAL"><h2 class="georgia font-s-24 color-2b2b33">RESIDENTIAL</h2></a>

    			</div>

    			<div class="col-sm-6 text-right">

    				

				</div>

    		</div><br/><br/>

            <div class="row">

                <?php

    			$index_count = 0;

                $index = 0;

                foreach ($result2 as $key => $item): ?>

                    <div class="col-sm-3 col-xs-6">

                        <!-- Item -->

                        <?php $this->load->view("frontend/home/item",['item' => $item]); ?>

                    </div>

                    <?php 

                        $index++;

                		$index_count++;

                        if ($index_count == 8) {

                        	echo '</div><div class="row">';

                    		$this->load->view("frontend/home/subscribe");

                    	}

                    ?>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

<?php endif; ?>