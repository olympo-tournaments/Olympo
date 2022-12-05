<style>
    header.navbar-header, .menu {
        width: 100%;
        height: calc(100% - (64px + 16px));
    }
    .navbar {
        background-color: var(--blue1);
        width: 90px;
        height: 100%;
        display: flex;
    }
    .menu ul{
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
    }
    .menu ul li a {
        font-size: 32px;
    }
    .menu ul li {
        margin: 8px 0;
    }
    .logo {
        padding: 8px;
        display: flex;
        justify-content: center;
    }
    .logo a {
        display: block;
        width: 64px;
        height: 64px;
        background-color: var(--blue3);
        border-radius: 50%;
    }
</style>
<aside class="navbar">
    <header class="navbar-header">
        <div class="logo">
            <a href="<?php echo INCLUDE_PATH.'dashboard';?>"></a>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="<?php echo INCLUDE_PATH.'calendar';?>"><i class="fa-solid fa-calendar"></i></a></li>
                <li><a href="<?php echo INCLUDE_PATH.'tournaments';?>"><i class="fa-solid fa-users"></i></a></li>
                <li><a href="<?php echo INCLUDE_PATH.'dashboard';?>"><i class="fa-solid fa-house"></i></a></li>
                <li><a onclick="alert('proximas atualizações')" style="cursor: pointer;"><i class="fa-solid fa-message"></i></a></li>
                <li><a onclick="alert('proximas atualizações')" style="cursor: pointer;"><i class="fa-solid fa-gear"></i></a></li>
            </ul>
        </nav>
    </header>
</aside>