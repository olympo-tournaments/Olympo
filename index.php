<?php
    include("config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NOME_EMPRESA;?></title>
    <meta name="keywords" content="plataforma, gestao, campeonatos, futebol, basquete, sites, jogos, fortnite, valorant">
    <meta name="description" content="Página de gestão de campeonatos">
    <meta name="author" content="Grupo Olympo">
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo INCLUDE_PATH;?>assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH;?>css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="shortcut icon" href="<?php echo INCLUDE_PATH;?>assets/favicon.ico" type="image/x-icon">

    <script>
        // const urlApi = "http://localhost/Olympo%20Tournaments"
        const urlApi = "http://molian.com.br/olympo_api"

    async function refreshToken(error) {
        return new Promise(async (resolve, reject) => {
            try {
                const refresh_token = localStorage.getItem("refresh_token");
                const token = localStorage.getItem("token")
                const header = {
                    "Content-Type": "application/json",
                    Authorization: token,
                };
                const parameters = {
                    method: "POST",
                    headers: header,
                };
                const body = {
                    refresh_token,
                };
                const res = await axios.post(`${urlApi}/api/refresh`,body,parameters)
                if(!res) {
                    console.log("erro")
                    return reject(res)
                } else {
                    return resolve(res)
                }
                    
            } catch (err) {
                return reject(err);
            }
        });
    };


        const token = localStorage.getItem("token")
        axios.interceptors.response.use(function (response) {
            return response;
        }, async function (error) {
                // console.log(error)
                if (error.response.status === 401 && token && error.response.data.errors[0].title == "ERR_TOKEN_EXPIRED") {
                    const response = await refreshToken(error);
                    const user = response.data.data
                    error.config.headers['Authorization'] = 'Bearer ' + user.token.access_token;
                    localStorage.setItem("access_token", user.token.access_token);
                    localStorage.setItem("refresh_token", user.token.refresh_token);
                    // error.config.baseURL = undefined;
                    return axios.request(error.config);

                    // console.log(response)
                    // return response;
                } else if(error.response.status === 401 && token && error.response.data.errors[0].title == "ERR_INVALID_REFRESH") {
                    window.location.href = `/olympo/login`
                    return error
                }

            return Promise.reject(error);
        });        


    </script>

    <style type="text/css">
        .visible {
            display: block;
        }
        .invisible {
            display: none;
        }
    </style>

</head>

<body>

    <?php
        Site::carregarPagina();
    ?>
    <script src="js/scripts.js"></script>

</body>

</html>