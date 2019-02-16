<div id="sidebar-default" class="main-sidebar">
    <div class="current-user">
        <a href="index.html" class="name">
            <img class="avatar" src="images/avatars/aiden.jpg">
            <span>
                {{ session.get('auth')['user'].name }}
                <i class="fa fa-chevron-down"></i>
            </span>
        </a>
        <ul class="menu">
            <li>
                <a href="{{ url('login/destroy') }}">Logout</a>
            </li>
        </ul>
    </div>
    <div class="menu-section">

        <h3>General</h3>
        <ul>
            <li>
                <a href="{{ url('dashboard') }}" {% if router.getControllerName() is 'dashboard' %} class="active"{% endif %}>
                    <i class="ion-stats-bars"></i> 
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('admin') }}" {% if router.getControllerName() is 'admin' %} class="active"{% endif %}>
                    <i class="ion-android-earth"></i> 
                    <span>Newsfeed</span>
                </a>
                <li>
                    <a href="{{ url('pdfs') }}" {% if router.getControllerName() is 'pdfs' %} class="active"{% endif %}>
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
                <a href="{{ url('phrases') }}" {% if router.getControllerName() is 'phrases' %} class="active"{% endif %}>
                    <i class="ion-pricetags"></i> 
                    <span>Phrases</span>
                </a>
            </li>

            <li>
                <a href="{{ url('sources') }}" {% if router.getControllerName() is 'sources' %} class="active"{% endif %}>
                    <i class="ion-pricetags"></i> 
                    <span>Sources</span>
                </a>
            </li>

            <li>
                <a href="{{ url('management') }}" {% if router.getControllerName() is 'management' %} class="active"{% endif %}>
                    <i class="ion-usb"></i> 
                    <span>Management</span>
                </a>

            </li>

        </ul>

    </div>
    
</div>