<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
        background-color: var(--blue1);
        border-radius: 16px;
    }

    .tournament-info-container {
        width: 100%;
        height: 250px;
        background-color: var(--blue2);
        padding: 16px;
        display: flex;
        justify-content: space-between;
        border-radius: 16px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .tournament-info-container-left {
        display: flex;
        align-items: center;
    }

    #tournament-info-container-right {
        display: flex;
        align-items: center;
    }

    #tournament-info-container-right button {
        padding: 12px;
        border: 0;
        width: 100%;
        height: 50px;
        font-size: 1rem;
        font-weight: bold;
        text-transform: capitalize;
        color: white;
        outline: none;
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
        padding: 16px;
        height: calc(100% - 250px);
    }

    #tournament-teams {
        width: 100%;
        height: calc(100% - 32px);
        overflow-x: scroll;
        padding: 12px;
        display: flex;
    }

    #tournament-teams,
    .tournament-team-members {
        scrollbar-width: thin;
        scrollbar-color: #3D3D43 #727279;
    }

    /* Works on Chrome, Edge, and Safari */
    #tournament-teams::-webkit-scrollbar,
    .tournament-team-members::-webkit-scrollbar-thumb {
        width: 12px;
    }

    #tournament-teams::-webkit-scrollbar-track,
    .tournament-team-members::-webkit-scrollbar-thumb {
        background: #727279;
        border-radius: 20px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    #tournament-teams::-webkit-scrollbar-thumb,
    .tournament-team-members::-webkit-scrollbar-thumb {
        background-color: #3D3D43;
        border-radius: 20px;
        /* border: 3px solid orange; */
    }

    .tournament-team-single {
        width: 300px;
        height: 100%;
        background-color: var(--blue2);
        border-radius: 16px;
        margin-right: 16px;
    }

    .tournament-team-title {
        background-color: var(--blue3);
        padding: 12px;
        max-height: 80px;
        border-radius: 16px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .tournament-team-members {
        overflow-y: scroll;
        min-height: calc(100% - 60px);
        max-height: calc(100% - 80px);
        width: 100%;
        padding: 12px;
    }

    .btn-join-team {
        padding: 12px;
        border: 0;
        outline: none;
        color: white;
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
            <div class="container" id="content">
                <div class="tournament-info-container">
                    <div class="tournament-info-container-left">
                        <div class="tournament-logo"></div>
                        <div class="tournament-info">
                            <h2 id="tournament-name"></h2>
                            <p id="tournament-description"></p>
                        </div>
                    </div>
                    <div id="tournament-info-container-right"></div>
                </div>
                <div class="tournament-content">
                    <h2>Equipes Cadastradas</h2>
                    <div id="tournament-teams">

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

                            let userData = {}

                            async function getUser() {
                                try {
                                    const photo = document.querySelector("#user-photo")
                                    const name = document.querySelector("#user-name")
                                    const request = await axios.get(`${urlApi}/api/user/${user_storage.attributes.username}`, config)

                                    const user = request.data.data;
                                    const firstName = user.attributes.name.split(" ")[0];
                                    const image = user.attributes.photo

                                    userData = user

                                    name.innerHTML = `Olá, ${firstName}`;
                                    if (image != null) {
                                        photo.innerHTML = `<img src="${image}" alt="Foto do seu perfil">`
                                    }
                                } catch (error) {
                                    alert("Ocorreu um erro")
                                    console.log(error)
                                }
                            }

                            let sportDetails = {}

                            async function getSportDetails(sportId) {
                                try {
                                    const request = await axios.get(`${urlApi}/tournament/categories/${sportId}`, config)

                                    const sport = request.data.data;
                                    sportDetails = sport

                                } catch (error) {
                                    console.log(error)
                                }
                            }

                            let participa = false;

                            async function verifyUserParticipatesTournament(tournamentId) {
                                const containerRight = document.querySelector("#tournament-info-container-right")
                                try {
                                    const request = await axios.get(`${urlApi}/tournament/verify/${tournamentId}`, config)

                                    const team = request.data.data;

                                    if (team) {
                                        participa = true
                                    } else {
                                        containerRight.innerHTML += `<button class="btn-container-top" onclick="window.location.href = 'create-team?q=${tournamentId}'">Criar equipe</button>`
                                    }

                                    // image.style.backgroundImage = `url('${sport.attributes.image}')`

                                    // name.innerHTML = sport.attributes.name
                                    // players.innerHTML = `Até ${sport.attributes.sport_members} jogadores`

                                } catch (error) {
                                    console.log(error)
                                    if (error.response.data.errors[0].title == "ERR_TEAM_NOT_FOUND") {
                                        containerRight.innerHTML += `<button class="btn-container-top" onclick="window.location.href = 'create-team?q=${tournamentId}'">Criar equipe</button>`
                                    }
                                }
                            }

                            async function getTeams(tournamentId) {
                                const containerTeams = document.querySelector("#tournament-teams")
                                try {
                                    const request = await axios.get(`${urlApi}/tournament/getTeamsMembers/${tournamentId}`, config)

                                    const teams = request.data.data

                                    let arr = []

                                    Object.values(teams).map((team) => {
                                        containerTeams.innerHTML += `
                                        <div class="tournament-team-single" id="team-${team.id}">
                                            <div class="tournament-team-title">
                                                <h3 class="team-title">${team.attributes.team.name}</h3>
                                            </div>
                                            <div class="tournament-team-members">
                                                <ul>
                                                    ${team.attributes.members.map((member)=>{
                                                        return `<li>${member.name}</li>`
                                                    })}
                                                </ul>
                                               ${!participa ? team.attributes.members.length < sportDetails.attributes.sport_members ? `<button class="btn-join-team" id="btn-team-${team.id}">Entrar na equipe</button>` : "" : ""}
                                            </div>
                                        </div>`
                                        // const button = document.querySelector(`#btn-team-${team.id}`)
                                        // button.addEventListener("click", (e)=>{
                                        //     console.log(button)
                                        //     e.preventDefault()
                                        //     joinTeam(team.id)
                                        // })
                                    })

                                    const buttons = document.querySelectorAll(".btn-join-team")
                                    buttons.forEach((button)=>{
                                        button.addEventListener("click", joinTeam)
                                    })
                                } catch (error) {
                                    containerTeams.innerHTML = `<div class="tournament-not-found"><h1>Equipes não encontradas!</h1></div>`
                                    console.log(error)
                                }
                            }

                            async function joinTeam(event) {
                                try {

                                    const config = {
                                        headers: {
                                            'Authorization': `Bearer ${token}`
                                        }
                                    };
                                    const userLC = JSON.parse(localStorage.getItem("user"))
                                    const idTeam = event.target.id.split('btn-team-')[1]
                                    const body = {
                                        id_team: idTeam,
                                        id_user: userLC.id,
                                        tag: "membro"
                                    }
                                    const request = await axios.post(`${urlApi}/team/members`, body, config)
                                    window.location.reload()

                                } catch (error) {
                                    console.log(error)
                                }
                            }

                            async function getTournament(tournamentId) {
                                const container = document.querySelector("#content")
                                try {
                                    const name = document.querySelector("#tournament-name")
                                    const description = document.querySelector("#tournament-description")
                                    const photo = document.querySelector("#tournament-logo")
                                    const live = document.querySelector("#tournament-live")

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

                                    const containerRight = document.querySelector("#tournament-info-container-right")
                                    if(tournament.attributes.owner == userData.id) {
                                        containerRight.innerHTML += `<button id="start-tournament" class="btn-container-top">Iniciar torneio</button>`
                                    }

                                    await getSportDetails(tournament.attributes.sport)
                                    await verifyUserParticipatesTournament(tournamentId)
                                    await getTeams(tournamentId)
                                } catch (error) {
                                    console.log(error)
                                    if (error.response.data.errors[0].title == "ERR_TOURNAMENT_NOT_FOUND") {
                                        container.innerHTML = `<div class="tournament-not-found"><h1>Torneio não encontrado!</h1></div>`
                                    }
                                }
                            }

                            await getUser()
                            const urlParams = new URLSearchParams(window.location.search);
                            const tournamentId = urlParams.get('q');

                            const container = document.querySelector("#content")

                            if (!tournamentId) {
                                container.innerHTML = `<div class="tournament-not-found"><h1>Torneio não encontrado!</h1></div>`
                            }
                            await getTournament(tournamentId)

                            const btnStart = document.querySelector("#start-tournament")
                            if(btnStart) {
                                btnStart.addEventListener("click", startTournament)
                            }
                            async function startTournament(e) {
                                try {
                                    const body = {
                                        id_tournament: tournamentId,
                                        start: 3
                                    }
                                    const request = await axios.post(`${urlApi}/tournament/start`, body, config)

                                    window.location.href = `tournament?q=${tournamentId}`
                                    console.log(request)
                                } catch (error) {
                                    if(error.response.data.errors[0].title == "ERR_TEAM_NOT_FOUND") {
                                        alert("Precisa ter um número de equipes com total raiz de 2")
                                    } else if(error.response.data.errors[0].title == "ERR_TOURNAMENT_TEAM_TOTAL") {
                                        alert("Precisa ter um número de equipes com total raiz de 2")
                                    } else if(error.response.data.errors[0].title == "ERR_TOURNAMENT_STARTED") {
                                        alert("Torneio ja começou!")
                                    } else {
                                        alert("Ocorreu algum erro ao iniciar o tornio")
                                    }
                                }
                            }
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