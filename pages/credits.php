<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
    }

    .credits-home {
        background-color: var(--blue1);
        width: 300px;
        height: 170px;
        border-radius: 16px;
        margin-bottom: 24px;
        padding: 16px;
    }

    .credits-home a>div {
        display: flex;
        margin-top: 16px;
        align-items: center;
        justify-content: space-between;
        width: 60%;
    }

    .credits-home a>div h3 {
        font-size: 3rem;
    }

    .container-credits-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .img-roleta {
        width: 150px;
        height: 150px;
    }

    .credits-buttons {
        width: 300px;
        height: 170px;
        background-color: var(--blue1);
        display: flex;
        border-radius: 16px;
        justify-content: space-around;
        align-items: center;
    }

    .vertical-line {
        height: 70%;
        border-left: 2px solid var(--gray1);
        opacity: 0.3;
    }

    .btn-credits {
        /* background-color: var(--blue1); */
        width: 90px;
        height: 90px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 2.3rem;
        border: 0;
    }

</style>
<div class="root">
    <?php
    include DOCUMENT_ROOT . "/pages/partials/navbar.php";
    ?>
    <main class="inside">

        <div id="loading">
            <img src="<?php echo INCLUDE_PATH . "assets/loading.svg" ?>" alt="">
        </div>

        <div class="content">
            <header class="header-content">
                <div class="header-content-left">
                    <h1 id="user-name"></h1>
                </div>
                <div class="header-content-center">
                    <div class="header-content-center-search">
                        <input type="text" placeholder="Buscar" />
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="header-content-right">
                    <button onclick="alert('proximas atualizações')" class="btn-header">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <button id="user-photo" onclick="window.location.href = 'profile'" class="btn-header">
                        <i class="fa-solid fa-circle-user"></i>
                    </button>
                </div>
            </header>
            <div class="container">
                <div class="container-credits-top">
                    <div class="credits-home">
                        <a href="<?php echo INCLUDE_PATH . "credits"; ?>">
                            <h2>Créditos</h2>
                            <div>
                                <img src="<?php echo INCLUDE_PATH; ?>assets/credits.png" alt="Credits">
                                <h3></h3>
                            </div>
                        </a>
                    </div>
                    <img src="<?php echo INCLUDE_PATH ?>assets/roleta.png" alt="" class="img-roleta">
                    <div class="credits-buttons">
                        <button onclick="alert('proximas atualizações')" class="btn-credits">
                            <i class="fa-solid fa-store"></i>
                        </button>
                        <div class="vertical-line"></div>
                        <button onclick="alert('proximas atualizações')" class="btn-credits">
                            <i class="fa-solid fa-receipt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const loading = document.querySelector("#loading")
            const user_storage = JSON.parse(localStorage.getItem("user"))
            const content = document.querySelector(".content");

            if (user_storage) {

                try {
                    async function exec() {
                        const token = localStorage.getItem("token")

                        if (token) {

                            const config = {
                                headers: {
                                    'Authorization': `Bearer ${token}`
                                }
                            };

                            async function getUser() {
                                try {
                                    const photo = document.querySelector("#user-photo")
                                    const name = document.querySelector("#user-name")
                                    const request = await axios.get(`http://localhost/Olympo%20Tournaments/api/user/${user_storage.attributes.username}`, config)

                                    const user = request.data.data;
                                    const firstName = user.attributes.name.split(" ")[0];
                                    const image = user.attributes.photo

                                    name.innerHTML = `Olá, ${firstName}`;
                                    if (image != null) {
                                        photo.innerHTML = `<img src="${image}" alt="Foto do seu perfil">`
                                    }
                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            await getUser()
                        }

                    }
                    exec();
                    loading.style.display = "none"
                    content.style.display = "block"
                } catch (error) {
                    console.log(error)

                }

            } else {
                window.location.href = `/olympo/login`
            }
        </script>

    </main>
</div>