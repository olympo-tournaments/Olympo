<style>
    header {
        background-color: var(--blue4);
        width: 100%;
        padding: 24px;
    }

    .container {
        margin: 0 auto;
        padding: 0 2%;
        width: 100%;
        max-width: 1200px;
    }

    header > div.container {
        width: 100%;
        color: white;
        flex-direction: row;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    header > div.container ul{
        font-size: 1.2rem;
        display: flex;
    }
    header > div.container ul li{
        margin: 0 8px;
    }
    header > div.container ul li a{
        padding: 12px;
        transition: 0.5s;
        border-radius: 5px;
    }
    header > div.container ul li a:hover{
        background-color: #ccc;
        color: black;
    }
    main {
        background-color: var(--blue1);
        width: 100%;
        height: calc(100% - 85px);
    }
</style>

<header>
    <div class="container">
        <h1>Olympo</h1>
        <nav>
            <ul>
                <li><a href="/olympo/home">Home</a></li>
                <li><a href="/olympo/login" id="login">Login</a></li>
                <li><a href="/olympo/signup" id="signup">Cadastrar</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <style>
        .banner {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 0;
        }
        .banner div {
            margin-left: 24px;
        }
        .banner img {
            max-width: 100%;
            width: 400px;
        }
        .banner button{
            margin: 8px 0;
            width: 200px;
            height: 50px;
            color: white;
            border: 0;
            outline: none;
            font-size: 1.1rem;
        }
        .banner h1 {
            color: white;
        }
        </style>
        <div class="container">
            <div class="banner">
                <img src="<?php echo INCLUDE_PATH;?>assets/undraw_controller.png" alt="Controller">
                <div>
                    <h1>Crie e participe de campeonatos!</h1>
                    <button onclick="window.location.href = 'signup'">Criar uma conta</button>
                </div>
            </div>
        </div>
</main>

<script>

</script>