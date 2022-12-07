<style>
    .container {
        margin: 24px 0 0 0;
        height: calc(100% - (64px + 16px));
        /* background-color: var(--blue1); */
        border-radius: 16px;
        padding: 24px;

        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    form {
        width: 50%;
        background-color: var(--gray2);
        -webkit-box-shadow: 10px 10px 5px 2px rgba(0, 0, 0, 0.52);
        -moz-box-shadow: 10px 10px 5px 2px rgba(0, 0, 0, 0.52);
        box-shadow: 10px 10px 5px 2px rgba(0, 0, 0, 0.52);
        border-radius: 10px;
        padding: 12px;
    }

    .form-wrapper label {
        display: block;
        color: black;
        font-weight: bold;
        font-size: 1.3rem;
        margin-bottom: 4px;
    }

    .form-wrapper input {
        width: 100%;
        height: 60px;
        font-size: 1.1rem;
        padding: 12px;
    }

    .form-wrapper button {
        width: 100%;
        height: 50px;
        font-size: 1.1rem;
        /* color: white; */
        border: 0;
        outline: none;
    }

    .form-wrapper {
        margin: 16px 0;
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
                <h1>Criar equipe para torneio</h1>
                <form action="" id="form">
                    <div class="form-wrapper">
                        <label for="name_team">Nome da equipe</label>
                        <input type="text" id="name_team" placeholder="Nome">
                    </div>
                    <div class="form-wrapper">
                        <button type="submit" class="btn-submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const loading = document.querySelector("#loading")
            const user_storage = JSON.parse(localStorage.getItem("user"))
            const content = document.querySelector(".content");

            const urlParams = new URLSearchParams(window.location.search);
            const tournamentId = urlParams.get('q');

            if (user_storage) {

                if (!tournamentId) {
                    content.innerHTML = `<h1>Insira um torneio para continuar!</h1>`
                }

                if (token) {

                    try {
                        const token = localStorage.getItem("token")
                        const config = {
                            headers: {
                                'Authorization': `Bearer ${token}`
                            }
                        };

                        async function exec() {

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
                            await getUser()

                        }
                        exec();
                        loading.style.display = "none"
                        content.style.display = "block"

                        const form = document.querySelector("#form")
                        form.addEventListener("submit", createTeam)

                        async function createTeam(e) {
                            e.preventDefault()
                            const name_team = document.querySelector("#name_team").value;

                            if (name_team != "") {
                                const data = {
                                    name_team,
                                    id_tournament: tournamentId
                                }
                                try {

                                    const createTeamFunction = await axios.post(`${urlApi}/api/team`, data, config)
                                    console.log(createTeamFunction)

                                    console.log(createTeamFunction)
                                    window.location.href = `tournament?q=${createTeamFunction.data.data.attributes.id_tournament}`
                                } catch (error) {
                                    // if (error.response.data.errors[0].title == "ERR_USER_INCORRECT") {
                                    //     alert("Usuário ou senha incorretos")
                                    // }
                                    console.log(error)
                                }

                            } else {
                                alert("Campos vazios")
                            }
                        }
                    } catch (error) {
                        console.log(error)

                    }
                }

            } else {
                window.location.href = `/olympo/login`
            }
        </script>

    </main>
</div>