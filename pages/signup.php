<style>
    main {
        background-color: var(--blue1);
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        user-select: none;
    }

    form {
        width: 100%;
        max-width: 500px;
        height: 65%;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        flex-direction: column;

        -webkit-box-shadow: 10px 10px 5px 2px rgba(0, 0, 0, 0.52);
        -moz-box-shadow: 10px 10px 5px 2px rgba(0, 0, 0, 0.52);
        box-shadow: 10px 10px 5px 2px rgba(0, 0, 0, 0.52);
    }

    .img {
        max-width: 180px;
        width: 100%;
    }

    form div {
        width: 100%;
    }

    label {
        display: block;
        font-size: 1.1rem;
    }

    input[type=email],
    input[type=password],
    input[type=text] {
        width: 100%;
        height: 40px;
        border-radius: 12px;
        border: 0;
        outline: none;
        padding: 12px;
        border-bottom: 1px solid black;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        background-color: transparent;
        color: black;
    }

    .form-wraper {
        margin: 8px 0;
    }

    form button {
        width: 100%;
        height: 50px;
        border: 0;
        outline: 0;
        color: white;
        font-size: 1.2rem;
    }

    .divider {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .divider hr {
        width: 35%;
        height: 1px;
    }
    .divider a {
        text-decoration: underline;
        color: var(--blue2);
    }
</style>

<main>
    <form id="form">
        <img src="<?php echo INCLUDE_PATH; ?>assets/logo.png" alt="" class="img">
        <div>
            <h1>Cadastro</h1>
            <div class="form-wraper">
                <label for="name">Nome</label>
                <input type="text" id="name">
            </div>
            <div class="form-wraper">
                <label for="email">E-Mail</label>
                <input type="email" id="email">
            </div>
            <div class="form-wraper">
                <label for="password">Senha</label>
                <input type="password" id="password">
            </div>
            <div class="form-wraper">
                <label for="username">Usuário</label>
                <input type="text" id="username">
            </div>
            <button type="submit" class="form-wraper">Cadastrar</button>
            <div class="divider">
                <hr>
                <a href="signup">Ou logue-se aqui</a>
                <hr>
            </div>
        </div>
    </form>
    <script>
        const form = document.querySelector("#form");
        form.addEventListener("submit", signup)

        async function signup(e) {
            e.preventDefault()
            const name = document.querySelector("#name").value;
            const username = document.querySelector("#username").value;
            const email = document.querySelector("#email").value;
            const password = document.querySelector("#password").value;

            if (email != "" && password != "" && name != "" && username != "") {
                const data = {
                    email,
                    password,
                    name,
                    username
                }
                try {
                    const cadastro = await axios.post(`${urlApi}/api/user`, data)

                    console.log(cadastro)
                    const token = cadastro.data.data.token
                    const user = cadastro.data.data
                    localStorage.setItem("token", token.access_token)
                    localStorage.setItem("refresh_token", token.refresh_token)
                    localStorage.setItem("user", JSON.stringify(user))


                    window.location.href = `/olympo/dashboard`
                } catch (error) {
                    if (error.response.data.errors[0].title == "ERR_USER_INCORRECT") {
                        alert("Usuário ou senha incorretos")
                    }
                    console.log(error)
                }

            } else {
                alert("Campos vazios")
            }
        }
    </script>
</main>