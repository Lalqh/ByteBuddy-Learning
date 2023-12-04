import { hideLoader, showLoader } from "../Generals/animation.js";
import { checkTypeUser, closeSession } from "../Generals/authManger.js";
import { restedPassoword } from "../Generals/functions.js";
import { postData } from "../Generals/requests.js";
import { listOfUsers } from "./doom.js";

checkTypeUser();

const closeSessionLink = document.getElementById('sesion');
closeSessionLink.addEventListener('click', closeSession);

const restPassword = document.getElementById('pas');
restPassword.addEventListener('click', restedPassoword);


const firstReq = new FormData();
firstReq.append('req', 'get_users');
const grid = document.querySelector('#data');
showLoader();
postData('../../models/admin.php', firstReq)
    .then((resp) => {
        if (resp.code === "ok") {
            hideLoader();
            let users = new listOfUsers(grid);
            users.render(resp.data);
        }
    });