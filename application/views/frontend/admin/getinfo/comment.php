<div class="table-responsive">
    <table class="table ">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($collections) && $collections != null) : ?>
                <?php foreach ($collections as $key => $item): ?>  
                    <tr>
                        <td><?php echo $key+1; ?></td>
    					<td><?php echo date('m/d/Y', strtotime($item['Created_At'])); ?></td>
    					<td>
    						<?php echo ((empty($item['Price']) || $item['Price'] == 0) ? '' : 'My Value $'.number_format($item['Price']). '<br>');  ?>
    						<?php echo $item['Comment']; ?>
    					</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>