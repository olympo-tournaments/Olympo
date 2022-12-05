<style>

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
                .vertical-line {
                    height: 90%;
                    border-left: 2px solid var(--gray1);
                    opacity: 0.3;
                }

                form {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    justify-content: space-around;
                    margin-top: 36px;
                    align-items: center;
                }

                .container {
                    width: 100%;
                    /* height: 100%; */
                    height: calc(100% - (64px + 16px));
                }

                .content-left-create-tournament {
                    width: 40%;
                }

                .content-right-create-tournament {
                    width: 40%;
                }

                label {
                    display: block;
                }

                input[type=text] {
                    height: 60px;
                    width: 100%;
                    max-width: 700px;
                }

                .form-wraper {
                    width: 100%;
                    margin: 36px 0;
                }

                .form-wraper label {
                    font-size: 1.2rem;
                    font-weight: bold;
                    margin-bottom: 8px;
                }

                textarea {
                    resize: none;
                    height: 200px;
                    width: 100%;
                    max-width: 700px;
                    background-color: var(--blue1);
                    border-radius: 16px;
                    outline: 0;
                    border: 0;
                    padding: 12px;
                    color: var(--gray1);
                    font-size: 14px;
                    scrollbar-width: thin;
                    scrollbar-color: #3D3D43 #727279;
                }

                /* Works on Chrome, Edge, and Safari */
                textarea::-webkit-scrollbar {
                    width: 12px;
                }

                textarea::-webkit-scrollbar-track {
                    background: #727279;
                    border-radius: 20px;
                    border-top-left-radius: 0;
                    border-bottom-left-radius: 0;
                    
                }

                textarea::-webkit-scrollbar-thumb {
                    background-color: #3D3D43;
                    border-radius: 20px;
                    cursor: pointer;
                    border-radius: 20px;
                    border-top-left-radius: 0;
                    border-bottom-left-radius: 0;
                    /* border: 3px solid orange; */
                }

                .form-radio-group {
                    display: flex;
                    justify-content: space-between;
                }

                .group-radio {
                    margin: 16px 0;
                }

                .form-radio-group label {
                    display: inline;
                }

                .color-radio input[type=radio] {
                    visibility: hidden;
                }

                .color-radio label {
                    display: flex;
                    width: 150px;
                    height: 150px;
                    background-color: var(--blue1);
                    border-radius: 16px;
                    justify-content: center;
                    align-items: center;
                    font-size: 1.2rem;

                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                }

                .color-radio input[type="radio"]:checked+label {
                    background-color: #ccf;
                }

                .form-radio-group-color {
                    display: flex;
                }

                .form-radio-group-color .form-wraper,
                .form-radio-group .form-wraper {
                    margin: 0;
                }

                button.button-submit {
                    width: 100%;
                    height: 60px;
                    font-size: 1.3rem;
                    font-weight: bold;
                    text-transform: capitalize;
                    color: white;
                }
            </style>
            <div class="container">
                <form id="form">
                    <div class="content-left-create-tournament">
                        <h2>Criar Torneio</h2>
                        <div class="form-wraper">
                            <label for="nome">Nome do campeonato</label>
                            <input type="text" id="nome" placeholder="Nome">
                        </div>
                        <div class="form-wraper">
                            <label for="desc">Descrição do campeonato</label>
                            <textarea id="desc" cols="30" rows="10" placeholder="Descrição"></textarea>
                        </div>
                        <div class="form-radio-group">
                            <div class="form-radio-column">
                                <h3>Formato</h3>
                                <div class="group-radio">
                                    <div class="form-wraper">
                                        <input type="radio" name="format" id="online">
                                        <label for="online">Online</label>
                                    </div>
                                    <div class="form-wraper">
                                        <input type="radio" name="format" id="presencial">
                                        <label for="presencial">Presencial</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column">
                                <h3>Privacidade</h3>
                                <div class="group-radio">
                                    <div class="form-wraper">
                                        <input type="radio" name="privacy" id="open">
                                        <label for="open">Aberto</label>
                                    </div>
                                    <div class="form-wraper">
                                        <input type="radio" name="privacy" id="only-invites">
                                        <label for="only-invites">Somente Convidados</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vertical-line"></div>
                    <div class="content-right-create-tournament">
                        <h3>Escolha o esporte</h3>
                        <div id="receive-games">
                            <div class="form-radio-group-color"></div>
                        </div>
                        <h3>Escolha o estilo de jogo</h3>
                        <div class="form-radio-group-color">
                            <div class="form-wraper color-radio">
                                <label for="ranked">Ranqueada</label>
                                <input type="radio" name="style" id="ranked">
                            </div>
                            <div class="form-wraper color-radio">
                                <label for="1v1">1v1</label>
                                <input type="radio" name="style" id="1v1">
                            </div>
                            <div class="form-wraper color-radio">
                                <label for="fun">Diversão</label>
                                <input type="radio" name="style" id="fun">
                            </div>
                        </div>
                        <button type="submit" class="button-submit">Criar Torneio</button>
                        <!-- <input type="radio" name="imagem" id="i1" />
                        <label for="i1"><img src="http://vkontakte.ru/images/gifts/256/81.jpg" alt=""></label>
                        <input type="radio" name="imagem" id="i2" />
                        <label for="i2"><img src="http://vkontakte.ru/images/gifts/256/82.jpg" alt=""></label>
                        <input type="radio" name="imagem" id="i3" />
                        <label for="i3"><img src="http://vkontakte.ru/images/gifts/256/83.jpg" alt=""></label> -->
                    </div>
                </form>
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

                            async function getCategory() {

                                try {
                                    const request = await axios.get(`http://localhost/Olympo%20Tournaments/tournament/categories`, config)

                                    const receiveCategories = document.querySelector("#receive-games .form-radio-group-color")
                                    const categories = request.data.data
                                    categories.slice(0, 4).map((category) => {
                                        console.log(category)
                                        
                                        receiveCategories.innerHTML += `
                                        <div class="form-wraper color-radio">
                                            <label for="${category.name}" style="background-image: url('${category.attributes.image}')"></label>
                                            <input type="radio" name="game" id="${category.name}">
                                        </div>
                                            `
                                    })

                                } catch (e) {
                                    console.log(e)
                                }
                            }
                            await getUser()
                            getCategory()
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

            const form = document.querySelector("#form")
            form.addEventListener("submit", createTournament)

            async function createTournament(e) {
                e.preventDefault();

                alert("teste")
            }
        </script>

    </main>
</div>