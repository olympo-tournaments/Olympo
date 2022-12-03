<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
        background-color: var(--blue1);
        border-radius: 16px;
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
            <style>
                .tournament-info-container {
                    width: 100%;
                    height: 250px;
                    background-color: var(--blue2);
                    padding: 16px;
                    display: flex;
                    align-items: center;
                }

                .tournament-info-container .tournament-logo {
                    background-color: var(--blue3);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                }

                .tournament-info-container .tournament-info {
                    margin-left: 16px;
                }

                .tournament-info-container .tournament-info #tournament-description {
                    width: 100%;
                    max-width: 700px;
                }

                .tournament-content {
                    width: 100%;
                    padding: 24px;
                }

                .tournament-extra {
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                }

                .tournament-extra iframe {
                    width: 500px;
                    height: 300px;
                }

                .tournament-extra .tournament-details {
                    width: 500px;
                    height: 200px;
                    background-color: var(--blue2);
                    border-radius: 16px;
                    padding: 12px;
                    display: flex;
                    align-items: center;
                }

                .tournament-extra .tournament-details #tournament-game-image {
                    background-color: var(--blue3);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    width: 150px;
                    height: 150px;
                }

                .tournament-extra .tournament-details .tournament-game-details-right {
                    margin-left: 16px;
                }

                .next-matches {
                    margin: 24px 0;
                }
                #next-matches {
                    margin: 12px 0;
                }
                #next-matches .next-game-single {
                    background-color: var(--blue2);
                    padding: 16px 24px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 16px;
                }

                #next-matches .next-game-single .tournament-logo {
                    background-color: var(--blue3);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    width: 64px;
                    height: 64px;
                }
            </style>
            <div class="container" style="overflow-y: auto;" id="content">
                <div class="tournament-info-container">
                    <div class="tournament-logo"></div>
                    <div class="tournament-info">
                        <h2 id="tournament-name"></h2>
                        <p id="tournament-description"></p>
                    </div>
                </div>
                <div class="tournament-content">
                    <div class="tournament-extra">
                        <div class="tournament-details">
                            <div id="tournament-game-image"></div>
                            <div class="tournament-game-details-right">
                                <h3 id="tournament-game-name"></h3>
                                <h3 id="tournament-game-players"></h3>
                            </div>
                        </div>
                        <div id="tournament-live"></div>
                    </div>
                    <div class="next-matches">
                        <h2>Próximas Partidas</h2>
                        <div id="next-matches"></div>
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
                            async function getSportDetails(sportId) {
                                const image = document.querySelector("#tournament-game-image")
                                const name = document.querySelector("#tournament-game-name")
                                const players = document.querySelector("#tournament-game-players")

                                try {
                                    const request = await axios.get(`${urlApi}/tournament/categories/${sportId}`, config)

                                    const sport = request.data.data;

                                    image.style.backgroundImage = `url(${sport.attributes.image})`

                                    name.innerHTML = sport.attributes.name
                                    players.innerHTML = `Até ${sport.attributes.sport_members} jogadores`

                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            async function getTournamentMatches(tournamentId) {
                                const nextMatches = document.querySelector("#next-matches");
                                try {
                                    const request = await axios.get(`${urlApi}/tournament/matches/${tournamentId}`, config)

                                    console.log(request)
                                    const matches = request.data.data;

                                    matches.slice(0, 4).map((match) => {
                                        console.log(match)

                                        nextMatches.innerHTML += `
                                        <a href="<?php echo INCLUDE_PATH ?>match?q=${match.id}">
                                            <div class="next-game-single">
                                                <div class="tournament-logo"></div>
                                                <div class="tournament-details">
                                                    <h3>${match.attributes.id_tournament.name}</h3>
                                                    <h3>Team ${match.attributes.team1} x Team ${match.attributes.team2}</h3>
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

                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            async function getTournament() {
                                const container = document.querySelector("#content")
                                try {
                                    const name = document.querySelector("#tournament-name")
                                    const description = document.querySelector("#tournament-description")
                                    const photo = document.querySelector("#tournament-logo")
                                    const live = document.querySelector("#tournament-live")

                                    const urlParams = new URLSearchParams(window.location.search);
                                    const tournamentId = urlParams.get('q');

                                    if (!tournamentId) {
                                        container.innerHTML = `<div class="tournament-not-found"><h1>Torneio não encontrado!</h1></div>`
                                    }

                                    const request = await axios.get(`${urlApi}/api/tournament/${tournamentId}`, config)

                                    const tournament = request.data.data;

                                    name.innerHTML = tournament.attributes.name;
                                    description.innerHTML = tournament.attributes.description;
                                    if (tournament.attributes.photo != null) {
                                        photo.style['background-image'] = tournament.attributes.photo
                                    }
                                    if (tournament.attributes.twitch) {
                                        live.innerHTML = `<iframe src="https://player.twitch.tv/?channel=${twitch}&parent=philna.sh&autoplay=false" frameborder="0" scrolling="no" allowfullscreen="true" >
                        </iframe>`
                                    }

                                    await getSportDetails(tournament.attributes.sport)
                                    await getTournamentMatches(tournamentId)
                                } catch (error) {
                                    console.log(error)
                                    if (error.response.data.errors[0].title == "ERR_TOURNAMENT_NOT_FOUND") {
                                        container.innerHTML = `<div class="tournament-not-found"><h1>Torneio não encontrado!</h1></div>`
                                    }
                                }
                            }
                            await getUser()
                            await getTournament()
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