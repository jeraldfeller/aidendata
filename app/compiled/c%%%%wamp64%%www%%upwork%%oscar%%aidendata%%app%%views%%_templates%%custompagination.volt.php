<?php if ($page['totalPages'] > 1) { ?>
    <nav class="text-xs-center">
        <ul class="pagination">

            <?php if ($_url['amountOfGetParams'] > 0) { ?>
                <?php $_paginationUrl = $_url['completeUrl']; ?>
            <?php } else { ?>
                <?php $_paginationUrl = $_url['baseUrl']; ?>
            <?php } ?>

            
            <?php if ($page['current'] > 6) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_paginationUrl ?>">First</a>
                </li>
            <?php } ?>

            
            <?php if ($page['current'] > 1) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . ($page['current'] - 1) ?>">Previous</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . ($page['current'] - 1) ?>">Previous</a>
                    <?php } ?>
                </li>
            <?php } ?>

            
            <?php if ($page['current'] - 5 > 1) { ?>
                <?php $threePagesBack = $page['current'] - 5; ?>
                <?php $v38044883971iterator = range($threePagesBack, $page['current'] - 1); $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $i) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>
                    <li class="page-item">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v38044883971incr++; } ?>

                
                <li class="page-item active">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page['current'] ?>"><?= $page['current'] ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page['current'] ?>"><?= $page['current'] ?></a>
                    <?php } ?>
                </li>

                
            <?php } else { ?>
                <?php $v38044883971iterator = range(1, $page['current']); $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $i) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>
                    <li class="page-item<?php if ($i == $page['current']) { ?> active<?php } ?>">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v38044883971incr++; } ?>
            <?php } ?>

            <?php $v38044883971iterator = range($page['current'] + 1, $page['current'] + 5); $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $i) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>
                <?php if ($i > $page['totalPages']) { ?>
                    <?php break; ?>
                <?php } ?>

                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                    <?php } ?>
                </li>
            <?php $v38044883971incr++; } ?>


            
            <?php if ($page['next'] != $page['current'] && $page['next'] != 0) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page['next'] ?>">Next</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page['next'] ?>">Next</a>
                    <?php } ?>
                </li>

            <?php } ?>
        </ul>
    </nav>
<?php } ?>
