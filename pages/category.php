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
                .sport-info-container {
                    width: 100%;
                    height: 250px;
                    background-color: var(--blue2);
                    padding: 16px;
                    display: flex;
                    align-items: center;
                    border-radius: 16px;
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                    justify-content: space-between;
                }

                .sport-info-container-left {
                    display: flex;
                    align-items: center;
                }

                /* .sport-info-container-right {}
                #sport-name {}
                #total-sports {} */
                #sport-logo {
                    background-color: var(--blue3);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    width: 200px;
                    height: 200px;
                    border-radius: 16px;
                }

                .sport-info {
                    margin-left: 16px;
                }

                #sport-description {
                    width: 100%;
                    max-width: 700px;
                }

                .open-tournaments {
                    padding: 24px;
                    width: 100%;
                    height: calc(100% - 250px - 24px);
                }

                .tournament-single {
                    /* width: 100%; */
                    /* max-width: 700px; */
                    /* width: 700px; */
                    height: 160px;
                    background-color: var(--blue2);
                    border-radius: 12px;
                    margin: 8px 8px 0 8px;
                }

                .tournament-single a {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 12px;
                }

                .tournament-single .tournament-info {
                    display: flex;
                    align-items: center;
                }

                .tournament-single .tournament-info .tournament-details {
                    margin-left: 16px;
                }

                .tournament-single .tournament-logo {
                    width: 90px;
                    height: 90px;
                    background-color: var(--blue3);
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                }

                #tournaments-content {
                    overflow-y: scroll;
                    width: 100%;
                    height: 100%;
                    scrollbar-width: thin;
                    scrollbar-color: #3D3D43 #727279;
                }

                /* Works on Chrome, Edge, and Safari */
                #tournaments::-webkit-scrollbar {
                    width: 12px;
                }

                #tournaments::-webkit-scrollbar-track {
                    background: #727279;
                    border-radius: 20px;
                    border-top-left-radius: 0;
                    border-bottom-left-radius: 0;
                }

                #tournaments-content::-webkit-scrollbar-thumb {
                    background-color: #3D3D43;
                    border-radius: 20px;
                    border-top-left-radius: 0;
                    border-bottom-left-radius: 0;
                    /* border: 3px solid orange; */
                }
            </style>
            <div class="container" id="container">
                <div class="sport-info-container">
                    <div class="sport-info-container-left">
                        <div id="sport-logo"></div>
                        <div class="sport-info">
                            <h2 id="sport-name"></h2>
                            <p id="sport-description"></p>
                        </div>
                    </div>
                    <div class="sport-info-container-right">
                        <h2 id="total-sports"></h2>
                    </div>
                </div>
                <div class="open-tournaments">
                    <h2>Torneios abertos:</h2>
                    <div id="tournaments-content"></div>
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
                            async function getSport() {

                                const urlParams = new URLSearchParams(window.location.search);
                                const sportId = urlParams.get('q');

                                if (!sportId) {
                                    document.querySelector("#container").innerHTML = `<div class="category-not-found"><h1>Nenhuma categoria encontrada!</h1></div>`
                                }

                                try {
                                    const request = await axios.get(`${urlApi}/tournament/categories/${sportId}`, config)

                                    const sport = request.data.data;

                                    const image = document.querySelector("#sport-logo")
                                    const name = document.querySelector("#sport-name")
                                    const description = document.querySelector("#sport-description")

                                    image.style.backgroundImage = `url('${sport.attributes.image}')`
                                    name.innerHTML = sport.attributes.name
                                    description.innerHTML = `Até ${sport.attributes.sport_members} membros na equipe`

                                    await getTournamentsBySport(sport.id)

                                } catch (error) {
                                    console.log(error)
                                    document.querySelector("#container").innerHTML = `<div class="category-not-found"><h1>Nenhuma categoria encontrada!</h1></div>`
                                }
                            }
                            async function getTournamentsBySport(sportId) {
                                try {
                                    const request = await axios.get(`${urlApi}/find_tournament/category/${sportId}`, config)

                                    const tournaments = request.data.data;

                                    const totalContainer = document.querySelector("#total-sports")

                                    const activeTournaments = tournaments.filter((tournament) => {
                                        return tournament.attributes.active == true && tournament.attributes.privacy == "open"
                                    })

                                    totalContainer.innerHTML = `${activeTournaments.length} torneios ativos`

                                    const tournamentsContainer = document.querySelector("#tournaments-content")

                                    activeTournaments.map((tournament) => {
                                        tournamentsContainer.innerHTML += `                                       
                                        <div class="tournament-single">
                                        <a href="tournament?q=${tournament.id}">
                                                <div class="tournament-info">
                                                    <div class="tournament-logo" style="background-image: url('${tournament.attributes.photo}')"></div>
                                                    <div class="tournament-details">
                                                        <h2 class="tournament-name">${tournament.attributes.name}</h2>
                                                        <p class="tournament-description">${tournament.attributes.description}</p>
                                                    </div>
                                                </div>
                                                <h2 class="tournament-game">${tournament.attributes.sport}</h2>
                                                </div>
                                                </a>
                                                `
                                    })
                                } catch (error) {
                                    console.log(error)
                                    document.querySelector("#tournaments-content").innerHTML = `<div class="category-not-found"><h1>Nenhuma categoria encontrada!</h1></div>`
                                }
                            }
                            await getUser()
                            await getSport()
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