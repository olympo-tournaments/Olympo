<style>
    .container {
        display: flex;
        justify-content: space-between;
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
    }

    .content-left-home {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: space-around;
        flex-direction: column;
    }

    .content-right-home {
        width: 500px;
        /* height: 100%; */
        height: calc(100% - 220px);
        /* display: flex; */
        justify-content: space-around;
        flex-direction: column;

    }

    .banner-home {
        background-color: var(--blue1);
        width: 100%;
        max-width: 1024px;
        height: 250px;
        border-radius: 16px;
    }

    .buttons-home {
        display: flex;
        /* margin: 24px 0; */
    }

    .buttons-home a:nth-of-type(2) {
        margin-left: 16px;
    }

    .buttons-home-single {
        background-color: var(--blue1);
        width: 150px;
        border-radius: 16px;
        height: 150px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .buttons-home-single h3 {
        text-align: center;
        font-size: 16px;
        font-weight: normal;
        margin-top: 8px;
    }

    .categories-home h2 {
        margin-bottom: 16px;
    }

    .categories-home>div {
        display: flex;
        flex-direction: row;
    }

    .categories-home>div>a {
        margin-left: 16px;
    }

    .category-home {
        background-color: var(--blue1);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 150px;
        border-radius: 16px;
        height: 150px;
    }

    .category-home:first-of-type {
        margin: 0
    }

    .credits-home {
        background-color: var(--blue1);
        width: 100%;
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

    .next-tournaments-home {
        background-color: var(--blue1);
        width: 100%;
        height: 100%;
        padding: 16px;
        border-radius: 16px;
    }
    .match-home {
        background-color: var(--blue2);
        padding: 12px;
        display: flex;
        align-items: center;
    }
    .logo-tournament {
        background-color: var(--blue1);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 50px;
        height: 50px;
    }
    .match-home .tournament-content {
        margin-left: 4px;
    }
    #next-tournament-container {
        padding: 4px 0;
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
                <section class="content-left-home">
                    <div class="banner-home"></div>
                    <div class="buttons-home">
                        <a href="<?php echo INCLUDE_PATH;?>create-tournament">
                            <div class="buttons-home-single">
                                <img src="<?php echo INCLUDE_PATH; ?>assets/swords.png" alt="Create Tournament">
                                <h3>Criar um torneio</h2>
                            </div>
                        </a>
                        <a href="<?php echo INCLUDE_PATH;?>tournaments">
                            <div class="buttons-home-single">
                                <img src="<?php echo INCLUDE_PATH; ?>assets/search.png" alt="Join a Tournament">
                                <h3>Procurar um torneio</h2>
                            </div>
                        </a>
                    </div>
                    <div class="categories-home">
                        <h2>Principais Categorias</h2>
                        <div id="receive-categories">

                        </div>
                    </div>
                </section>
                <section class="content-right-home">
                    <div class="credits-home">
                        <a href="<?php echo INCLUDE_PATH . "credits"; ?>">
                            <h2>Créditos</h2>
                            <div>
                                <img src="<?php echo INCLUDE_PATH; ?>assets/credits.png" alt="Credits">
                                <h3>0</h3>
                            </div>
                        </a>
                    </div>
                    <div class="next-tournaments-home">
                        <h2>Próximos</h2>
                        <div id="next-tournament-container"></div>
                    </div>
                </section>
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
                                    const request = await axios.get(`${urlApi}/api/user/${user_storage.attributes.username}`, config)

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
                            async function getCategory() {

                                try {
                                    const request = await axios.get(`${urlApi}/tournament/categories`, config)

                                    const receiveCategories = document.querySelector("#receive-categories")
                                    const categories = request.data.data
                                    categories.slice(0, 4).map((category) => {
                                        receiveCategories.innerHTML += `
                                        <a href="<?php echo INCLUDE_PATH; ?>category?q=${category.attributes.name}"><div class="category-home" style="background-image: url('${category.attributes.image}')"></div></a>
                                    `
                                    })

                                } catch (e) {
                                    console.log(e)
                                }
                            }
                            async function getUserMatches() {
                                const nextMatchesContainer = document.querySelector("#next-tournament-container")
                                try {
                                    const request = await axios.get(`${urlApi}/user/matches`, config)
                                    console.log(request)
                                    const matches = request.data.data
                                    if (matches.length != 0) {
                                        matches.slice(0, 6).map((match) => {
                                            nextMatchesContainer.innerHTML += `
                                                <a href="<?php echo INCLUDE_PATH; ?>match?q=${match.id}"><div class="match-home">
                                                    <div class="logo-tournament"></div>
                                                    <div class="tournament-content">
                                                        <h4 id="name-tournament"></h4>
                                                        <h5>${match.attributes.team1.name} X ${match.attributes.team2.name}</h5>
                                                        <date>${match.attributes.time}</date>
                                                    </div>
                                                </div></a>
                                             `
                                        })
                                    } else {
                                        nextMatchesContainer.innerHTML = `Nenhuma partida encontrada`
                                    }
                                } catch (error) {
                                    if (error.response.data.errors[0].title == "ERR_TOURNAMENT_NOT_FOUND") {
                                        nextMatchesContainer.innerHTML = `Nenhuma partida encontrada`
                                    } else {
                                        console.log(error)
                                    }
                                }

                            }

                            await getCategory()
                            await getUser()
                            await getUserMatches()
                        }


                        // if(Object.keys(user).length != 0) {
                        //     const profile = document.querySelector("#profile")
                        //     const nome = document.querySelector("#nome")
                        //     nome.innerHTML = user.attributes.name
                        // } else {
                        //     window.location.href = `/olympo/login`
                        // }
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