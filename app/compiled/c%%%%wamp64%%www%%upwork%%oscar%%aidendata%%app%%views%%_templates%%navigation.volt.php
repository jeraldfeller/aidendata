<div id="sidebar-default" class="main-sidebar">
    <div class="current-user">
        <a href="index.html" class="name">
            <img class="avatar" src="images/avatars/aiden.jpg">
            <span>
                <?= $this->session->get('auth')['user']->name ?>
                <i class="fa fa-chevron-down"></i>
            </span>
        </a>
        <ul class="menu">
            <li>
                <a href="<?= $this->url->get('login/destroy') ?>">Logout</a>
            </li>
        </ul>
    </div>
    <div class="menu-section">

        <h3>General</h3>
        <ul>
            <li>
                <a href="<?= $this->url->get('dashboard') ?>" <?php if ($this->router->getControllerName() == 'dashboard') { ?> class="active"<?php } ?>>
                    <i class="ion-stats-bars"></i> 
                    <span>Dashboard</span>
                </a>
                <a href="<?= $this->url->get('admin') ?>" <?php if ($this->router->getControllerName() == 'admin') { ?> class="active"<?php } ?>>
                    <i class="ion-android-earth"></i> 
                    <span>Newsfeed</span>
                </a>
                <li>
                    <a href="<?= $this->url->get('pdfs') ?>" <?php if ($this->router->getControllerName() == 'pdfs') { ?> class="active"<?php } ?>>
                        <i class="ion-pricetags"></i> 
                        <span>Documents</span>
                    </a>
                </li>
            </li>

        </ul>

    </div>

    <div class="menu-section">

        <h3>Settings</h3>
        <ul>

            <li>
                <a href="<?= $this->url->get('phrases') ?>" <?php if ($this->router->getControllerName() == 'phrases') { ?> class="active"<?php } ?>>
                    <i class="ion-pricetags"></i> 
                    <span>Phrases</span>
                </a>
            </li>

            <li>
                <a href="<?= $this->url->get('sources') ?>" <?php if ($this->router->getControllerName() == 'sources') { ?> class="active"<?php } ?>>
                    <i class="ion-pricetags"></i> 
                    <span>Sources</span>
                </a>
            </li>

            <li>
                <a href="<?= $this->url->get('management') ?>" <?php if ($this->router->getControllerName() == 'management') { ?> class="active"<?php } ?>>
                    <i class="ion-usb"></i> 
                    <span>Management</span>
                </a>

            </li>

        </ul>

    </div>
    
</div>