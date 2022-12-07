<style>
    .container {
            margin: 24px 0 0 0;
            height: calc(100% - (64px + 16px + 60px + 24px));
        }
        .buttons {
            display: flex;
            justify-content: end;
            margin-bottom: 24px;
        }
        .buttons button {
            height: 60px;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-left: 16px;
            cursor: pointer;
        }
        #tournament-content {
            height: 100%;
            width: 100%;
            background-color: var(--blue1);
            border-radius: 16px;
            padding: 24px;
            scrollbar-width: thin;
            scrollbar-color: #3D3D43 #727279;
            overflow-y: scroll;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* Works on Chrome, Edge, and Safari */
        #tournament-content::-webkit-scrollbar {
            width: 12px;
        }

        #tournament-content::-webkit-scrollbar-track {
            background: #727279;
            border-radius: 20px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        #tournament-content::-webkit-scrollbar-thumb {
            background-color: #3D3D43;
            border-radius: 20px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            /* border: 3px solid orange; */
        }
        .tournament-single {
            width: 100%;
            max-width: 700px;
            /* width: 700px; */
            height: 160px;
            background-color: var(--blue2);
            border-radius: 12px;
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
                <div class="buttons">
                    <button onclick="window.location.href='create-tournament'">Criar um campeonato</button>
                    <button onclick="alert('modal de entrar em campeonato')">Procurar um campeonato</button>
                </div>
                <div id="tournament-content">
                    
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

                            async function getTournaments() {
                                try {
                                    const tournamentsContainer = document.querySelector("#tournament-content")
                                    const request = await axios.get(`${urlApi}/user/tournaments`, config)

                                    const tournaments = request.data.data

                                    tournaments.map((tournament)=>{
                                        console.log(tournament)
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
                                                </a>
                                            </div>
                                        `
                                        
                                    })



                                } catch (error) {
                                    console.log(error)
                                }
                            }
                            await getUser()
                            await getTournaments()
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