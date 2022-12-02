<main>
    <form id="form">
        <div>
            <label for="email">email</label>
            <input type="email" id="email">
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" id="password">
        </div>
        <button type="submit">logar</button>
    </form>
    <script>
        const form = document.querySelector("#form");
        form.addEventListener("submit", login)

        async function login(e){
            e.preventDefault()
            const email = document.querySelector("#email").value;
            const password = document.querySelector("#password").value;

            if(email != "" && password != "") {
                const data = {email, password}
                try {
                    const login = await axios.post("http://localhost/Olympo%20Tournaments/api/auth", data)

                    const token = login.data.data.token
                    const user = login.data.data
                    localStorage.setItem("token", token.access_token)
                    localStorage.setItem("refresh_token", token.refresh_token)
                    localStorage.setItem("user", JSON.stringify(user))
                
                    window.location.href = `/olympo/dashboard`
                } catch (error) {
                    if(error.response.data.errors[0].title=="ERR_USER_INCORRECT"){
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