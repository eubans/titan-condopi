<div class="table-responsive">
    <table class="table ">
        <thead>
            <tr>
                <th>#</th>
    			<th>Listing</th>
                <th># Days</th>
                <th>List Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($collections) && $collections != null) : ?>
                <?php foreach ($collections as $key => $item): ?>  
                    <tr>
                        <td><?php // echo $key+1; ?><?php echo $item["ID"]; ?></td>
    					<td><a target="_blank" href="<?php echo get_link_item($item); ?>"><?php echo $item['Name']; ?></a></td>
    					<td><?php echo $item['DayLeft']; ?></td>
                        <td><?php echo date('m/d/Y', strtotime($item['Created_At'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>