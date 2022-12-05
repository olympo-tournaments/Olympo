<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
        background-color: var(--blue1);
        border-radius: 16px;
        padding: 24px;
    }
    #next-tournament-container {
        margin-top: 16px;
    }
    #next-tournament-container .last-game-single {
        background-color: var(--blue2);
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    #next-tournament-container .last-game-single .tournament-logo {
        background-color: var(--blue3);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 64px;
        height: 64px;
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
                <h1>Calendario</h1>
                <div id="next-tournament-container"></div>

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
                            async function getUserMatches() {
                                const nextMatchesContainer = document.querySelector("#next-tournament-container")
                                try {
                                    const request = await axios.get(`http://localhost/Olympo%20Tournaments/user/allMatches`, config)
                                    console.log(request)
                                    const matches = request.data.data
                                    if (matches.length != 0) {
                                        matches.slice(0, 6).map((match) => {
                                            nextMatchesContainer.innerHTML += `
                                            <a href="<?php echo INCLUDE_PATH?>match?q=${match.id}">
                                            <div class="last-game-single">
                                                <div class="tournament-logo"></div>
                                                <div class="tournament-details">
                                                    <h3>${match.attributes.id_tournament.name}</h3>
                                                    <h3>${match.attributes.team1.name} x ${match.attributes.team2.name}</h3>
                                                </div>
                                                <div class="tournament-status">
                                                    <h4>Vitória</h4>
                                                </div>
                                                <div class="tournament-date">
                                                    <h4>${match.attributes.time}</h4>
                                                </div>
                                            </div>
                                        </a>
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
                            await getUser()
                            await getUserMatches()
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