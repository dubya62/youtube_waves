<!-- navbar.php -->
<nav>
    <ul>
        <li><a href="../landing_page/about.php">About</a></li>
        <li><a href="../home_page/home_page.php">Discover</a></li>
        <li><a href="../profile/profile.php">Profile</a></li>
        <li><a href="../settings/settings.php">Settings</a></li>
    </ul>
</nav>

<style>
    nav {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: var(--color-bg-secondary);
        padding: 1em;
        z-index: 1000;
        border-style: solid;
        border-color: black;
        border-width: 3px;
    }
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        text-align: center;
    }
    li {
        display: inline-block;
    }
    li a {
        display: inline-block;
        color: #B0B0B0;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        pointer: cursor;
    }
    li a:hover {
        background-color: var(--color-shadow);
    }
</style>
