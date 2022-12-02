<main>

    <div id="loading"></div>

    <div id="profile">
        <h1 id="nome"></h1>
    </div>

    <script>

        const loading = document.querySelector("#loading")
        loading.innerHTML = "Carregando"
        const user_storage = JSON.parse(localStorage.getItem("user"))

        if(user_storage) {

                async function exec() {
                    let user = {}
                
                    async function getUser(){
                        
                        const token = localStorage.getItem("token")

                        if (token) {
                            try {
                                const config = {
                                    headers:{
                                        'Authorization': `Bearer ${token}`
                                    }
                                };
                                const request = await axios.get(`http://localhost/Olympo%20Tournaments/api/user/${user_storage.attributes.username}`, config)
                                user = request.data.data
                            } catch(e) {
                                console.log(e)
                            }
                            
                        }
                    }

                    await getUser()
               
                    if(Object.keys(user).length != 0) {
                        const profile = document.querySelector("#profile")
                        const nome = document.querySelector("#nome")
                        nome.innerHTML = user.attributes.name
                    } else {
                        window.location.href = `/olympo/login`
                    }
                }
                exec();
                loading.innerHTML = "deu"

        } else {
            window.location.href = `/olympo/login`
        }
        

        
</script>

</main>