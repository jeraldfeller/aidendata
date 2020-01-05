<?php if ($page->total_pages > 1) { ?>
    <nav class="text-xs-center">
        <ul class="pagination">

            <?php if ($_url['amountOfGetParams'] > 0) { ?>
                <?php $_paginationUrl = $_url['completeUrl']; ?>
            <?php } else { ?>
                <?php $_paginationUrl = $_url['baseUrl']; ?>
            <?php } ?>

            
            <?php if ($page->current > 6) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_paginationUrl ?>">First</a>
                </li>
            <?php } ?>

            
            <?php if ($page->current > 1) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . ($page->current - 1) ?>">Previous</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . ($page->current - 1) ?>">Previous</a>
                    <?php } ?>
                </li>
            <?php } ?>

            
            <?php if ($page->current - 5 > 1) { ?> 
                <?php $threePagesBack = $page->current - 5; ?>
                <?php $v15276023211iterator = range($threePagesBack, $page->current - 1); $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $i) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                    <li class="page-item">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v15276023211incr++; } ?>

                
                <li class="page-item active">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page->current ?>"><?= $page->current ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page->current ?>"><?= $page->current ?></a>
                    <?php } ?>
                </li>

                
            <?php } else { ?> 
                <?php $v15276023211iterator = range(1, $page->current); $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $i) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                    <li class="page-item<?php if ($i == $page->current) { ?> active<?php } ?>">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v15276023211incr++; } ?>
            <?php } ?>

            <?php $v15276023211iterator = range($page->current + 1, $page->current + 5); $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $i) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                <?php if ($i > $page->total_pages) { ?>
                    <?php break; ?>
                <?php } ?>

                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                    <?php } ?>
                </li>
            <?php $v15276023211incr++; } ?>


            
            <?php if ($page->next != $page->current && $page->next != 0) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page->next ?>">Next</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page->next ?>">Next</a>
                    <?php } ?>
                </li>

            <?php } ?>
        </ul>
    </nav>
<?php } ?>
