<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
        background-color: var(--blue1);
        border-radius: 16px;
    }

    .match-info-container {
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

    .match-info-container-left {
        display: flex;
        align-items: center;
    }

    .match-info-container .match-logo {
        background-color: var(--blue3);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 200px;
        height: 200px;
        border-radius: 50%;
    }

    .match-info-container .match-info {
        margin-left: 16px;
    }

    .match-info-container .match-info #match-description {
        width: 100%;
        max-width: 700px;
    }

    .match-content {
        padding: 24px;
        width: 100%;
        height: calc(100% - 280px);
        display: flex;
        justify-content: space-between;
    }
    .content-left, .content-right {
        width: 50%;
        height: 100%;
    }
    .content-left {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }
    /* .tournament-extra {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .tournament-extra iframe {
        width: 500px;
        height: 300px;
    } */

    .tournament-details {
        width: 500px;
        height: 200px;
        background-color: var(--blue2);
        border-radius: 16px;
        padding: 12px 24px;
        display: flex;
        align-items: center;
    }

    .tournament-details #tournament-game-image {
        background-color: var(--blue3);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 150px;
        height: 150px;
    }

    .tournament-details .tournament-game-details-right {
        margin-left: 16px;
    }
    #table {
        display: flex;
    }
    #btn-update {
        padding: 12px;
        border: 0;
        font-weight: bold;
        width: 120px;
        font-size: 1.1rem;
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
                    <button>
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <button id="user-photo">
                        <i class="fa-solid fa-circle-user"></i>
                    </button>
                </div>
            </header>
            <div class="container" id="container">
                <div class="match-info-container">
                    <div class="match-info-container-left">
                        <div class="match-logo"></div>
                        <div class="match-info">
                            <h2 id="match-name">Nome do torneio</h2>
                            <p id="match-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae natus aspernatur optio ipsa quis voluptas omnis ad. Odit modi voluptatibus asperiores debitis laudantium? Facilis laudantium libero, delectus ipsam magnam quos!</p>
                        </div>
                    </div>
                    <div id="match-info-container-right"></div>
                </div>
                <div class="match-content">
                    <div class="content-left">
                        <h2>Equipe 1 vs Equipe 2</h2>
                        <h1>Resultado: 1x1</h1>
                        <div class="tournament-details">
                            <div id="tournament-game-image"></div>
                            <div class="tournament-game-details-right">
                                <h3 id="tournament-game-name"></h3>
                                <h3 id="tournament-game-players"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="content-right">
                        <h2>Membros:</h2>
                        <div id="table">
                            <div id="team1-members"></div>
                            <div id="team2-members"></div>
                        </div>
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

                            let userInfo = {}
                            let team_1 = {}
                            let team_2 = {}
                            const team1Container = document.querySelector("#team1-members")
                            const team2Container = document.querySelector("#team2-members")

                            async function getUser() {
                                try {
                                    const photo = document.querySelector("#user-photo")
                                    const name = document.querySelector("#user-name")
                                    const request = await axios.get(`http://localhost/Olympo%20Tournaments/api/user/${user_storage.attributes.username}`, config)

                                    const user = request.data.data;
                                    const firstName = user.attributes.name.split(" ")[0];
                                    const image = user.attributes.photo

                                    userInfo = user

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

                                    image.style.backgroundImage = `url('${sport.attributes.image}')`

                                    name.innerHTML = sport.attributes.name
                                    players.innerHTML = `Até ${sport.attributes.sport_members} jogadores`

                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            async function getMatch() {
                                const container = document.querySelector("#container")
                                const table = document.querySelector("#table")
                                try {
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const matchId = urlParams.get('q');

                                    if (!matchId) {
                                        container.innerHTML = `<div class="tournament-not-found"><h1>Torneio não encontrado!</h1></div>`
                                    }

                                    const request = await axios.get(`${urlApi}/api/match/${matchId}`, config)
                                    
                                    const match = request.data.data

                                    console.log(match)

                                    team1Container.innerHTML += `<h2>${match.attributes.team1.name}</h2>`
                                    team2Container.innerHTML += `<h2>${match.attributes.team2.name}</h2>`

                                    team_1 = match.attributes.team1
                                    team_2 = match.attributes.team2

                                    if(userInfo.id == match.attributes.id_tournament.owner) {
                                        const btnUpdateMatch = document.querySelector("#match-info-container-right")
                                        btnUpdateMatch.innerHTML = `<button id="btn-update">Atualizar</button>`
                                    }

                                    await getSportDetails(match.attributes.id_tournament.sport)

                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            async function getMatchMembers() {
                                const table = document.querySelector("#table")
                                try {
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const matchId = urlParams.get('q');

                                    if (!matchId) {
                                        container.innerHTML = `<div class="tournament-not-found"><h1>Torneio não encontrado!</h1></div>`
                                    }

                                    const request = await axios.get(`${urlApi}/api/matchMembers/${matchId}`, config)

                                    const members = request.data.data

                                    table.innerHTML += `<tbody>`

                                    members.map((member)=>{
                                        console.log(member)
                                        // console.log(member.attributes.team.id_team, team1)
                                        if(member.attributes.team.id_team == team_1.id) {
                                            // console.log(team1Container)
                                            team1Container.innerHTML += `<h3>${member.attributes.name}</h3>`
                                            console.log(team1Container)
                                        } else {
                                            team2Container.innerHTML += `<h3>${member.attributes.name}</h3>`
                                        }
                                        
                                    })

                                    table.innerHTML += `</tbody>`


                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            await getUser()
                            await getMatch()
                            await getMatchMembers()
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