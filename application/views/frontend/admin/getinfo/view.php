<div class="table-responsive">
    <table class="table ">
        <thead>
            <tr>
                <th>#</th>
                <th>End Date</th>
                <th># View</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($collections) && $collections != null) : ?>
                <?php foreach ($collections as $key => $item): ?>  
                    <tr>
                        <td><?php echo (@$item['Status'] == 1) ? "Current" : ($key+1); ?></td>
    					<td><?php echo date('m/d/Y', strtotime($item['Created_At'])); ?></td>
    					<td><?php echo $item['Views']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>