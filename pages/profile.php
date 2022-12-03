<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
        background-color: var(--blue1);
        border-radius: 16px;
        padding: 24px;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info #profile-photo {
        background-color: var(--blue3);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 250px;
        height: 250px;
        border-radius: 50%;
    }

    .user-info .user-info-right {
        margin-left: 16px;
    }

    .user-info #user-info-stats {
        display: flex;
        justify-content: space-around;
        background-color: var(--blue2);
        width: 300px;
        padding: 16px;
        margin-top: 16px;
    }

    .user-info #user-info-stats h2 {
        text-align: center;
    }

    .profile-content {
        margin-top: 16px;
    }

    .profile-content #last-games {
        padding: 12px 0;

    }

    .profile-content #last-games .last-game-single {
        background-color: var(--blue2);
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .profile-content #last-games .last-game-single .tournament-logo {
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
                <div class="user-info">
                    <div class="user-info-left">
                        <div id="profile-photo"></div>
                    </div>
                    <div class="user-info-right">
                        <h1 id="profile-name">Nome do usuário</h1>
                        <div id="user-info-stats">
                            <div class="user-info-stats-single" id="wins">
                                <h3>Vitórias</h3>
                                <h2>0</h2>
                            </div>
                            <div class="user-info-stats-single" id="ties">
                                <h3>Empates</h3>
                                <h2>0</h2>
                            </div>
                            <div class="user-info-stats-single" id="defeats">
                                <h3>Derrotas</h3>
                                <h2>0</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-content">
                    <h2>Ultimos Jogos</h2>
                    <div id="last-games"></div>
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
                                    const name2 = document.querySelector("#profile-name")
                                    const profilePhoto2 = document.querySelector("#profile-photo")

                                    const request = await axios.get(`http://localhost/Olympo%20Tournaments/api/user/${user_storage.attributes.username}`, config)

                                    const user = request.data.data;
                                    const firstName = user.attributes.name.split(" ")[0];
                                    const image = user.attributes.photo

                                    name.innerHTML = `Olá, ${firstName}`;
                                    name2.innerHTML = user.attributes.name;
                                    if (image != null) {
                                        photo.innerHTML = `<img src="${image}" alt="Foto do seu perfil">`
                                        profilePhoto2.style['background-image'] = image
                                    }
                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            async function getMatches() {
                                try {
                                    const lastGames = document.querySelector("#last-games")

                                    const request = await axios.get(`http://localhost/Olympo%20Tournaments/user/allMatches`, config)

                                    const matches = request.data.data

                                    matches.slice(0, 4).map((match) => {
                                        console.log(match)

                                        lastGames.innerHTML += `
                                        <a href="<?php echo INCLUDE_PATH ?>match?q=${match.id}">
                                            <div class="last-game-single">
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
                            async function getUserStats() {
                                try {
                                    const userStats = document.querySelector("#user-info-stats")

                                    const request = await axios.get(`${urlApi}/api/user/stats`, config)

                                    const stats = request.data.data

                                    console.log(stats)



                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            await getUser()
                            await getMatches()
                            await getUserStats()
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