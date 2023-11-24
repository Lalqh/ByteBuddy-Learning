import { postData } from "../Generals/requests.js";
import { Users, listOfUsers } from "./doom.js";


const firstReq = new FormData();
firstReq.append('req', 'get_users');
const grid = document.querySelector('#data');
postData('../../models/admin.php', firstReq)
    .then((resp) => {
        console.log(resp)
        if (resp.code === "ok") {
            let users = new listOfUsers(grid);
            users.render(resp.data);
        }
    });