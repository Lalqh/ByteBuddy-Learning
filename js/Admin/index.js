import { hideLoader, showLoader } from "../Generals/animation.js";
import { checkTypeUser } from "../Generals/authManger.js";
import { postData } from "../Generals/requests.js";
import { Users, listOfUsers } from "./doom.js";

checkTypeUser();

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